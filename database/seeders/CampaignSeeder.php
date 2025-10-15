<?php

// REALIZZATO DA: Andrea Amodeo

namespace Database\Seeders;

use App\Models\Campaign;
use App\Models\User;
use App\Models\WizardSession;
use App\Models\LLMIntegration;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CampaignSeeder extends Seeder
{
    /**
     * Popola campagne e dati correlati per demo e testing
     */
    public function run(): void
    {
        $this->command->info('🏗️ Seeding DAMOCLES Campaign System...');

        // Crea utenti di test se non esistono
        $this->createTestUsers();

        // Ottieni evaluators
        $evaluators = User::where('role', 'evaluator')->get();

        if ($evaluators->isEmpty()) {
            $this->command->error('Nessun evaluator trovato. Crearne uno prima di eseguire il seeder.');
            return;
        }

        // Campagne predefinite con configurazioni reali
        $campaignTemplates = $this->getCampaignTemplates();

        foreach ($campaignTemplates as $index => $template) {
            $evaluator = $evaluators->random();

            // Crea wizard session realistica
            $wizardSession = $this->createWizardSession($evaluator, $template);

            // Crea la campagna
            $campaign = $this->createCampaign($template, $evaluator, $wizardSession);

            // Associa sessione alla campagna
            $wizardSession->update(['campaign_id' => $campaign->id]);

            // Genera simulazioni LLM per campagne attive
            if (in_array($template['status'], [Campaign::STATUS_ACTIVE, Campaign::STATUS_COMPLETED])) {
                $this->generateLLMContent($campaign, $template);
            }

            // Aggiungi partecipanti
            $this->addParticipants($campaign);

            $this->command->info("✅ Creata: {$template['name']}");
        }

        $this->command->info("🎉 Creati " . count($campaignTemplates) . " campagne di esempio");
    }

    /**
     * Crea utenti di test necessari
     */
    private function createTestUsers(): void
    {
        // Evaluator principale
        User::firstOrCreate(['email' => 'evaluator@damocles.test'], [
            'name' => 'Andrea Amodeo',
            'password' => Hash::make('password'),
            'role' => 'evaluator',
            'email_verified_at' => now()
        ]);

        // Evaluator secondario
        User::firstOrCreate(['email' => 'evaluator2@damocles.test'], [
            'name' => 'Security Manager',
            'password' => Hash::make('password'),
            'role' => 'evaluator',
            'email_verified_at' => now()
        ]);

        // Admin di sistema
        User::firstOrCreate(['email' => 'admin@damocles.test'], [
            'name' => 'System Administrator',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'email_verified_at' => now()
        ]);

        // Utenti partecipanti
        for ($i = 1; $i <= 25; $i++) {
            User::firstOrCreate(["email" => "user{$i}@damocles.test"], [
                'name' => "Test User {$i}",
                'password' => Hash::make('password'),
                'role' => 'user',
                'email_verified_at' => now()
            ]);
        }

        $this->command->info('👥 Utenti di test creati/verificati');
    }

    /**
     * Template campagne realistiche
     */
    private function getCampaignTemplates(): array
    {
        return [
            [
                'name' => 'Onboarding Cybersecurity - Nuovi Dipendenti',
                'description' => 'Programma introduttivo per dipendenti neo-assunti. Copre fondamenti di sicurezza, riconoscimento email phishing base e procedure aziendali.',
                'target_audience' => 'Nuovi dipendenti (primi 3 mesi)',
                'difficulty_level' => Campaign::DIFFICULTY_BEGINNER,
                'duration_weeks' => 2,
                'attack_types' => ['email_phishing', 'smishing'],
                'human_factors' => ['urgency', 'curiosity', 'helpfulness'],
                'notification_settings' => [
                    'email_notifications' => true,
                    'frequency' => 'daily',
                    'summary_reports' => true,
                    'real_time_alerts' => false
                ],
                'status' => Campaign::STATUS_ACTIVE,
                'starts_at' => now()->subWeeks(1),
                'ends_at' => now()->addWeek(),
                'participants_count' => rand(15, 25)
            ],

            [
                'name' => 'Advanced Threat Simulation - Management',
                'description' => 'Simulazioni sofisticate per management e C-level. Include vishing con AI, CEO fraud avanzato e scenari di spear phishing personalizzati.',
                'target_audience' => 'Dirigenti, manager senior e C-level executives',
                'difficulty_level' => Campaign::DIFFICULTY_ADVANCED,
                'duration_weeks' => 8,
                'attack_types' => ['vishing', 'social_engineering', 'ceo_fraud', 'email_phishing'],
                'human_factors' => ['authority', 'urgency', 'social_proof', 'reciprocity', 'greed'],
                'notification_settings' => [
                    'email_notifications' => true,
                    'sms_notifications' => true,
                    'frequency' => 'immediate',
                    'real_time_alerts' => true,
                    'detailed_analytics' => true
                ],
                'status' => Campaign::STATUS_ACTIVE,
                'starts_at' => now()->subWeeks(3),
                'ends_at' => now()->addWeeks(5),
                'participants_count' => rand(8, 15)
            ],

            [
                'name' => 'Settore Bancario - Compliance e Sicurezza',
                'description' => 'Campagna specializzata per istituti bancari. Focus su CEO fraud, wire transfer fraud e conformità PCI-DSS.',
                'target_audience' => 'Personale bancario, operatori finanziari, compliance officers',
                'difficulty_level' => Campaign::DIFFICULTY_INTERMEDIATE,
                'duration_weeks' => 6,
                'attack_types' => ['email_phishing', 'ceo_fraud', 'vishing'],
                'human_factors' => ['authority', 'urgency', 'fear', 'greed'],
                'notification_settings' => [
                    'email_notifications' => true,
                    'frequency' => 'weekly',
                    'summary_reports' => true,
                    'detailed_analytics' => true,
                    'participant_progress' => true
                ],
                'status' => Campaign::STATUS_DRAFT,
                'starts_at' => now()->addWeek(),
                'ends_at' => now()->addWeeks(7),
                'participants_count' => rand(20, 35)
            ],

            [
                'name' => 'Mobile Security Awareness - BYOD Policy',
                'description' => 'Training focalizzato su minacce mobile: smishing, app malware, WiFi pubblici e best practices BYOD.',
                'target_audience' => 'Tutti i dipendenti con dispositivi aziendali o BYOD',
                'difficulty_level' => Campaign::DIFFICULTY_INTERMEDIATE,
                'duration_weeks' => 3,
                'attack_types' => ['smishing', 'email_phishing'],
                'human_factors' => ['curiosity', 'urgency', 'social_proof'],
                'notification_settings' => [
                    'push_notifications' => true,
                    'email_notifications' => true,
                    'frequency' => 'daily',
                    'real_time_alerts' => true
                ],
                'status' => Campaign::STATUS_COMPLETED,
                'starts_at' => now()->subWeeks(5),
                'ends_at' => now()->subWeeks(2),
                'participants_count' => 45,
                'success_rate' => 78.5,
                'completed_participants' => 35
            ],

            [
                'name' => 'Healthcare HIPAA Compliance Training',
                'description' => 'Simulazioni specifiche per settore sanitario: protezione dati pazienti, phishing medico-specifico, ransomware healthcare.',
                'target_audience' => 'Personale sanitario, amministrativo ospedaliero',
                'difficulty_level' => Campaign::DIFFICULTY_INTERMEDIATE,
                'duration_weeks' => 4,
                'attack_types' => ['email_phishing', 'social_engineering', 'smishing'],
                'human_factors' => ['urgency', 'authority', 'helpfulness', 'fear'],
                'notification_settings' => [
                    'email_notifications' => true,
                    'sms_notifications' => false,
                    'frequency' => 'weekly',
                    'summary_reports' => true
                ],
                'status' => Campaign::STATUS_ACTIVE,
                'starts_at' => now()->subWeek(),
                'ends_at' => now()->addWeeks(3),
                'participants_count' => rand(30, 50)
            ],

            [
                'name' => 'Red Team vs Blue Team - Cyber Range',
                'description' => 'Simulazione avanzata per team IT e cybersecurity. Scenari complessi con multiple attack vectors e incident response.',
                'target_audience' => 'IT Security team, SOC analysts, incident responders',
                'difficulty_level' => Campaign::DIFFICULTY_ADVANCED,
                'duration_weeks' => 12,
                'attack_types' => ['email_phishing', 'vishing', 'social_engineering', 'ceo_fraud'],
                'human_factors' => ['authority', 'urgency', 'social_proof', 'reciprocity', 'curiosity'],
                'notification_settings' => [
                    'email_notifications' => true,
                    'sms_notifications' => true,
                    'push_notifications' => true,
                    'frequency' => 'immediate',
                    'summary_reports' => true,
                    'detailed_analytics' => true,
                    'real_time_alerts' => true,
                    'participant_progress' => true
                ],
                'status' => Campaign::STATUS_PAUSED,
                'starts_at' => now()->subWeeks(4),
                'ends_at' => now()->addWeeks(8),
                'participants_count' => rand(12, 18)
            ]
        ];
    }

    /**
     * Crea wizard session per campagna
     */
    private function createWizardSession(User $evaluator, array $template): WizardSession
    {
        return WizardSession::create([
            'user_id' => $evaluator->id,
            'current_step' => 6,
            'step_data' => [
                'step_1' => [
                    'attack_types' => $template['attack_types'],
                    'intensity' => 'medium',
                    'include_voice' => in_array('vishing', $template['attack_types'])
                ],
                'step_2' => [
                    'target_audience' => $template['target_audience'],
                    'difficulty' => $template['difficulty_level'],
                    'company_size' => ['small', 'medium', 'large', 'enterprise'][array_rand(['small', 'medium', 'large', 'enterprise'])],
                    'industry' => $this->getRandomIndustry()
                ],
                'step_3' => [
                    'duration_weeks' => $template['duration_weeks'],
                    'frequency' => ['daily', 'weekly', 'bi-weekly'][array_rand(['daily', 'weekly', 'bi-weekly'])],
                    'start_date' => $template['starts_at']->format('Y-m-d'),
                    'timezone' => 'Europe/Rome'
                ],
                'step_4' => [
                    'human_factors' => $template['human_factors'],
                    'personalization_level' => ['low', 'medium', 'high'][array_rand(['low', 'medium', 'high'])],
                    'behavioral_triggers' => ['deadline_pressure', 'social_validation', 'scarcity']
                ],
                'step_5' => $template['notification_settings'],
                'step_6' => [
                    'campaign_name' => $template['name'],
                    'campaign_description' => $template['description'],
                    'auto_start' => $template['status'] === Campaign::STATUS_ACTIVE,
                    'generate_content_now' => true
                ]
            ],
            'completed' => true,
            'expires_at' => now()->addHours(4)
        ]);
    }

    /**
     * Crea campagna dal template
     */
    private function createCampaign(array $template, User $evaluator, WizardSession $session): Campaign
    {
        return Campaign::create([
            'name' => $template['name'],
            'description' => $template['description'],
            'creator_id' => $evaluator->id,
            'wizard_session_id' => $session->id,
            'target_audience' => $template['target_audience'],
            'difficulty_level' => $template['difficulty_level'],
            'duration_weeks' => $template['duration_weeks'],
            'attack_types' => $template['attack_types'],
            'human_factors' => $template['human_factors'],
            'notification_settings' => $template['notification_settings'],
            'status' => $template['status'],
            'starts_at' => $template['starts_at'],
            'ends_at' => $template['ends_at'],
            'total_participants' => $template['participants_count'],
            'completed_participants' => $template['completed_participants'] ?? 0,
            'success_rate' => $template['success_rate'] ?? null,
            'settings' => [
                'auto_generated' => true,
                'seeder_version' => '1.0',
                'created_for_demo' => true
            ]
        ]);
    }

    /**
     * Genera contenuto LLM realistico
     */
    private function generateLLMContent(Campaign $campaign, array $template): void
    {
        foreach ($template['attack_types'] as $attackType) {
            // 80% probabilità di generare contenuto per ogni tipo
            if (rand(1, 100) <= 80) {
                $generation = LLMIntegration::create([
                    'campaign_id' => $campaign->id,
                    'content_type' => $attackType,
                    'prompt_template' => $this->getPromptForType($attackType),
                    'generated_content' => $this->getRealisticContent($attackType, $campaign),
                    'generation_parameters' => [
                        'difficulty' => $campaign->difficulty_level,
                        'target_audience' => $campaign->target_audience,
                        'human_factors' => $campaign->human_factors,
                        'model' => rand(1, 100) > 30 ? 'gpt-4-turbo-preview' : 'gpt-3.5-turbo',
                        'temperature' => $this->getTemperatureForType($attackType)
                    ],
                    'model_used' => rand(1, 100) > 30 ? 'gpt-4-turbo-preview' : 'gpt-3.5-turbo',
                    'tokens_consumed' => $this->getTokensForType($attackType),
                    'generation_time_ms' => rand(2000, 15000),
                    'quality_score' => rand(75, 98),
                    'status' => LLMIntegration::STATUS_COMPLETED,
                    'voice_generated' => $this->supportsVoice($attackType) && rand(1, 100) > 40,
                    'voice_url' => $this->supportsVoice($attackType) && rand(1, 100) > 40 ?
                        '/storage/voice/demo_' . uniqid() . '.mp3' : null,
                    'voice_duration' => $this->supportsVoice($attackType) ? rand(45, 180) : null,
                    'metadata' => [
                        'generated_by_seeder' => true,
                        'campaign_template' => $template['name'],
                        'ai_model_version' => '2024.1'
                    ]
                ]);

                // Simula generazioni fallite occasionalmente (5%)
                if (rand(1, 100) <= 5) {
                    LLMIntegration::create([
                        'campaign_id' => $campaign->id,
                        'content_type' => $attackType,
                        'prompt_template' => $this->getPromptForType($attackType),
                        'status' => LLMIntegration::STATUS_FAILED,
                        'error_message' => 'Rate limit exceeded - retry in 60 seconds',
                        'generation_parameters' => [
                            'difficulty' => $campaign->difficulty_level,
                            'retry_attempt' => 1
                        ]
                    ]);
                }
            }
        }

        $this->command->info("   📝 Generati contenuti LLM per: {$campaign->name}");
    }

    /**
     * Aggiungi partecipanti realistici
     */
    private function addParticipants(Campaign $campaign): void
    {
        $users = User::where('role', 'user')->get();
        $participantCount = min($campaign->total_participants, $users->count());
        $selectedUsers = $users->random($participantCount);

        foreach ($selectedUsers as $user) {
            $joinedDaysAgo = rand(1, min(30, $campaign->starts_at->diffInDays(now())));
            $progress = $this->calculateRealisticProgress($campaign, $joinedDaysAgo);

            $campaign->participants()->attach($user->id, [
                'joined_at' => now()->subDays($joinedDaysAgo),
                'status' => $this->getParticipantStatus($progress),
                'progress' => $progress,
                'last_activity' => now()->subHours(rand(1, 48))
            ]);
        }
    }

    // Helper methods
    private function getRandomIndustry(): string
    {
        $industries = [
            'Banking & Finance', 'Healthcare', 'Technology', 'Manufacturing',
            'Education', 'Government', 'Retail', 'Insurance', 'Energy',
            'Telecommunications', 'Media', 'Transportation'
        ];
        return $industries[array_rand($industries)];
    }

    private function getPromptForType(string $type): string
    {
        return match($type) {
            'email_phishing' => 'Generate realistic phishing email for cybersecurity training',
            'vishing' => 'Create voice phishing script with social engineering techniques',
            'social_engineering' => 'Develop social engineering scenario with psychological manipulation',
            'ceo_fraud' => 'Simulate CEO fraud request with authority and urgency tactics',
            'smishing' => 'Generate SMS phishing message with mobile-specific threats',
            default => 'Create cybersecurity training content'
        };
    }

    private function getRealisticContent(string $type, Campaign $campaign): array
    {
        $baseContent = [
            'generated_at' => now()->toISOString(),
            'campaign_context' => $campaign->target_audience,
            'difficulty_level' => $campaign->difficulty_level
        ];

        return match($type) {
            'email_phishing' => array_merge($baseContent, [
                'from' => 'security-' . rand(100, 999) . '@company-update.com',
                'subject' => $this->getEmailSubjectByDifficulty($campaign->difficulty_level),
                'body' => $this->getEmailBodyByDifficulty($campaign->difficulty_level),
                'red_flags' => $this->getRedFlagsForEmail($campaign->difficulty_level),
                'educational_notes' => 'Email designed to test recognition of phishing indicators'
            ]),
            'vishing' => array_merge($baseContent, [
                'caller_identity' => 'IT Support Specialist',
                'scenario' => 'Urgent security update required',
                'script_phases' => $this->getVishingScript($campaign->difficulty_level),
                'red_flags' => ['Unsolicited call', 'Requests for passwords', 'Creates artificial urgency'],
                'educational_notes' => 'IT never requests passwords over phone calls'
            ]),
            default => array_merge($baseContent, [
                'content' => 'Generated training content for ' . $type,
                'type' => $type
            ])
        };
    }

    private function getEmailSubjectByDifficulty(string $difficulty): string
    {
        return match($difficulty) {
            'beginner' => 'URGENT: Your account will be suspended in 24 hours!',
            'intermediate' => 'Security Update Required - IT Department',
            'advanced' => 'Re: Q4 Budget Review - Please confirm by EOD',
            default => 'Account Verification Required'
        };
    }

    private function getEmailBodyByDifficulty(string $difficulty): string
    {
        return match($difficulty) {
            'beginner' => 'Dear user, we have detected suspicious activity on your account. Click here immediately to secure your account: [SUSPICIOUS_LINK]',
            'intermediate' => 'Hello, This is an automated security notification. Our systems require an immediate update to your account credentials. Please follow the secure link below to update your information.',
            'advanced' => 'Hi there, Following up on our discussion regarding the Q4 budget allocations. Could you please review the attached spreadsheet and confirm the changes by end of day? The document requires your credentials to access.',
            default => 'Please verify your account by clicking the link below.'
        };
    }

    private function getRedFlagsForEmail(string $difficulty): array
    {
        $basic = ['Generic greeting', 'Urgency pressure', 'Suspicious link'];
        $intermediate = ['Unexpected request', 'Non-corporate domain', 'Grammar errors'];
        $advanced = ['Spoofed sender', 'Context manipulation', 'Social engineering'];

        return match($difficulty) {
            'beginner' => $basic,
            'intermediate' => array_merge($basic, $intermediate),
            'advanced' => array_merge($basic, $intermediate, $advanced),
            default => $basic
        };
    }

    private function getVishingScript(string $difficulty): array
    {
        return match($difficulty) {
            'beginner' => [
                'Hello, this is tech support. We need to update your password immediately.',
                'Can you please provide your current password for verification?',
                'Thank you, we will update your account now.'
            ],
            'intermediate' => [
                'Good morning, this is Sarah from IT Security. We\'ve detected some unusual activity.',
                'For your protection, I need to verify your identity. What\'s your employee ID and current password?',
                'Perfect, I\'m updating your security settings now. You should receive a confirmation email.'
            ],
            'advanced' => [
                'Hi, this is Michael from the Security Operations Center. We\'re calling about the incident from earlier today.',
                'I see you\'re in the marketing department. We need to secure your account before the attacker gains access.',
                'This is time-sensitive. Can you help me verify your credentials so I can apply the security patch?'
            ],
            default => ['Basic vishing script phase 1', 'Basic vishing script phase 2']
        };
    }

    private function supportsVoice(string $type): bool
    {
        return in_array($type, ['vishing', 'social_engineering', 'ceo_fraud']);
    }

    private function getTokensForType(string $type): int
    {
        return match($type) {
            'email_phishing' => rand(200, 600),
            'smishing' => rand(50, 150),
            'vishing' => rand(400, 1000),
            'social_engineering' => rand(600, 1500),
            'ceo_fraud' => rand(300, 800),
            'quiz_questions' => rand(500, 1200),
            default => rand(200, 800)
        };
    }

    private function getTemperatureForType(string $type): float
    {
        return match($type) {
            'quiz_questions' => 0.3,
            'email_phishing' => 0.7,
            'vishing', 'social_engineering' => 0.8,
            default => 0.7
        };
    }

    private function calculateProgressByStatus(string $status): int
    {
        switch ($status) {
            case 'draft':
                $baseProgress = rand(0, 25);
                break;
            case 'active':
                $baseProgress = rand(30, 85);
                break;
            case 'completed':
                return 100;
            case 'paused':
                $baseProgress = rand(20, 60);
                break;
            default:
                $baseProgress = 0;
        }

        // Aggiungi variabilità realistica
        $variance = rand(-5, 15);
        $finalProgress = max(0, min(100, $baseProgress + $variance));

        return $finalProgress;
    }
    private function getParticipantStatus(int $progress): string
    {
        return match(true) {
            $progress >= 100 => 'completed',
            $progress >= 50 => 'in_progress',
            $progress >= 1 => 'started',
            default => 'not_started'
        };
    }

    private function calculateRealisticProgress(Campaign $campaign, int $joinedDaysAgo): int
    {
        $baseProgress = match($campaign->status) {
            Campaign::STATUS_COMPLETED => rand(80, 100),
            Campaign::STATUS_ACTIVE => rand(20, 90),
            Campaign::STATUS_PAUSED => rand(10, 60),
            Campaign::STATUS_DRAFT => rand(0, 20),
            default => 0
        };

        // Fattore tempo: più tempo = più progresso
        $timeMultiplier = min(1.5, 1 + ($joinedDaysAgo * 0.1));

        // Fattore difficoltà: più difficile = progresso più lento
        $difficultyMultiplier = match($campaign->difficulty_level) {
            Campaign::DIFFICULTY_BEGINNER => 1.2,
            Campaign::DIFFICULTY_INTERMEDIATE => 1.0,
            Campaign::DIFFICULTY_ADVANCED => 0.8,
            default => 1.0
        };

        $adjustedProgress = $baseProgress * $timeMultiplier * $difficultyMultiplier;

        // Aggiungi variabilità individuale
        $variance = rand(-15, 25);
        $finalProgress = max(0, min(100, intval($adjustedProgress + $variance)));

        return $finalProgress;
    }
}
