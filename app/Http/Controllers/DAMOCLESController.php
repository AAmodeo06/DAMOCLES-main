<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\DAMOCLES;
use App\Models\Questionnaire;
use App\Models\UserQuestionnaireAnswer;
use App\Models\QuestionnaireCampaign;

class DAMOCLESController extends Controller
{
    public function index($questionnaireCampaignId, $questionnaireId)
    {
        $questionnaireCampaign = QuestionnaireCampaign::findOrFail($questionnaireCampaignId);
        $questionnaire = Questionnaire::findOrFail($questionnaireId);

        return view('questionnaires-campaign.damocles.damocles', compact('questionnaireCampaignId', 'questionnaireId'));
    }

    public function preview()
    {
        return view('questionnaires-campaign.damocles.damocles');
    }

    public function create(Request $request)
    {
        $validatedData = $request->validate([
            'questionnaireCampaignId' => ['required', 'integer'],
            'questionnaireId' => ['required', 'integer'],
            'q1' => ['required', 'integer'],
            'q2' => ['required', 'integer'],
            'q3' => ['required', 'integer'],
            'q4' => ['required', 'integer'],
            'q5' => ['required', 'integer'],
            'q6' => ['required', 'integer'],
            'q7' => ['required', 'integer'],
            'q8' => ['required', 'integer'],
            'q9' => ['required', 'integer'],
            'q10' => ['required', 'integer'],
            'q11' => ['required', 'integer'],
            'q12' => ['required', 'integer'],
            'q13' => ['required', 'integer'],
            'q14' => ['required', 'integer'],
            'q15' => ['required', 'integer'],
            'q16' => ['required', 'integer'],
            'q17' => ['required', 'integer'],
        ]);

        $questionnaireCampaignId = $validatedData['questionnaireCampaignId'];
        $questionnaireId = $validatedData['questionnaireId'];

        $questionnaireCampaign = QuestionnaireCampaign::findOrFail($questionnaireCampaignId);

        if ($questionnaireCampaign->state == "Ongoing") {
            $alreadyAnswered = UserQuestionnaireAnswer::where([
                'user_id' => Auth::id(),
                'q_id' => $questionnaireId,
                'q_c_id' => $questionnaireCampaignId,
            ])->exists();

            // Check if the user has already answered
            if (!$alreadyAnswered) {
                $answer = DAMOCLES::create($validatedData);

                $userAnswer = [
                    'user_id' => Auth::id(),
                    'q_id' => $questionnaireId,
                    'q_c_id' => $questionnaireCampaignId,
                    'answer_id' => $answer->id,
                ];

                UserQuestionnaireAnswer::create($userAnswer);
            } else {
                return back()->with('error', 'Already answered"');
            }
        } else {
            return back()->with('error', 'Questionnaire campaign closed!');
        }

        return redirect()->route('questionnaires-campaign.index')->with('success', 'Questionnaire completed successfully!');
    }

    public function answer($userId, $questionnaireCampaignId, $questionnaireId)
    {
        $userQuestionnaireAnswer = UserQuestionnaireAnswer::where([
            ['user_id', '=', $userId],
            ['q_id', '=', $questionnaireId],
            ['q_c_id', '=', $questionnaireCampaignId],
        ])->firstOrFail();

        $id = $userQuestionnaireAnswer->answer_id;

        $damocles = DAMOCLES::findOrFail($id);

        $answers = [];
        for ($i = 1; $i <= 17; $i++) {
            $question = 'q' . $i;
            $answers[$question] = $damocles->$question;
        }

        return view('questionnaires-campaign.damocles.damocles-result', compact('damocles', 'answers'));
    }
    
    public function result($id)
    {
        $damocles = DAMOCLES::findOrFail($id);

        $answers = [];
        for ($i = 1; $i <= 17; $i++) {
            $question = 'q' . $i;
            $answers[$question] = $damocles->$question;
        }

        return view('questionnaires-campaign.damocles.damocles-result', compact('damocles', 'answers'));
    }
}
