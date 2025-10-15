<?php
<<<<<<< Updated upstream
// Implementato da: Luigi La Gioia
namespace App\Http\Controllers;

use App\Models\TrainingSession;
use App\Models\Answer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserTrainingController extends Controller
{
    // Lista training disponibili per l'utente - Luigi La Gioia
=======

//REALIZZATO DA: Luigi La Gioia

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\TrainingAssignment;
use App\Models\TrainingUnit;
use App\Models\UnitCompletion;

class UserTrainingController extends Controller
{
    // /user/training → lista assegnazioni + Progress: X% + "Continua Training"
>>>>>>> Stashed changes
    public function index()
    {
        $user = Auth::user();

<<<<<<< Updated upstream
        $trainingSessions = TrainingSession::where('user_id', $user->id)
            ->with(['trainingCampaign', 'trainingCampaign.vulnerability'])
            ->orderBy('created_at', 'desc')
            ->get();

        $ongoing = $trainingSessions->where('isCompleted', false);
        $completed = $trainingSessions->where('isCompleted', true);

        return view('training.index', compact('ongoing', 'completed'));
    }

    // Mostra contenuto training specifico - Luigi La Gioia
    public function show(TrainingSession $session)
    {
        $this->authorize('view', $session);

        $session->load(['trainingCampaign', 'quiz.answers']);

        return view('training.show', compact('session'));
    }

    // Completa training session - Luigi La Gioia
    public function complete(Request $request, TrainingSession $session)
    {
        $this->authorize('complete', $session);

        $validated = $request->validate([
            'quiz_answers' => 'required|array',
            'quiz_answers.*' => 'required|exists:answers,id',
        ]);

        // Verifica risposte - Luigi La Gioia
        $correctAnswers = 0;
        $totalQuestions = $session->quiz->count();

        foreach ($validated['quiz_answers'] as $questionId => $answerId) {
            $answer = \App\Models\Answer::find($answerId);
            if ($answer && $answer->isCorrect) {
                $correctAnswers++;
            }
        }

        $score = ($correctAnswers / $totalQuestions) * 100;

        // Aggiorna session - Luigi La Gioia
        $session->update([
            'isCompleted' => true,
            'completion_date' => now(),
            'quiz_score' => $score,
        ]);

        return redirect()->route('user.training.index')
            ->with('success', "Training completato! Punteggio: {$score}%");
=======
        $assignments = TrainingAssignment::with('campaign')
            ->where('user_id',$user->id)
            ->orderByDesc('id')
            ->get();

        // calcolo progress su completamenti (via assignment_id)
        $progress = [];
        foreach ($assignments as $a) {
            $total = TrainingUnit::where('campaign_id',$a->campaign_id)->count();
            if ($total === 0) { $progress[$a->id] = 0; continue; }

            $done  = UnitCompletion::where('assignment_id',$a->id)->count();
            $progress[$a->id] = (int) floor($done * 100 / $total);
        }

        return view('user/training/index', compact('assignments','progress'));
    }

    // /user/training/units/{unit} → mostra contenuto + bottone "Completa Unit"
    public function showUnit(TrainingUnit $unit)
    {
        $user = Auth::user();

        // verifica che il user abbia un assignment su questa campagna
        $assignment = TrainingAssignment::where('user_id',$user->id)
            ->where('campaign_id',$unit->campaign_id)
            ->firstOrFail();

        return view('user/training/unit', compact('unit','assignment'));
    }

    // POST /user/training/units/{unit}/complete → crea completion, redirect /user/training con flash
    public function completeUnit(TrainingUnit $unit)
    {
        $user = Auth::user();

        $assignment = TrainingAssignment::where('user_id',$user->id)
            ->where('campaign_id',$unit->campaign_id)
            ->firstOrFail();

        UnitCompletion::updateOrCreate(
            ['assignment_id'=>$assignment->id, 'unit_id'=>$unit->id],
            ['completed_at'=>now()]
        );

        return redirect()->route('user.training.index')->with('status','Unit completata!');
>>>>>>> Stashed changes
    }
}
