<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\HAIS;
use App\Models\UserQuestionnaireAnswer;
use App\Models\Questionnaire;
use App\Models\QuestionnaireCampaign;
use NunoMaduro\Collision\Adapters\Phpunit\State;

class HAISController extends Controller
{
    public function index($questionnaireCampaignId, $questionnaireId)
    {
        $questionnaireCampaign = QuestionnaireCampaign::findOrFail($questionnaireCampaignId);
        $questionnaire = Questionnaire::findOrFail($questionnaireId);

        return view('questionnaires-campaign.hais.hais', compact('questionnaireCampaignId', 'questionnaireId'));
    }

    public function preview()
    {
        return view('questionnaires-campaign.hais.hais');
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
            'q18' => ['required', 'integer'],
            'q19' => ['required', 'integer'],
            'q20' => ['required', 'integer'],
            'q21' => ['required', 'integer'],
            'q22' => ['required', 'integer'],
            'q23' => ['required', 'integer'],
            'q24' => ['required', 'integer'],
            'q25' => ['required', 'integer'],
            'q26' => ['required', 'integer'],
            'q27' => ['required', 'integer'],
            'q28' => ['required', 'integer'],
            'q29' => ['required', 'integer'],
            'q30' => ['required', 'integer'],
            'q31' => ['required', 'integer'],
            'q32' => ['required', 'integer'],
            'q33' => ['required', 'integer'],
            'q34' => ['required', 'integer'],
            'q35' => ['required', 'integer'],
            'q36' => ['required', 'integer'],
            'q37' => ['required', 'integer'],
            'q38' => ['required', 'integer'],
            'q39' => ['required', 'integer'],
            'q40' => ['required', 'integer'],
            'q41' => ['required', 'integer'],
            'q42' => ['required', 'integer'],
            'q43' => ['required', 'integer'],
            'q44' => ['required', 'integer'],
            'q45' => ['required', 'integer'],
            'q46' => ['required', 'integer'],
            'q47' => ['required', 'integer'],
            'q48' => ['required', 'integer'],
            'q49' => ['required', 'integer'],
            'q50' => ['required', 'integer'],
            'q51' => ['required', 'integer'],
            'q52' => ['required', 'integer'],
            'q53' => ['required', 'integer'],
            'q54' => ['required', 'integer'],
            'q55' => ['required', 'integer'],
            'q56' => ['required', 'integer'],
            'q57' => ['required', 'integer'],
            'q58' => ['required', 'integer'],
            'q59' => ['required', 'integer'],
            'q60' => ['required', 'integer'],
            'q61' => ['required', 'integer'],
            'q62' => ['required', 'integer'],
            'q63' => ['required', 'integer'],
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
                $answer = HAIS::create($validatedData);

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

        $hais = HAIS::findOrFail($id);

        $answers = [];
        for ($i = 1; $i <= 63; $i++) {
            $question = 'q' . $i;
            $answers[$question] = $hais->$question;
        }

        return view('questionnaires-campaign.hais.hais-result', compact('hais', 'answers'));
    }

    public function result($id)
    {
        $hais = HAIS::findOrFail($id);

        $answers = [];
        for ($i = 1; $i <= 63; $i++) {
            $question = 'q' . $i;
            $answers[$question] = $hais->$question;
        }

        return view('questionnaires-campaign.hais.hais-result', compact('hais', 'answers'));
    }
}
