<?php
// Implementato da: Cosimo Mandrillo
namespace App\Http\Controllers;

use App\Models\TrainingCampaign;
use App\Models\Vulnerability;
use App\Models\PromptTemplate;
use App\Models\User;
use App\Models\LLM;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CampaignWizardController extends Controller
{
    // Mostra wizard creazione campagna - Cosimo Mandrillo
    public function create(Request $request)
    {
        $step = $request->get('step', 1);

        // Recupera dati dalle sessioni precedenti - Cosimo Mandrillo
        $campaignData = session('campaign_data', []);

        // Dati per ogni step - Cosimo Mandrillo
        $data = [
            'step' => $step,
            'campaign' => $campaignData,
            'vulnerabilities' => Vulnerability::all(),
            'templates' => PromptTemplate::all(),
            'llms' => LLM::all(),
            'fakeUsers' => User::where('isFake', true)->get(),
            'realUsers' => User::where('role', 'user')->where('isFake', false)->get(),
        ];

        return view('campaigns.wizard', $data);
    }

    // Salva dati wizard e procede - Cosimo Mandrillo
    public function store(Request $request)
    {
        $step = $request->input('current_step');
        $campaignData = session('campaign_data', []);

        // Validazione per step - Cosimo Mandrillo
        switch ($step) {
            case 1: // General Info
                $validated = $request->validate([
                    'title' => 'required|string|max:255',
                    'description' => 'required|string',
                    'vulnerability_id' => 'required|exists:vulnerabilities,id',
                    'expiration_date' => 'required|date|after:today',
                ]);
                break;

            case 2: // Training Type
                $validated = $request->validate([
                    'content_type' => 'required|in:text,audio',
                    'verbosity' => 'required|in:low,medium,high',
                ]);
                break;

            case 3: // Template Selection
                $validated = $request->validate([
                    'template_id' => 'required|exists:prompt_templates,id',
                    'llm_id' => 'required|exists:llms,id',
                    'custom_instructions' => 'nullable|string|max:1000',
                ]);
                break;

            case 4: // Fake Users
                $validated = $request->validate([
                    'fake_users' => 'required|array|min:1',
                    'fake_users.*' => 'exists:users,id',
                ]);
                break;

            case 5: // Simulation Review
                // Nessuna validazione, solo revisione
                $validated = [];
                break;

            case 6: // Final Users
                $validated = $request->validate([
                    'final_users' => 'required|array|min:1',
                    'final_users.*' => 'exists:users,id',
                ]);
                break;
        }

        // Merge dati - Cosimo Mandrillo
        $campaignData = array_merge($campaignData, $validated);
        session(['campaign_data' => $campaignData]);

        // Salva fase creazione - Cosimo Mandrillo
        if (isset($campaignData['campaign_id'])) {
            $campaign = TrainingCampaign::find($campaignData['campaign_id']);
            $campaign->update(['creation_phase' => $step]);
        }

        // Se ultimo step, crea campagna finale - Cosimo Mandrillo
        if ($step == 6) {
            return $this->finalizeCampaign($campaignData);
        }

        // Altrimenti vai al prossimo step - Cosimo Mandrillo
        return redirect()->route('campaigns.create', ['step' => $step + 1]);
    }

    // Finalizza e crea campagna - Cosimo Mandrillo
    protected function finalizeCampaign($data)
    {
        // Crea campagna - Cosimo Mandrillo
        $campaign = TrainingCampaign::create([
            'evaluator_id' => Auth::id(),
            'title' => $data['title'],
            'description' => $data['description'],
            'vulnerability_id' => $data['vulnerability_id'],
            'content_type' => $data['content_type'],
            'verbosity' => $data['verbosity'],
            'template_id' => $data['template_id'],
            'llm_id' => $data['llm_id'],
            'expiration_date' => $data['expiration_date'],
            'state' => 'draft',
            'creation_phase' => 6,
        ]);

        // Crea training sessions per utenti finali - Cosimo Mandrillo
        $llmService = app(\App\Services\LLMService::class);

        foreach ($data['final_users'] as $userId) {
            $user = User::find($userId);

            // Genera contenuto personalizzato - Cosimo Mandrillo
            $content = $llmService->generateTrainingContent(
                PromptTemplate::find($data['template_id']),
                $user,
                $data['vulnerability_id'],
                $data['custom_instructions'] ?? ''
            );

            \App\Models\TrainingSession::create([
                'user_id' => $userId,
                'training_campaign_id' => $campaign->id,
                'text' => $content['text'],
                'audio' => $content['audio'] ?? null,
                'content_type' => $data['content_type'],
                'estimated_time' => $content['estimated_time'],
                'isCompleted' => false,
            ]);
        }

        // Pulisci sessione - Cosimo Mandrillo
        session()->forget('campaign_data');

        return redirect()->route('campaigns.show', $campaign)
            ->with('success', 'Campagna creata con successo!');
    }

    // Preview simulation - Cosimo Mandrillo
    public function preview(TrainingCampaign $campaign)
    {
        $simulationResults = session('simulation_results', []);

        return view('campaigns.preview', compact('campaign', 'simulationResults'));
    }
}
