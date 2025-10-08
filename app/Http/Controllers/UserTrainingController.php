<?php
// Implementato da: Luigi La Gioia
namespace App\Http\Controllers;

use App\Models\TrainingSession;
use App\Models\Answer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserTrainingController extends Controller
{
    // Lista training disponibili per l'utente - Luigi La Gioia
    public function index()
    {
        $user = Auth::user();

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
    }
}
