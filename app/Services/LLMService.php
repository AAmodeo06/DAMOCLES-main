<?php
// Implementazione LLM per Progetto Universitario - Team
namespace App\Services;

use App\Models\PromptTemplate;
use App\Models\User;
use App\Models\LLM;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class LLMService
{
    /**
     * Genera contenuto formativo personalizzato
     * Usa Ollama (gratuito) con fallback intelligente
     */
    public function generateTrainingContent(
        PromptTemplate $template,
        User $user,
        int $vulnerabilityId,
        string $customInstructions = ''
    ): array {
        // Raccoglie human factors specifici dell'utente
        $humanFactors = $user->humanFactors()
            ->wherePivot('vuln_id', $vulnerabilityId)
            ->get();

        // Costruisce prompt personalizzato
        $prompt = $this->buildPrompt($template, $user, $humanFactors, $vulnerabilityId, $customInstructions);

        // Ottiene LLM configurato
        $llm = LLM::find(session('campaign_data.llm_id')) ?? LLM::where('provider', 'Ollama')->first();

        try {
            // Prova con Ollama (gratuito e locale)
            if ($llm && $llm->provider === 'Ollama' && $this->isOllamaAvailable()) {
                $generatedText = $this->callOllama($llm, $prompt);
            } else {
                // Fallback intelligente basato su template
                $generatedText = $this->generateIntelligentFallback($prompt, $user, $humanFactors, $vulnerabilityId);
            }

            return [
                'text' => $generatedText,
                'audio' => null, // Per progetto universitario, focus sul testo
                'estimated_time' => $this->estimateReadingTime($generatedText),
            ];

        } catch (\Exception $e) {
            Log::error('LLM Generation Error: ' . $e->getMessage());
            $generatedText = $this->generateIntelligentFallback($prompt, $user, $humanFactors, $vulnerabilityId);
            return [
                'text' => $generatedText,
                'audio' => null,
                'estimated_time' => $this->estimateReadingTime($generatedText),
            ];
        }
    }

    /**
     * Costruisce prompt con human factors reali
     */
    protected function buildPrompt(
        PromptTemplate $template,
        User $user,
        $humanFactors,
        int $vulnerabilityId,
        string $customInstructions
    ): string {
        $vulnerability = \App\Models\Vulnerability::find($vulnerabilityId);

        // Formatta human factors
        $hfList = $humanFactors->map(function($hf) {
            $scoreLabel = $this->getScoreLabel($hf->pivot->score);
            return "- {$hf->name}: livello {$scoreLabel} (score: {$hf->pivot->score}/5)\n  Descrizione: {$hf->description}";
        })->implode("\n");

        // Crea profilo utente
        $userProfile = $this->buildUserProfile($user);

        // Sostituisce placeholders nel template
        $prompt = str_replace([
            '{{user_name}}',
            '{{user_profile}}',
            '{{human_factors}}',
            '{{vulnerability_name}}',
            '{{education_level}}',
            '{{personality_traits}}',
            '{{critical_hf}}',
        ], [
            $user->name,
            $userProfile,
            $hfList,
            $vulnerability->name,
            $this->inferEducationLevel($user),
            $this->getPersonalityTraits($humanFactors),
            $this->getCriticalFactors($humanFactors),
        ], $template->content);

        if ($customInstructions) {
            $prompt .= "\n\n**Istruzioni aggiuntive del valutatore:**\n" . $customInstructions;
        }

        return $prompt;
    }

    /**
     * Chiamata a Ollama (GRATUITO e locale)
     */
    protected function callOllama(LLM $llm, string $prompt): string
    {
        $ollamaUrl = config('services.ollama.url', 'http://localhost:11434');

        $response = Http::timeout(120)->post("{$ollamaUrl}/api/generate", [
            'model' => $llm->model,
            'prompt' => $prompt,
            'stream' => false,
            'options' => [
                'temperature' => 0.7,
                'top_p' => 0.9,
            ]
        ]);

        if ($response->successful()) {
            return $response->json('response');
        }

        throw new \Exception('Ollama non disponibile');
    }

    /**
     * Verifica disponibilità Ollama
     */
    protected function isOllamaAvailable(): bool
    {
        try {
            $ollamaUrl = config('services.ollama.url', 'http://localhost:11434');
            $response = Http::timeout(2)->get("{$ollamaUrl}/api/tags");
            return $response->successful();
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Genera contenuto intelligente basato su human factors
     * Fallback di qualità per progetto universitario
     */
    protected function generateIntelligentFallback(
        string $prompt,
        User $user,
        $humanFactors,
        int $vulnerabilityId
    ): string {
        $vulnerability = \App\Models\Vulnerability::find($vulnerabilityId);
        $criticalFactors = $this->getCriticalFactors($humanFactors);

        // Template base personalizzato
        $content = "# Training Personalizzato: {$vulnerability->name}\n\n";
        $content .= "**Caro/a {$user->name},**\n\n";
        $content .= "Questo materiale formativo è stato creato specificamente per te, ";
        $content .= "basandosi sui tuoi human factors e sul profilo di vulnerabilità rispetto a **{$vulnerability->name}**.\n\n";

        // Sezione Human Factors
        $content .= "## 📊 Il Tuo Profilo\n\n";
        $content .= "L'analisi del tuo profilo ha evidenziato i seguenti fattori:\n\n";

        foreach ($humanFactors as $hf) {
            $score = $hf->pivot->score;
            $level = $this->getScoreLabel($score);
            $icon = $score >= 4 ? '⚠️' : ($score >= 3 ? '⚡' : '✓');

            $content .= "**{$icon} {$hf->name}** (Livello: {$level})\n";
            $content .= "{$hf->description}\n";

            if ($score >= 3) {
                $content .= "*Questo fattore richiede particolare attenzione nella formazione.*\n";
            }
            $content .= "\n";
        }

        // Contenuto specifico per vulnerabilità
        $content .= $this->getVulnerabilityContent($vulnerability, $criticalFactors);

        // Sezione pratica personalizzata
        $content .= $this->getPersonalizedPracticalSection($humanFactors, $vulnerability);

        // Conclusione
        $content .= "\n## 🎯 Riepilogo e Prossimi Passi\n\n";
        $content .= "Ricorda: la consapevolezza è la tua migliore difesa. ";
        $content .= "Questo training è stato calibrato sui tuoi fattori di vulnerabilità specifici.\n\n";

        if (!empty($criticalFactors)) {
            $content .= "**Punti di attenzione prioritari per te:**\n";
            foreach (explode(', ', $criticalFactors) as $factor) {
                $content .= "- {$factor}\n";
            }
        }

        return $content;
    }

    /**
     * Contenuto specifico per tipo di vulnerabilità
     */
    protected function getVulnerabilityContent($vulnerability, string $criticalFactors): string
    {
        $content = "\n## 🛡️ Comprendere {$vulnerability->name}\n\n";

        switch ($vulnerability->name) {
            case 'Phishing':
                $content .= "### Cos'è il Phishing\n";
                $content .= "Il phishing è un tentativo di ottenere informazioni sensibili (password, dati bancari, etc.) ";
                $content .= "fingendosi un'entità affidabile tramite email o messaggi.\n\n";

                $content .= "### Come Riconoscerlo\n";
                $content .= "1. **Mittente sospetto**: Controlla attentamente l'indirizzo email\n";
                $content .= "2. **Senso di urgenza**: \"Agisci subito o perderai l'account!\"\n";
                $content .= "3. **Link sospetti**: Passa il mouse sui link senza cliccare\n";
                $content .= "4. **Richieste insolite**: Nessuna banca chiede password via email\n";
                $content .= "5. **Errori grammaticali**: Spesso presente in email fraudolente\n\n";

                if (str_contains($criticalFactors, 'Vigilance')) {
                    $content .= "**Per te è particolarmente importante:**\n";
                    $content .= "Sviluppa l'abitudine di verificare SEMPRE il mittente prima di aprire allegati o cliccare link.\n\n";
                }
                break;

            case 'Smishing':
                $content .= "### Cos'è lo Smishing\n";
                $content .= "Lo smishing è phishing via SMS. Gli attaccanti inviano messaggi che sembrano provenire ";
                $content .= "da banche, corrieri o servizi fidati.\n\n";

                $content .= "### Segnali di Allarme\n";
                $content .= "- SMS da numeri sconosciuti con link\n";
                $content .= "- Messaggi urgenti su consegne mai ordinate\n";
                $content .= "- Richieste di confermare dati personali\n";
                $content .= "- Avvisi di blocco account via SMS\n\n";
                break;

            case 'Vishing':
                $content .= "### Cos'è il Vishing\n";
                $content .= "Il vishing (voice phishing) utilizza chiamate telefoniche per ingannare le vittime.\n\n";

                $content .= "### Come Proteggersi\n";
                $content .= "- Non fornire mai dati sensibili al telefono\n";
                $content .= "- Verifica l'identità chiamando il numero ufficiale\n";
                $content .= "- Diffida di chiamate urgenti da enti pubblici\n\n";
                break;

            default:
                $content .= "Gli attacchi informatici sfruttano vulnerabilità umane. ";
                $content .= "È fondamentale sviluppare una mentalità critica e attenta.\n\n";
        }

        return $content;
    }

    /**
     * Sezione pratica personalizzata in base agli human factors
     */
    protected function getPersonalizedPracticalSection($humanFactors, $vulnerability): string
    {
        $content = "\n## 💡 Consigli Pratici per Te\n\n";

        $hasHighVigilance = $humanFactors->where('name', 'Vigilance')->where('pivot.score', '>=', 4)->isNotEmpty();
        $hasHighAgreeableness = $humanFactors->where('name', 'Agreeableness')->where('pivot.score', '>=', 4)->isNotEmpty();
        $hasHighNeuroticism = $humanFactors->where('name', 'Neuroticism')->where('pivot.score', '>=', 4)->isNotEmpty();

        if ($hasHighAgreeableness) {
            $content .= "### 🤝 Per il tuo profilo collaborativo\n";
            $content .= "La tua natura gentile e collaborativa è un punto di forza, ma può essere sfruttata.\n";
            $content .= "- **Ricorda**: Va bene dire \"no\" a richieste sospette\n";
            $content .= "- Verifica sempre, anche se la richiesta sembra legittima\n";
            $content .= "- La cautela non è maleducazione, è protezione\n\n";
        }

        if ($hasHighNeuroticism) {
            $content .= "### 😟 Gestione dello stress nelle decisioni\n";
            $content .= "Gli attaccanti sfruttano l'urgenza per creare stress e forzare decisioni affrettate.\n";
            $content .= "- **Pausa**: Prenditi 5 minuti prima di rispondere a richieste urgenti\n";
            $content .= "- **Respira**: L'ansia è esattamente ciò che vogliono gli attaccanti\n";
            $content .= "- **Verifica**: In caso di dubbio, consulta un collega\n\n";
        }

        if ($hasHighVigilance) {
            $content .= "### ⚠️ Attenzione continua\n";
            $content .= "Hai una bassa vigilanza, quindi:\n";
            $content .= "- Usa checklist di sicurezza prima di cliccare\n";
            $content .= "- Attiva notifiche di sicurezza sul browser\n";
            $content .= "- Fai attenzione ai dettagli nelle email\n\n";
        }

        // Esercizi pratici
        $content .= "### 🎓 Esercizio Pratico\n";
        $content .= "Prossima volta che ricevi un'email:\n";
        $content .= "1. Fermati 10 secondi\n";
        $content .= "2. Leggi il mittente completo\n";
        $content .= "3. Cerca errori o incongruenze\n";
        $content .= "4. Se c'è un link, verifica dove porta (senza cliccare)\n";
        $content .= "5. In caso di dubbio, contatta direttamente l'azienda\n\n";

        return $content;
    }

    /**
     * Utility methods
     */
    protected function getScoreLabel(int $score): string
    {
        return match($score) {
            1 => 'Nessuno',
            2 => 'Basso',
            3 => 'Medio',
            4 => 'Alto',
            5 => 'Massimo',
            default => 'Non definito'
        };
    }

    protected function getCriticalFactors($humanFactors): string
    {
        return $humanFactors
            ->filter(fn($hf) => $hf->pivot->score >= 4)
            ->pluck('name')
            ->implode(', ');
    }

    protected function buildUserProfile(User $user): string
    {
        $age = $user->dob ? now()->diffInYears($user->dob) : 'N/A';
        return "Età: {$age} anni, Genere: {$user->gender}, Ruolo: " . ($user->company_role ?? 'Dipendente');
    }

    protected function inferEducationLevel(User $user): string
    {
        // Mock per progetto universitario
        return 'Laurea';
    }

    protected function getPersonalityTraits($humanFactors): string
    {
        $personality = ['Agreeableness', 'Extroversion', 'Conscientiousness', 'Neuroticism', 'Openness'];

        return $humanFactors
            ->filter(fn($hf) => in_array($hf->name, $personality))
            ->map(fn($hf) => "{$hf->name} ({$hf->pivot->score}/5)")
            ->implode(', ') ?: 'Profilo standard';
    }

    protected function estimateReadingTime(string $text): int
    {
        $wordCount = str_word_count(strip_tags($text));
        $wordsPerMinute = 200;
        return max(1, ceil($wordCount / $wordsPerMinute));
    }
}
