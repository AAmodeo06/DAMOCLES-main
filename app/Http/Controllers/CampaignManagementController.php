<?php
// Implementato da: Cosimo Mandrillo
namespace App\Http\Controllers;

use App\Models\TrainingCampaign;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CampaignManagementController extends Controller
{
    // Lista campagne del valutatore - Cosimo Mandrillo
    public function index(Request $request)
    {
        $filter = $request->get('state', 'all');

        $campaigns = TrainingCampaign::where('evaluator_id', Auth::id())
            ->when($filter !== 'all', function($query) use ($filter) {
                return $query->where('state', $filter);
            })
            ->with(['vulnerability', 'trainingSessions'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $stats = [
            'draft' => TrainingCampaign::where('evaluator_id', Auth::id())->where('state', 'draft')->count(),
            'ready' => TrainingCampaign::where('evaluator_id', Auth::id())->where('state', 'ready')->count(),
            'ongoing' => TrainingCampaign::where('evaluator_id', Auth::id())->where('state', 'ongoing')->count(),
            'finished' => TrainingCampaign::where('evaluator_id', Auth::id())->where('state', 'finished')->count(),
        ];

        return view('campaigns.index', compact('campaigns', 'stats', 'filter'));
    }

    // Dettagli campagna con monitoring - Cosimo Mandrillo
    public function show(TrainingCampaign $campaign)
    {
        $this->authorize('view', $campaign);

        $campaign->load([
            'vulnerability',
            'template',
            'llm',
            'trainingSessions.user',
            'trainingSessions.quiz'
        ]);

        // Statistiche - Cosimo Mandrillo
        $totalUsers = $campaign->trainingSessions->count();
        $completedUsers = $campaign->trainingSessions->where('isCompleted', true)->count();
        $averageScore = $campaign->trainingSessions->where('isCompleted', true)->avg('quiz_score');
        $completionRate = $totalUsers > 0 ? ($completedUsers / $totalUsers) * 100 : 0;

        $stats = [
            'total_users' => $totalUsers,
            'completed_users' => $completedUsers,
            'completion_rate' => round($completionRate, 2),
            'average_score' => round($averageScore, 2),
        ];

        return view('campaigns.show', compact('campaign', 'stats'));
    }

    // Cambia stato campagna (start/stop) - Cosimo Mandrillo
    public function changeState(Request $request, TrainingCampaign $campaign)
    {
        $this->authorize('update', $campaign);

        $validated = $request->validate([
            'action' => 'required|in:start,stop,finish',
        ]);

        $newState = match($validated['action']) {
            'start' => 'ongoing',
            'stop' => 'ready',
            'finish' => 'finished',
        };

        $campaign->update(['state' => $newState]);

        // Invia notifiche se si avvia - Cosimo Mandrillo
        if ($newState === 'ongoing') {
            foreach ($campaign->trainingSessions as $session) {
                \App\Models\Notification::createTrainingNotification(
                    $session->user_id,
                    $session->id,
                    $campaign->title
                );
            }
        }

        return redirect()->route('campaigns.show', $campaign)
            ->with('success', "Campagna {$validated['action']} con successo!");
    }

    // Duplica campagna - Cosimo Mandrillo
    public function duplicate(TrainingCampaign $campaign)
    {
        $this->authorize('create', TrainingCampaign::class);

        $newCampaign = $campaign->replicate();
        $newCampaign->title = $campaign->title . ' (Copia)';
        $newCampaign->state = 'draft';
        $newCampaign->evaluator_id = Auth::id();
        $newCampaign->save();

        return redirect()->route('campaigns.show', $newCampaign)
            ->with('success', 'Campagna duplicata con successo!');
    }

    // Elimina campagna - Cosimo Mandrillo
    public function destroy(TrainingCampaign $campaign)
    {
        $this->authorize('delete', $campaign);

        $campaign->delete();

        return redirect()->route('campaigns.index')
            ->with('success', 'Campagna eliminata con successo!');
    }
}
