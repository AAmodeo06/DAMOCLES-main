<?php
// REALIZZATO DA: Andrea Amodeo

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LLMIntegration;
use App\Models\PromptTemplate;
use Carbon\Carbon;
use DB;

class LLMConfigSeeder extends Seeder
{
    public function run()
    {
        // Configurazioni LLM principali
        $this->createLLMConfigurations();

        // Template di prompt personalizzati
        $this->createPromptTemplates();

        // Configurazioni di sistema
        $this->createSystemConfigurations();
    }

    /**
     * Crea le configurazioni per i servizi LLM
     */
    private function createLLMConfigurations()
    {
        // Configurazione OpenAI GPT-4
        LLMIntegration::create([
            'name' => 'OpenAI GPT-4 Text Generator',
            'provider' => 'openai',
            'model' => 'gpt-4-turbo-preview',
            'api_endpoint' => 'https://api.openai.com/v1/chat/completions',
            'config' => json_encode([
                'max_tokens' => 2048,
                'temperature' => 0.7,
                'top_p' => 0.9,
                'frequency_penalty' => 0.1,
                'presence_penalty' => 0.1
            ]),
            'rate_limits' => json_encode([
                'requests_per_minute' => 100,
                'tokens_per_minute' => 150000
            ]),
            'cost_per_token' => 0.00003,
            'is_active' => true,
            'supports_streaming' => true,
            'content_types' => json_encode(['text', 'structured']),
            'quality_score' => 95.5,
            'avg_response_time' => 1200,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // Configurazione ElevenLabs per audio
        LLMIntegration::create([
            'name' => 'ElevenLabs Voice Synthesis',
            'provider' => 'elevenlabs',
            'model' => 'eleven_multilingual_v2',
            'api_endpoint' => 'https://api.elevenlabs.io/v1/text-to-speech',
            'config' => json_encode([
                'voice_id' => 'pNInz6obpgDQGcFmaJgB',
                'voice_settings' => [
                    'stability' => 0.75,
                    'similarity_boost' => 0.85
                ],
                'output_format' => 'mp3_44100_128'
            ]),
            'rate_limits' => json_encode([
                'characters_per_month' => 10000,
                'requests_per_minute' => 20
            ]),
            'cost_per_token' => 0.00015,
            'is_active' => true,
            'supports_streaming' => false,
            'content_types' => json_encode(['audio', 'voice']),
            'quality_score' => 88.2,
            'avg_response_time' => 3500,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }

    /**
     * Crea template di prompt personalizzati
     */
    private function createPromptTemplates()
    {
        // Template per phishing email
        PromptTemplate::create([
            'name' => 'Phishing Email Personalizzato',
            'content_type' => 'text',
            'template' => 'Crea un email di phishing realistico per un utente di nome {USER_NAME} che lavora come {JOB_ROLE} presso {ORGANIZATION}.

Considera questi fattori:
- Livello di istruzione: {EDUCATION_LEVEL}
- Livello di vigilanza: {VIGILANCE_LEVEL}

L\'email deve essere convincente ma sicura per training.',
            'variables' => json_encode([
                'USER_NAME', 'JOB_ROLE', 'ORGANIZATION',
                'EDUCATION_LEVEL', 'VIGILANCE_LEVEL'
            ]),
            'llm_integration_id' => 1,
            'category' => 'phishing',
            'difficulty_level' => 'intermediate',
            'estimated_tokens' => 300,
            'success_rate' => 87.3,
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // Template per social engineering
        PromptTemplate::create([
            'name' => 'Social Engineering Call Script',
            'content_type' => 'audio',
            'template' => 'Genera uno script per una chiamata di social engineering rivolta a {USER_NAME}, {JOB_ROLE} di {ORGANIZATION}.

Lo script deve:
1. Sembrare una chiamata legittima dall\'IT
2. Creare urgenza
3. Durare massimo 2 minuti',
            'variables' => json_encode([
                'USER_NAME', 'JOB_ROLE', 'ORGANIZATION'
            ]),
            'llm_integration_id' => 2,
            'category' => 'social_engineering',
            'difficulty_level' => 'advanced',
            'estimated_tokens' => 450,
            'success_rate' => 73.8,
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }

    /**
     * Crea configurazioni di sistema
     */
    private function createSystemConfigurations()
    {
        $configs = [
            [
                'key' => 'llm_auto_fallback',
                'value' => json_encode([
                    'enabled' => true,
                    'primary_provider' => 'openai',
                    'fallback_providers' => ['elevenlabs']
                ]),
                'category' => 'reliability'
            ],
            [
                'key' => 'content_moderation',
                'value' => json_encode([
                    'enabled' => true,
                    'max_toxicity_score' => 0.7
                ]),
                'category' => 'safety'
            ]
        ];

        foreach ($configs as $config) {
            DB::table('system_configurations')->insert(array_merge($config, [
                'created_at' => now(),
                'updated_at' => now()
            ]));
        }
    }
}
