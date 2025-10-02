<?php
// MODIFICATO DA: Andrea Amodeo

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\LLMIntegration;
use App\Services\LLMService;
use App\Services\ContentGenerationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;


class LLMController extends Controller
{
    protected LLMService $llmService;
    protected ContentGenerationService $contentService;

    public function __construct(LLMService $llmService, ContentGenerationService $contentService)
    {
        $this->llmService = $llmService;
        $this->contentService = $contentService;
    }

    /**
     * Mostra l'interfaccia di simulazione per una campagna
     */
    public function showSimulation(Campaign $campaign)
    {
        $this->authorize('view', $campaign);

        $generations = $campaign->llmGenerations()
                               ->orderBy('created_at', 'desc')
                               ->get();

        $statistics = $this->calculateSimulationStatistics($generations);

        return view('llm.simulation', [
            'campaign' => $campaign,
            'generations' => $generations,
            'statistics' => $statistics,
            'contentTypes' => $this->getAvailableContentTypes()
        ]);
    }

    /**
     * API: Genera nuovo contenuto usando LLM
     */
    public function generateContent(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'campaign_id' => 'required|exists:campaigns,id',
            'content_type' => 'required|in:email_phishing,vishing,social_engineering,ceo_fraud,smishing,quiz_questions',
            'parameters' => 'required|array',
            'generate_voice' => 'boolean'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $campaign = Campaign::findOrFail($request->campaign_id);
        $this->authorize('update', $campaign);

        try {
            // Crea record di generazione
            $generation = LLMIntegration::create([
                'campaign_id' => $campaign->id,
                'content_type' => $request->content_type,
                'generation_parameters' => $request->parameters,
                'status' => LLMIntegration::STATUS_PENDING
            ]);

            // Dispatch job per generazione asincrona
            dispatch(function () use ($generation, $request) {
                $this->processGeneration($generation, $request->boolean('generate_voice'));
            });

            return response()->json([
                'success' => true,
                'generation_id' => $generation->id,
                'message' => 'Generazione avviata. Controlla lo stato tra qualche minuto.'
            ]);

        } catch (\Exception $e) {
            Log::error('LLM Generation Error: ' . $e->getMessage(), [
                'campaign_id' => $request->campaign_id,
                'content_type' => $request->content_type
            ]);

            return response()->json([
                'success' => false,
                'error' => 'Errore durante l\'avvio della generazione'
            ], 500);
        }
    }

    /**
     * API: Ottieni dati simulazione per una campagna
     */
    public function getSimulation(Campaign $campaign)
    {
        $this->authorize('view', $campaign);

        $generations = $campaign->llmGenerations()
                               ->completed()
                               ->get()
                               ->map(function ($generation) {
                                   return [
                                       'id' => $generation->id,
                                       'content_type' => $generation->content_type,
                                       'content' => $generation->getFormattedContent(),
                                       'has_voice' => $generation->hasVoice(),
                                       'voice_url' => $generation->voice_url,
                                       'voice_duration' => $generation->getFormattedVoiceDuration(),
                                       'created_at' => $generation->created_at->toISOString()
                                   ];
                               });

        return response()->json([
            'success' => true,
            'campaign' => [
                'id' => $campaign->id,
                'name' => $campaign->name,
                'difficulty' => $campaign->difficulty_level
            ],
            'simulations' => $generations
        ]);
    }

    /**
     * API: Esegui una simulazione specifica
     */
    public function executeSimulation(Request $request, LLMIntegration $llmGeneration)
    {
        $this->authorize('view', $llmGeneration->campaign);

        $validator = Validator::make($request->all(), [
            'user_responses' => 'required|array',
            'execution_time' => 'required|integer|min:0'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $result = $this->contentService->evaluateUserResponse(
                $llmGeneration,
                $request->user_responses,
                $request->execution_time
            );

            // Log dell'esecuzione per analytics
            Log::info('Simulation executed', [
                'user_id' => Auth::id(),
                'generation_id' => $llmGeneration->id,
                'content_type' => $llmGeneration->content_type,
                'result' => $result
            ]);

            return response()->json([
                'success' => true,
                'result' => $result
            ]);

        } catch (\Exception $e) {
            Log::error('Simulation execution error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'error' => 'Errore durante l\'esecuzione della simulazione'
            ], 500);
        }
    }

    /**
     * API: Ottieni stato di una generazione
     */
    public function getStatus(LLMIntegration $generation)
    {
        $this->authorize('view', $generation->campaign);

        return response()->json([
            'success' => true,
            'generation' => [
                'id' => $generation->id,
                'status' => $generation->status,
                'progress' => $this->calculateGenerationProgress($generation),
                'error_message' => $generation->error_message,
                'estimated_completion' => $this->estimateCompletionTime($generation)
            ]
        ]);
    }

