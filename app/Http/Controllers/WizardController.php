<?php
// app/Http/Controllers/WizardController.php
// REALIZZATO DA: Andrea Amodeo

namespace App\Http\Controllers;

use App\Models\WizardSession;
use App\Models\Campaign;
use App\Services\CampaignBuilderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class WizardController extends Controller
{
    protected CampaignBuilderService $campaignBuilder;

    public function __construct(CampaignBuilderService $campaignBuilder)
    {
        $this->campaignBuilder = $campaignBuilder;
    }

    /**
     * Step 1: Selezione tipi di attacco
     */
    public function step1()
    {
        // Crea nuova sessione wizard o recupera quella esistente
        $session = WizardSession::forUser(Auth::id())
                               ->incomplete()
                               ->active()
                               ->first();

        if (!$session) {
            $session = WizardSession::create([
                'user_id' => Auth::id(),
                'current_step' => 1
            ]);
        }

        $attackTypes = $this->getAvailableAttackTypes();

        return view('wizard.step1', [
            'session' => $session,
            'attackTypes' => $attackTypes,
            'progress' => $session->getProgressPercentage()
        ]);
    }

    /**
     * Processa Step 1
     */
    public function processStep1(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'attack_types' => 'required|array|min:1',
            'attack_types.*' => 'string|in:email_phishing,vishing,social_engineering,ceo_fraud,smishing',
            'intensity' => 'nullable|in:low,medium,high',
            'include_voice' => 'nullable|boolean',
            'advanced_targeting' => 'nullable|boolean'
        ], [
            'attack_types.required' => 'Seleziona almeno un tipo di attacco',
            'attack_types.min' => 'Seleziona almeno un tipo di attacco'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $session = WizardSession::forUser(Auth::id())->incomplete()->firstOrFail();

        $session->saveStepData(1, $validator->validated());
        $session->advanceToNextStep();

        return redirect()->route('wizard.step2', $session);
    }

    /**
     * Step 2: Target audience e difficoltà
     */
    public function step2(WizardSession $session)
    {
        $this->authorizeSession($session);

        if (!$session->canAdvanceToStep(2)) {
            return redirect()->route('wizard.step1')
                           ->with('error', 'Completa prima lo step precedente');
        }

        $step1Data = $session->getStepData(1);

        return view('wizard.step2', [
            'session' => $session,
            'step1Data' => $step1Data,
            'progress' => $session->getProgressPercentage(),
            'difficulties' => $this->getDifficultyLevels()
        ]);
    }

    /**
     * Processa Step 2
     */
    public function processStep2(Request $request, WizardSession $session)
    {
        $this->authorizeSession($session);

        $validator = Validator::make($request->all(), [
            'target_audience' => 'required|string|max:255',
            'difficulty' => 'required|in:beginner,intermediate,advanced',
            'company_size' => 'nullable|in:small,medium,large,enterprise',
            'industry' => 'nullable|string|max:100',
            'custom_requirements' => 'nullable|string|max:1000'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $session->saveStepData(2, $validator->validated());
        $session->advanceToNextStep();

        return redirect()->route('wizard.step3', $session);
    }

    /**
     * Step 3: Durata campagna
     */
    public function step3(WizardSession $session)
    {
        $this->authorizeSession($session);

        if (!$session->canAdvanceToStep(3)) {
            return redirect()->route('wizard.step2', $session)
                           ->with('error', 'Completa prima lo step precedente');
        }

        return view('wizard.step3', [
            'session' => $session,
            'progress' => $session->getProgressPercentage(),
            'durationPresets' => $this->getDurationPresets()
        ]);
    }

    /**
     * Processa Step 3
     */
    public function processStep3(Request $request, WizardSession $session)
    {
        $this->authorizeSession($session);

        $validator = Validator::make($request->all(), [
            'duration_weeks' => 'required|integer|min:1|max:52',
            'frequency' => 'required|in:daily,weekly,bi-weekly',
            'start_date' => 'nullable|date|after:today',
            'timezone' => 'nullable|timezone'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $session->saveStepData(3, $validator->validated());
        $session->advanceToNextStep();

        return redirect()->route('wizard.step4', $session);
    }

    /**
     * Step 4: Fattori umani
     */
    public function step4(WizardSession $session)
    {
        $this->authorizeSession($session);

        if (!$session->canAdvanceToStep(4)) {
            return redirect()->route('wizard.step3', $session)
                           ->with('error', 'Completa prima lo step precedente');
        }

        return view('wizard.step4', [
            'session' => $session,
            'progress' => $session->getProgressPercentage(),
            'humanFactors' => $this->getHumanFactors()
        ]);
    }

    /**
     * Processa Step 4
     */
    public function processStep4(Request $request, WizardSession $session)
    {
        $this->authorizeSession($session);

        $validator = Validator::make($request->all(), [
            'human_factors' => 'required|array|min:1',
            'human_factors.*' => 'string',
            'personalization_level' => 'required|in:low,medium,high',
            'behavioral_triggers' => 'nullable|array'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $session->saveStepData(4, $validator->validated());
        $session->advanceToNextStep();

        return redirect()->route('wizard.step5', $session);
    }

    /**
     * Step 5: Impostazioni notifiche
     */
    public function step5(WizardSession $session)
    {
        $this->authorizeSession($session);

        if (!$session->canAdvanceToStep(5)) {
            return redirect()->route('wizard.step4', $session)
                           ->with('error', 'Completa prima lo step precedente');
        }

        return view('wizard.step5', [
            'session' => $session,
            'progress' => $session->getProgressPercentage(),
            'notificationOptions' => $this->getNotificationOptions()
        ]);
    }

    /**
     * Processa Step 5
     */
    public function processStep5(Request $request, WizardSession $session)
    {
        $this->authorizeSession($session);

        $validator = Validator::make($request->all(), [
            'email_notifications' => 'boolean',
            'sms_notifications' => 'boolean',
            'push_notifications' => 'boolean',
            'notification_frequency' => 'required|in:immediate,daily,weekly',
            'summary_reports' => 'boolean',
            'real_time_alerts' => 'boolean'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $session->saveStepData(5, $validator->validated());
        $session->advanceToNextStep();

        return redirect()->route('wizard.step6', $session);
    }

    /**
     * Step 6: Finalizzazione
     */
    public function step6(WizardSession $session)
    {
        $this->authorizeSession($session);

        if (!$session->canAdvanceToStep(6)) {
            return redirect()->route('wizard.step5', $session)
                           ->with('error', 'Completa prima lo step precedente');
        }

        $wizardData = $session->getAllWizardData();

        return view('wizard.step6', [
            'session' => $session,
            'progress' => 100,
            'wizardData' => $wizardData,
            'summary' => $this->prepareSummary($wizardData)
        ]);
    }

    /**
     * Completa il wizard e crea la campagna
     */
    public function complete(Request $request, WizardSession $session)
    {
        $this->authorizeSession($session);

        $validator = Validator::make($request->all(), [
            'campaign_name' => 'required|string|max:255',
            'campaign_description' => 'required|string|max:1000',
            'auto_start' => 'boolean',
            'generate_content_now' => 'boolean'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();

            // Crea la campagna usando il service
            $campaign = $this->campaignBuilder->createFromWizard(
                $session,
                $validator->validated()
            );

            // Completa la sessione
            $session->complete($campaign);

            DB::commit();

            // Se richiesta generazione immediata del contenuto
            if ($request->generate_content_now) {
                return redirect()->route('llm.simulation', $campaign)
                               ->with('success', 'Campagna creata con successo! Generazione contenuti in corso...');
            }

            return redirect()->route('campaigns.show', $campaign)
                           ->with('success', 'Campagna creata con successo!');

        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with('error', 'Errore durante la creazione della campagna: ' . $e->getMessage());
        }
    }

    /**
     * Verifica autorizzazione sessione
     */
    private function authorizeSession(WizardSession $session): void
    {
        if ($session->user_id !== Auth::id()) {
            abort(403, 'Sessione non autorizzata');
        }

        if ($session->isExpired()) {
            abort(419, 'Sessione scaduta');
        }
    }

    /**
     * Ottieni tipi di attacco disponibili
     */
    private function getAvailableAttackTypes(): array
    {
        return [
            'email_phishing' => [
                'name' => 'Email Phishing',
                'description' => 'Simulazioni di email fraudolente per testare il riconoscimento',
                'difficulty' => 'beginner',
                'estimated_time' => 5
            ],
            'vishing' => [
                'name' => 'Voice Phishing (Vishing)',
                'description' => 'Chiamate telefoniche fraudolente con AI voice generation',
                'difficulty' => 'advanced',
                'estimated_time' => 10,
                'requires_voice' => true
            ],
            'social_engineering' => [
                'name' => 'Social Engineering',
                'description' => 'Scenari di manipolazione psicologica avanzata',
                'difficulty' => 'intermediate',
                'estimated_time' => 15
            ],
            'ceo_fraud' => [
                'name' => 'CEO Fraud',
                'description' => 'Simulazioni di richieste urgenti da dirigenti',
                'difficulty' => 'advanced',
                'estimated_time' => 8
            ],
            'smishing' => [
                'name' => 'SMS Phishing (Smishing)',
                'description' => 'Attacchi tramite SMS con link malevoli',
                'difficulty' => 'beginner',
                'estimated_time' => 3
            ]
        ];
    }

    /**
     * Ottieni livelli di difficoltà
     */
    private function getDifficultyLevels(): array
    {
        return [
            'beginner' => [
                'name' => 'Principiante',
                'description' => 'Attacchi evidenti con indicatori chiari'
            ],
            'intermediate' => [
                'name' => 'Intermedio',
                'description' => 'Attacchi più sofisticati con alcuni indicatori nascosti'
            ],
            'advanced' => [
                'name' => 'Avanzato',
                'description' => 'Attacchi molto convincenti e difficili da rilevare'
            ]
        ];
    }

    /**
     * Ottieni preset durata
     */
    private function getDurationPresets(): array
    {
        return [
            1 => 'Training intensivo (1 settimana)',
            2 => 'Corso breve (2 settimane)',
            4 => 'Standard (1 mese)',
            8 => 'Approfondito (2 mesi)',
            12 => 'Completo (3 mesi)'
        ];
    }

    /**
     * Ottieni fattori umani disponibili
     */
    private function getHumanFactors(): array
    {
        return [
            'urgency' => 'Sensibilità all\'urgenza',
            'authority' => 'Rispetto per l\'autorità',
            'curiosity' => 'Alta curiosità',
            'helpfulness' => 'Tendenza ad aiutare',
            'fear' => 'Reattività alla paura',
            'greed' => 'Vulnerabilità alle offerte',
            'social_proof' => 'Influenza sociale',
            'reciprocity' => 'Principio di reciprocità'
        ];
    }

    /**
     * Ottieni opzioni notifiche
     */
    private function getNotificationOptions(): array
    {
        return [
            'channels' => ['email', 'sms', 'push'],
            'frequencies' => ['immediate', 'daily', 'weekly'],
            'types' => ['alerts', 'summaries', 'reports']
        ];
    }

    /**
     * Prepara riassunto finale
     */
    private function prepareSummary(array $wizardData): array
    {
        return [
            'attack_types_count' => count($wizardData['attack_types'] ?? []),
            'estimated_duration' => $wizardData['duration_weeks'] ?? 0,
            'difficulty' => $wizardData['difficulty'] ?? 'intermediate',
            'human_factors_count' => count($wizardData['human_factors'] ?? []),
            'has_voice' => $wizardData['include_voice'] ?? false
        ];
    }
}
