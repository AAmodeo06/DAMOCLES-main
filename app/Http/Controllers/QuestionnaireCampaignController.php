<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Questionnaire;
use App\Models\QuestionnaireCampaign;
use App\Models\QuestionnaireQuestionnaireCampaign;
use App\Models\UserQuestionnaireCampaign;
use App\Models\UserQuestionnaireAnswer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QuestionnaireCampaignController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->role === 'User') {
            $userCampaigns = UserQuestionnaireCampaign::where('user_id', $user->id)
                ->with('questionnaireCampaign')
                ->get();

            $questionnairesCampaigns = $userCampaigns->map(function ($userCampaign) use ($user) {
                $campaign = $userCampaign->questionnaireCampaign;

                // Controlla se l'utente ha completato tutti i questionari della campagna
                $totalQuestionnaires = DB::table('questionnaires_questionnaires_campaigns')
                    ->where('q_c_id', $campaign->id)
                    ->count();

                $answeredQuestionnaires = DB::table('user_questionnaires_answers')
                    ->where('user_id', $user->id)
                    ->where('q_c_id', $campaign->id)
                    ->distinct('q_id')
                    ->count('q_id');

                if ($totalQuestionnaires == $answeredQuestionnaires) {
                    $userCampaign->done = true;
                    $userCampaign->save();
                }

                $campaign->user_done = $userCampaign->done;
                return $campaign;
            })->filter(function ($campaign) {
                return in_array($campaign->state, ['Ongoing', 'Finished']);
            });
        } elseif ($user->role === 'Evaluator') {
            $questionnairesCampaigns = QuestionnaireCampaign::where('evaluator_id', $user->id)->get();
        }

        return view('questionnaires-campaign.questionnaires-campaign', compact('questionnairesCampaigns'));
    }

    public function new()
    {
        $questionnaires = Questionnaire::all();

        return view('questionnaires-campaign.new-questionnaires-campaign', compact('questionnaires'));
    }

    public function questionnaires()
    {
        $questionnaires = Questionnaire::all();

        return view('questionnaires-campaign.questionnaires', compact('questionnaires'));
    }

    public function create(Request $request)
    {
        $validatedData = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'evaluatorId' => ['required', 'integer'],
            'state' => ['nullable', 'string', 'max:255'],
            'expirationDate' => ['required'],
        ]);

        $validatedData['evaluator_id'] = $validatedData['evaluatorId'];

        $questionnaireCampaign = QuestionnaireCampaign::create($validatedData);

        return redirect()->route('questionnaire-campaign.questionnaires', ['questionnaireCampaign' => $questionnaireCampaign->id]);
    }

    public function questionnairesQuestionnaireCampaign($questionnaireCampaignId)
    {
        $questionnaireCampaign = QuestionnaireCampaign::findOrFail($questionnaireCampaignId);
        $questionnaires = Questionnaire::all();
        return view('questionnaires-campaign.questionnaires-questionnaire-campaign', compact('questionnaires', 'questionnaireCampaignId'));
    }

    public function saveQuestionnairesQuestionnaireCampaign(Request $request)
    {
        $validatedData = $request->validate([
            'questionnaireCampaignId' => ['required', 'integer'],
            'questionnairesIds' => ['required', 'string'],
        ]);

        $questionnaireCampaignId = $validatedData['questionnaireCampaignId'];
        $questionnaireIds = explode(',', $validatedData['questionnairesIds']);

        QuestionnaireQuestionnaireCampaign::where('q_c_id', $questionnaireCampaignId)->delete();

        foreach ($questionnaireIds as $questionnaireId) {
            QuestionnaireQuestionnaireCampaign::create([
                'q_id' => $questionnaireId,
                'q_c_id' => $questionnaireCampaignId,
            ]);
        }

        return redirect()->route('questionnaire-campaign.users', ['questionnaireCampaign' => $questionnaireCampaignId]);
    }

    public function users($questionnaireCampaignId)
    {
        $questionnaireCampaign = QuestionnaireCampaign::findOrFail($questionnaireCampaignId);
        $questionnaireQuestionnaireCampaign = QuestionnaireQuestionnaireCampaign::where('q_c_id', $questionnaireCampaignId)->firstOrFail();
    
        $users = User::where('role', 'User')->get();
    
        return view('questionnaires-campaign.users-questionnaire', compact('questionnaireCampaignId', 'users'));
    }    

    public function saveUsersQuestionnaireCampaign(Request $request)
    {
        $validatedData = $request->validate([
            'questionnaireCampaignId' => ['required', 'integer'],
            'usersIds' => ['required'],
        ]);

        $questionnaireCampaignId = $validatedData['questionnaireCampaignId'];
        $usersIds = explode(',', $validatedData['usersIds']);

        if (empty($usersIds) || empty($questionnaireCampaignId)) {
            return response()->json(['error' => 'Users or Questionnaire Campaign Id cannot be null'], 400);
        }

        foreach ($usersIds as $userId) {
            UserQuestionnaireCampaign::create([
                'user_id' => $userId,
                'questionnaire_campaign_id' => $questionnaireCampaignId,
                'done' => false,
            ]);
        }

        $this->changeState($questionnaireCampaignId, 'Ready');

        return redirect()->route('questionnaires-campaign.index')->with('success', 'Questionnaire campaign assigned successfully.');
    }

    public function changeState($questionnaireCampaignId, $state)
    {
        $questionnaireCampaign = QuestionnaireCampaign::findOrFail($questionnaireCampaignId);
        $questionnaireCampaign->state = $state;
        $questionnaireCampaign->save();

        if ($state != 'Draft' && $state != 'Ready') {

            if ($state == 'Ongoing') {
                return redirect()->back()->with('success', 'Campaign start successfully!');
            }

            if ($state == 'Finished') {
                return redirect()->back()->with('success', 'Campaign stopped successfully!');
            }

            return redirect()->back();
        }
    }

    public function joinQuestionnaireCampaign($questionnaireCampaignId)
    {
        // Retrieve the questionnaire campaign with the specified ID
        $questionnaireCampaign = QuestionnaireCampaign::findOrFail($questionnaireCampaignId);

        // Retrieve the IDs of the questionnaires associated with the questionnaire campaign
        $questionnaireIds = QuestionnaireQuestionnaireCampaign::where('q_c_id', $questionnaireCampaignId)
            ->pluck('q_id')
            ->toArray();

        // Retrieve the questionnaires using the questionnaire IDs
        $questionnaires = Questionnaire::whereIn('id', $questionnaireIds)->get();

        return view('questionnaires-campaign.questionnaire-campaign-join', compact('questionnaireCampaign', 'questionnaires'));
    }

    public function details($questionnaireCampaignId)
    {
        $questionnaireCampaign = QuestionnaireCampaign::findOrFail($questionnaireCampaignId);

        // Retrieve the IDs of the questionnaires associated with the questionnaire campaign
        $questionnaireIds = QuestionnaireQuestionnaireCampaign::where('q_c_id', $questionnaireCampaignId)
            ->distinct()
            ->pluck('q_id')
            ->toArray();

        // Retrieve the questionnaires using the questionnaire IDs
        $questionnaires = Questionnaire::whereIn('id', $questionnaireIds)->get();

        // Retrieve the IDs of the users associated with the questionnaire campaign
        $userIds = UserQuestionnaireCampaign::where('questionnaire_campaign_id', $questionnaireCampaignId)
            ->distinct()
            ->pluck('user_id')
            ->toArray();

        // Retrieve the users using the user IDs
        $users = User::whereIn('id', $userIds)->get();

        return view('questionnaires-campaign.questionnaire-campaign-details', compact('questionnaireCampaign', 'questionnaires', 'users'));
    }

    public function analyse($questionnaireCampaignId)
    {
        $questionnaireCampaign = QuestionnaireCampaign::findOrFail($questionnaireCampaignId);

        // Retrieve the IDs of the questionnaire associated with the questionnaire campaign
        $questionnairesIds = QuestionnaireQuestionnaireCampaign::where('q_c_id', $questionnaireCampaignId)
            ->distinct()
            ->pluck('q_id')
            ->toArray();

        // Retrieve the questionnaires
        $questionnaires = Questionnaire::whereIn('id', $questionnairesIds)->get();

        // Retrieve the IDs of users associated with the questionnaire campaign
        $usersIds = UserQuestionnaireCampaign::where('questionnaire_campaign_id', $questionnaireCampaignId)
            ->distinct()
            ->pluck('user_id')
            ->toArray();

        // Retrieve the users
        $users = User::whereIn('id', $usersIds)->get();

        // Retrieve the answers of users for the questionnaires
        $userAnswers = UserQuestionnaireAnswer::whereIn('q_id', $questionnairesIds)
            ->whereIn('user_id', $usersIds)
            ->get()
            ->groupBy(['user_id', 'q_id']);

        // TODO: to fix
        // Calculate the total number of answers given for each questionnaire
        $totalAnswersPerQuestionnaire = UserQuestionnaireAnswer::select('q_id', DB::raw('count(*) as total_answers'))
            ->whereIn('q_id', $questionnairesIds)
            ->whereIn('user_id', $usersIds)
            ->groupBy('q_id')
            ->pluck('total_answers', 'q_id')
            ->toArray();

        return view('questionnaires-campaign.questionnaire-campaign-analyse', compact(
            'questionnaireCampaign',
            'questionnaires',
            'users',
            'userAnswers',
            'totalAnswersPerQuestionnaire'
        ));
    }

    public function stop($questionnaireCampaignId)
    {
        try {
            $questionnaireCampaign = QuestionnaireCampaign::findOrFail($questionnaireCampaignId);
            $this->changeState($questionnaireCampaignId, 'Finished');
            return redirect()->back()->with('success', 'Campaign stopped successfully!');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function deleteAnswer(Request $request)
    {
        $validatedData = $request->validate([
            'answerId' => ['required', 'integer'],
        ]);

        $userAnswer = UserQuestionnaireAnswer::findOrFail($validatedData['answerId']);

        $questionnaireName = $userAnswer->questionnaire->name;
        $answerId = $userAnswer->answer_id;

        // Convert the questionnaire name to uppercase
        $tableName = $questionnaireName . 's';

        // Delete the row from the specified table
        DB::table($tableName)->where('id', $answerId)->delete();

        $userAnswer->delete();
        $userAnswer->delete();

        return redirect()->back()->with('success', 'Answer deleted successfully.');
    }

    public function duplicate($questionnaireCampaignId)
    {
        try {
            $questionnaireCampaign = QuestionnaireCampaign::findOrFail($questionnaireCampaignId);

            $newQuestionnaireCampaign = $questionnaireCampaign->replicate();

            $newQuestionnaireCampaign->state = 'Draft';
            $newQuestionnaireCampaign->title .= ' (Copy)';

            $newQuestionnaireCampaign->save();

            return redirect()->back()->with('success', 'Campaign duplicated successfully!');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function destroy(QuestionnaireCampaign $questionnaireCampaign)
    {
        $questionnaireCampaign->delete();

        return redirect()->back()->with('success', 'Campaign deleted successfully!');
    }
}