    /**
     * Processa la generazione di contenuto
     */
    private function processGeneration(LLMIntegration $generation, bool $generateVoice = false)
    {
        try {
            $generation->update(['status' => LLMIntegration::STATUS_GENERATING]);

            $startTime = microtime(true);

            // Genera contenuto testuale
            $content = $this->llmService->generateContent(
                $generation->content_type,
                $generation->generation_parameters,
                $generation->campaign
            );

            $generationTime = (microtime(true) - $startTime) * 1000;

            $updateData = [
                'generated_content' => $content['content'],
                'model_used' => $content['model'],
                'tokens_consumed' => $content['tokens'],
                'generation_time_ms' => $generationTime,
                'quality_score' => $content['quality_score'] ?? null,
                'status' => LLMIntegration::STATUS_COMPLETED
            ];

            // Genera voce se richiesta
            if ($generateVoice && $this->supportsVoiceGeneration($generation->content_type)) {
                $voiceResult = $this->llmService->generateVoice(
                    $content['content'],
                    $generation->generation_parameters
                );

                if ($voiceResult['success']) {
                    $updateData['voice_generated'] = true;
                    $updateData['voice_url'] = $voiceResult['url'];
                    $updateData['voice_duration'] = $voiceResult['duration'];
                }
            }

            $generation->update($updateData);

        } catch (\Exception $e) {
            Log::error('Content generation failed', [
                'generation_id' => $generation->id,
                'error' => $e->getMessage()
            ]);

            $generation->update([
                'status' => LLMIntegration::STATUS_FAILED,
                'error_message' => $e->getMessage()
            ]);
        }
    }

    /**
     * Calcola statistiche di simulazione
     */
    private function calculateSimulationStatistics($generations)
    {
        return [
            'total_generations' => $generations->count(),
            'completed_generations' => $generations->where('status', LLMIntegration::STATUS_COMPLETED)->count(),
            'failed_generations' => $generations->where('status', LLMIntegration::STATUS_FAILED)->count(),
            'voice_generations' => $generations->where('voice_generated', true)->count(),
            'average_generation_time' => $generations->avg('generation_time_ms'),
            'total_tokens_used' => $generations->sum('tokens_consumed'),
            'estimated_cost' => $generations->sum(function ($gen) {
                return $gen->getEstimatedCost();
            })
        ];
    }

    /**
     * Ottieni tipi di contenuto disponibili
     */
    private function getAvailableContentTypes(): array
    {
        return [
            LLMIntegration::TYPE_EMAIL_PHISHING => [
                'name' => 'Email Phishing',
                'description' => 'Email fraudolente per training',
                'supports_voice' => false,
                'estimated_time' => 30
            ],
            LLMIntegration::TYPE_VISHING_SCRIPT => [
                'name' => 'Vishing Script',
                'description' => 'Script per chiamate fraudolente',
                'supports_voice' => true,
                'estimated_time' => 60
            ],
            LLMIntegration::TYPE_SOCIAL_ENGINEERING => [
                'name' => 'Social Engineering',
                'description' => 'Scenari di manipolazione',
                'supports_voice' => true,
                'estimated_time' => 90
            ],
            LLMIntegration::TYPE_CEO_FRAUD => [
                'name' => 'CEO Fraud',
                'description' => 'Richieste urgenti da dirigenti',
                'supports_voice' => true,
                'estimated_time' => 45
            ],
            LLMIntegration::TYPE_SMISHING => [
                'name' => 'SMS Phishing',
                'description' => 'Messaggi SMS fraudolenti',
                'supports_voice' => false,
                'estimated_time' => 15
            ],
            LLMIntegration::TYPE_QUIZ_QUESTIONS => [
                'name' => 'Quiz Questions',
                'description' => 'Domande per quiz di verifica',
                'supports_voice' => false,
                'estimated_time' => 20
            ]
        ];
    }

    /**
     * Verifica se il tipo di contenuto supporta la generazione vocale
     */
    private function supportsVoiceGeneration(string $contentType): bool
    {
        return in_array($contentType, [
            LLMIntegration::TYPE_VISHING_SCRIPT,
            LLMIntegration::TYPE_SOCIAL_ENGINEERING,
            LLMIntegration::TYPE_CEO_FRAUD
        ]);
    }

    /**
     * Calcola progress di una generazione
     */
    private function calculateGenerationProgress(LLMIntegration $generation): int
    {
        return match($generation->status) {
            LLMIntegration::STATUS_PENDING => 0,
            LLMIntegration::STATUS_GENERATING => 50,
            LLMIntegration::STATUS_COMPLETED => 100,
            LLMIntegration::STATUS_FAILED => 0,
            LLMIntegration::STATUS_CANCELLED => 0,
            default => 0
        };
    }

    /**
     * Stima tempo di completamento
     */
    private function estimateCompletionTime(LLMIntegration $generation): ?string
    {
        if ($generation->status !== LLMIntegration::STATUS_GENERATING) {
            return null;
        }

        $avgTime = $this->getAvailableContentTypes()[$generation->content_type]['estimated_time'] ?? 60;

        return now()->addSeconds($avgTime)->toISOString();
    }
}
