<?php
// app/Services/LLMService.php
// REALIZZATO DA: Andrea Amodeo

namespace App\Services;

use App\Models\Campaign;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class LLMServices
{
    private string $openaiApiKey;
    private string $elevenlabsApiKey;
    private string $baseUrl = 'https://api.openai.com/v1';
    private string $elevenlabsUrl = 'https://api.elevenlabs.io/v1';

    public function __construct()
    {
        $this->openaiApiKey = config('services.openai.api_key');
        $this->elevenlabsApiKey = config('services.elevenlabs.api_key');
    }

    /**
     * Genera contenuto usando OpenAI GPT
     */
    public function generateContent(string $contentType, array $parameters, Campaign $campaign): array
    {
        $prompt = $this->buildPrompt($contentType, $parameters, $campaign);
        $model = $this->selectOptimalModel($contentType);

        $requestData = [
            'model' => $model,
            'messages' => [
                [
                    'role' => 'system',
                    'content' => $this->getSystemPrompt($contentType)
                ],
                [
                    'role' => 'user',
                    'content' => $prompt
                ]
            ],
            'max_tokens' => $this->getMaxTokens($contentType),
            'temperature' => $this->getTemperature($contentType),
            'top_p' => 1,
            'frequency_penalty' => 0.1,
            'presence_penalty' => 0.1
        ];

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->openaiApiKey,
            'Content-Type' => 'application/json'
        ])
        ->timeout(60)
        ->post($this->baseUrl . '/chat/completions', $requestData);

        if (!$response->successful()) {
            throw new \Exception('OpenAI API Error: ' . $response->body());
        }

        $data = $response->json();

        return [
            'content' => $this->parseGeneratedContent($data['choices'][0]['message']['content'], $contentType),
            'model' => $model,
            'tokens' => $data['usage']['total_tokens'],
            'quality_score' => $this->evaluateContentQuality($data['choices'][0]['message']['content'], $contentType)
        ];
    }

    /**
     * Genera voce usando ElevenLabs
     */
    public function generateVoice(array $content, array $parameters): array
    {
        if (!$this->elevenlabsApiKey) {
            throw new \Exception('ElevenLabs API key not configured');
        }

        $text = $this->extractTextForVoice($content);
        $voiceId = $parameters['voice_id'] ?? $this->getDefaultVoiceId($parameters);

        $requestData = [
            'text' => $text,
            'model_id' => 'eleven_monolingual_v1',
            'voice_settings' => [
                'stability' => $parameters['voice_stability'] ?? 0.5,
                'similarity_boost' => $parameters['voice_similarity'] ?? 0.5,
                'style' => $parameters['voice_style'] ?? 0.0,
                'use_speaker_boost' => true
            ]
        ];

        $response = Http::withHeaders([
            'xi-api-key' => $this->elevenlabsApiKey,
            'Content-Type' => 'application/json',
            'Accept' => 'audio/mpeg'
        ])
        ->timeout(120)
        ->post($this->elevenlabsUrl . "/text-to-speech/{$voiceId}", $requestData);

        if (!$response->successful()) {
            throw new \Exception('ElevenLabs API Error: ' . $response->body());
        }

        // Salva l'audio file
        $filename = 'voice_' . uniqid() . '.mp3';
        $filePath = storage_path('app/public/voice/' . $filename);

        if (!file_exists(dirname($filePath))) {
            mkdir(dirname($filePath), 0755, true);
        }

        file_put_contents($filePath, $response->body());

        return [
            'success' => true,
            'url' => asset('storage/voice/' . $filename),
            'filename' => $filename,
            'duration' => $this->estimateAudioDuration($text),
            'file_size' => filesize($filePath)
        ];
    }

    /**
     * Costruisce il prompt per il tipo di contenuto
     */
    private function buildPrompt(string $contentType, array $parameters, Campaign $campaign): string
    {
        $baseContext = "Campagna: {$campaign->name}\n";
        $baseContext .= "Target: {$campaign->target_audience}\n";
        $baseContext .= "Difficoltà: {$campaign->difficulty_level}\n\n";

        return match($contentType) {
            'email_phishing' => $baseContext . $this->buildEmailPhishingPrompt($parameters, $campaign),
            'vishing' => $baseContext . $this->buildVishingPrompt($parameters, $campaign),
            'social_engineering' => $baseContext . $this->buildSocialEngineeringPrompt($parameters, $campaign),
            'ceo_fraud' => $baseContext . $this->buildCeoFraudPrompt($parameters, $campaign),
            'smishing' => $baseContext . $this->buildSmishingPrompt($parameters, $campaign),
            'quiz_questions' => $baseContext . $this->buildQuizPrompt($parameters, $campaign),
            default => throw new \InvalidArgumentException("Unsupported content type: {$contentType}")
        };
    }

    /**
     * Prompt per email phishing
     */
    private function buildEmailPhishingPrompt(array $parameters, Campaign $campaign): string
    {
        $prompt = "Genera un'email di phishing realistica ma SICURA per scopi di training. ";
        $prompt .= "L'email deve includere:\n";
        $prompt .= "- Oggetto convincente ma sospetto\n";
        $prompt .= "- Mittente che sembra legittimo ma presenta anomalie\n";
        $prompt .= "- Corpo del messaggio persuasivo con tecniche di social engineering\n";
        $prompt .= "- Call-to-action pericolosa (link, allegato, richiesta info)\n";
        $prompt .= "- Indicatori sottili di phishing per l'analisi educativa\n\n";

        if (isset($parameters['industry'])) {
            $prompt .= "Settore target: {$parameters['industry']}\n";
        }

        if (isset($parameters['urgency_level'])) {
            $prompt .= "Livello di urgenza: {$parameters['urgency_level']}\n";
        }

        $prompt .= "\nIMPORTANTE: Questo è per training sicuro. Non includere link reali o informazioni dannose.";
        $prompt .= "\nFormatta la risposta come JSON con le chiavi: subject, from, body, red_flags, educational_notes";

        return $prompt;
    }

    /**
     * Prompt per vishing
     */
    private function buildVishingPrompt(array $parameters, Campaign $campaign): string
    {
        $prompt = "Crea uno script per una chiamata vishing (voice phishing) educativa. ";
        $prompt .= "Lo script deve simulare una chiamata da:\n";

        $caller = $parameters['caller_type'] ?? 'bank';
        $prompt .= "- " . $this->getCallerDescription($caller) . "\n";
        $prompt .= "- Durata stimata: 2-3 minuti\n";
        $prompt .= "- Include tecniche di manipolazione psicologica\n";
        $prompt .= "- Punti di pressione emotiva\n";
        $prompt .= "- Richieste progressive di informazioni\n\n";

        $prompt .= "Lo script deve essere suddiviso in:\n";
        $prompt .= "1. Apertura e presentazione\n";
        $prompt .= "2. Creazione dell'urgenza\n";
        $prompt .= "3. Richiesta di informazioni\n";
        $prompt .= "4. Gestione obiezioni\n";
        $prompt .= "5. Chiusura\n\n";

        $prompt .= "Includi anche indicatori per identificare il vishing e note educative.";
        $prompt .= "\nFormatta come JSON con: script_phases, red_flags, educational_notes, estimated_duration";

        return $prompt;
    }

    /**
     * Ottieni prompt di sistema per tipo di contenuto
     */
    private function getSystemPrompt(string $contentType): string
    {
        $basePrompt = "Sei un esperto di cybersecurity specializzato nella creazione di contenuti di training anti-phishing. ";
        $basePrompt .= "I tuoi contenuti devono essere realistici ma sicuri, educativi e coinvolgenti. ";
        $basePrompt .= "Non creare mai contenuti che possano essere usati per attacchi reali. ";

        return match($contentType) {
            'email_phishing' => $basePrompt . "Specializzati in email di phishing educative con indicatori identificabili.",
            'vishing' => $basePrompt . "Crea script per chiamate di voice phishing con tecniche di social engineering.",
            'social_engineering' => $basePrompt . "Sviluppa scenari di manipolazione psicologica per awareness training.",
            'ceo_fraud' => $basePrompt . "Simula richieste urgenti da dirigenti per prevenire frodi finanziarie.",
            'smishing' => $basePrompt . "Genera SMS di phishing con tecniche di mobile social engineering.",
            'quiz_questions' => $basePrompt . "Crea domande quiz per testare la conoscenza anti-phishing.",
            default => $basePrompt
        };
    }

    /**
     * Seleziona il modello ottimale
     */
    private function selectOptimalModel(string $contentType): string
    {
        return match($contentType) {
            'quiz_questions' => 'gpt-3.5-turbo', // Quiz più semplici
            'vishing', 'social_engineering' => 'gpt-4-turbo-preview', // Contenuti complessi
            default => 'gpt-4-turbo-preview' // Default al migliore
        };
    }

    /**
     * Ottieni max tokens per tipo
     */
    private function getMaxTokens(string $contentType): int
    {
        return match($contentType) {
            'smishing' => 500,
            'email_phishing' => 1000,
            'ceo_fraud' => 800,
            'vishing' => 1500,
            'social_engineering' => 2000,
            'quiz_questions' => 1200,
            default => 1000
        };
    }

    /**
     * Ottieni temperatura per tipo
     */
    private function getTemperature(string $contentType): float
    {
        return match($contentType) {
            'quiz_questions' => 0.3, // Più preciso
            'email_phishing' => 0.7, // Bilanciato
            'vishing', 'social_engineering' => 0.8, // Più creativo
            default => 0.7
        };
    }

    /**
     * Parse del contenuto generato
     */
    private function parseGeneratedContent(string $content, string $contentType): array
    {
        // Tenta di parsare come JSON
        $decoded = json_decode($content, true);

        if ($decoded !== null) {
            return $decoded;
        }

        // Fallback per contenuto non-JSON
        return [
            'raw_content' => $content,
            'type' => $contentType,
            'parsed_at' => now()->toISOString()
        ];
    }

    /**
     * Valuta la qualità del contenuto
     */
    private function evaluateContentQuality(string $content, string $contentType): float
    {
        $score = 50.0; // Base score

        // Lunghezza appropriata
        $length = strlen($content);
        if ($length >= 200 && $length <= 2000) {
            $score += 15;
        }

        // Presenza di JSON strutturato
        if (json_decode($content) !== null) {
            $score += 20;
        }

        // Termini specifici del dominio
        $domainTerms = [
            'phishing', 'security', 'urgent', 'verify', 'account',
            'click', 'link', 'suspicious', 'fraud'
        ];

        $termCount = 0;
        foreach ($domainTerms as $term) {
            if (stripos($content, $term) !== false) {
                $termCount++;
            }
        }

        $score += min($termCount * 3, 15);

        return min($score, 100.0);
    }

    /**
     * Estrai testo per sintesi vocale
     */
    private function extractTextForVoice(array $content): string
    {
        if (isset($content['script_phases'])) {
            return implode(' ', $content['script_phases']);
        }

        if (isset($content['body'])) {
            return $content['body'];
        }

        if (isset($content['raw_content'])) {
            return $content['raw_content'];
        }

        return 'Contenuto per sintesi vocale non disponibile.';
    }

    /**
     * Ottieni voice ID predefinito
     */
    private function getDefaultVoiceId(array $parameters): string
    {
        $callerType = $parameters['caller_type'] ?? 'professional';

        return match($callerType) {
            'bank' => 'ErXwobaYiN019PkySvjV', // Voce professionale
            'executive' => 'VR6AewLTigWG4xSOukaG', // Voce autorevole
            'support' => 'pNInz6obpgDQGcFmaJgB', // Voce amichevole
            default => 'ErXwobaYiN019PkySvjV'
        };
    }

    /**
     * Stima durata audio
     */
    private function estimateAudioDuration(string $text): int
    {
        $wordCount = str_word_count($text);
        $wordsPerMinute = 150; // Velocità media di lettura

        return (int) ceil(($wordCount / $wordsPerMinute) * 60);
    }

    /**
     * Ottieni descrizione chiamante
     */
    private function getCallerDescription(string $callerType): string
    {
        return match($callerType) {
            'bank' => 'Rappresentante della banca',
            'it_support' => 'Tecnico del supporto IT',
            'executive' => 'Dirigente aziendale',
            'government' => 'Funzionario governativo',
            'vendor' => 'Fornitore di servizi',
            default => 'Operatore generico'
        };
    }

}
