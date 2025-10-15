<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\Rule;
use App\Models\User;
use App\Models\TrainingCampaign;
use App\Models\TrainingUnit;
use App\Models\Vulnerability;

class LLMController extends Controller
{
    // === FORM ===
    public function personalizedForm()
    {
        return view('evaluator/llm/generate', [
            'users'      => User::orderBy('id')->get(['id','name','email']),
            'campaigns'  => TrainingCampaign::orderBy('title')->get(['id','title']),
            // attacchi disponibili (prendiamo da vulnerabilities)
            'attacks'    => Vulnerability::orderBy('name')->get(['id','name']),
        ]);
    }

    // === GENERATE ===
    public function personalizedGenerate(Request $req)
    {
        $data = $req->validate([
            'user_id'     => ['required','exists:users,id'],
            'campaign_id' => ['required','exists:training_campaigns,id'],
            'vulnerability_id' => ['required','exists:vulnerabilities,id'],
            'modality'    => ['required', Rule::in(['text','audio'])], // testo o script audio
            'language'    => ['required', Rule::in(['it','en'])],
        ]);

        $user   = User::findOrFail($data['user_id']);
        $camp   = TrainingCampaign::findOrFail($data['campaign_id']);
        $vuln   = Vulnerability::findOrFail($data['vulnerability_id']);
        $locale = $data['language'];
        $mode   = $data['modality']; // text | audio

        // 1) prendi i debiti dell’utente (pivot user_human_factor)
        // ordina per livello: max > high > medium > low > none e prendi i primi 3
        $rank = ['none'=>0,'low'=>1,'medium'=>2,'high'=>3,'max'=>4];
        $userFactors = $user->humanFactors()
            ->select('human_factors.id','human_factors.name','human_factors.slug')
            ->withPivot('debt_level')
            ->get()
            ->sortByDesc(fn($hf) => $rank[strtolower($hf->pivot->debt_level)] ?? 0)
            ->take(3)
            ->values();

        // se l’utente non ha debiti alti, prova a proporre i 3 HF più legati alla vulnerabilità scelta
        if ($userFactors->isEmpty() || ($rank[strtolower($userFactors->first()->pivot->debt_level)] ?? 0) < 2) {
            $related = $vuln->humanFactors()->select('human_factors.id','name','slug')->take(3)->get();
            // attacca un finto debt_level “medium” solo per costruire il prompt
            $userFactors = $related->map(function($hf){ $hf->pivot = (object)['debt_level'=>'medium']; return $hf; });
        }

        // 2) costruisci il prompt di sistema + utente seguendo la TRACCIA del professore
        [$system, $userPrompt] = $this->buildPromptFromFactors($vuln->name, $userFactors, $mode, $locale);

        // 3) chiama LLM (endpoint OpenAI-compatibile, gratuito di default)
        $text = $this->chatOpenAICompatible($system, $userPrompt);

        // 4) salva come TrainingUnit (type: text | audio_script)
        $unit = TrainingUnit::create([
            'campaign_id' => $camp->id,
            'title'       => "Training {$vuln->name} – " . ($mode === 'audio' ? 'Script audio' : 'Testo'),
            'type'        => $mode === 'audio' ? 'audio_script' : 'text',
            'content'     => $text,
        ]);

        // NB: se un giorno vuoi generare l'audio vero via TTS (ElevenLabs), qui puoi farlo
        // e salvare il path in un campo separato (es. content_url). Lasciamo opzionale.

        return back()->with('success', "Contenuto generato (#{$unit->id}).");
    }

    // ========= Helpers =========

    private function buildPromptFromFactors(string $attackName, $factors, string $mode, string $lang): array
    {
        // Mappa breve (puoi estendere) → rende leggibili i nomi HF nei prompt
        $label = [
            'education-level' => ['it' => 'livello di istruzione', 'en'=>'education level'],
            'vigilance'       => ['it' => 'vigilanza',             'en'=>'vigilance'],
            'lack-of-awareness'=>['it' => 'consapevolezza delle minacce', 'en'=>'lack of awareness'],
        ];

        // prendi fino a 3 fattori e crea elenco localizzato
        $items = $factors->map(function($hf) use ($label, $lang){
            $slug = str($hf->slug ?? str($hf->name)->slug())->toString();
            $nice = $label[$slug][$lang] ?? ($lang==='it' ? $hf->name : str($hf->name)->lower());
            return $nice;
        })->values()->all();

        // fallback
        if (empty($items)) $items = $lang==='it'
            ? ['vigilanza','consapevolezza delle minacce','livello di istruzione']
            : ['vigilance','awareness','education level'];

        if ($lang === 'it') {
            if ($mode === 'text') {
                $system = "Sei un assistente che genera contenuti didattici di cybersecurity per dipendenti di Pubbliche Amministrazioni italiane. Stile: amichevole, rassicurante, non tecnico, con esempi concreti e checklist.";
                $user   = "Genera un testo di training sulla sicurezza informatica con particolare attenzione alla prevenzione degli attacchi di {$attackName}, mirato a un utente che ha mostrato debolezze in: ".implode(', ', $items).".
Il testo deve includere:
1) Spiegazione semplice e accessibile dell'attacco (cos'è, come funziona).
2) Tecniche di riconoscimento di email/messaggi sospetti con esempi pratici.
3) Esercizi quotidiani per migliorare la vigilanza (checklist di 5 punti).
4) Suggerimenti per aumentare la consapevolezza del contesto digitale (aggiornarsi, attenzione a link/alle richieste, osservare colleghi).
Tono amichevole e rassicurante. Linguaggio semplice, frasi brevi. Includi una sezione 'Cosa fare subito' con 5 bullet concreti.";
            } else { // audio script
                $system = "Sei un assistente che scrive script audio brevi e coinvolgenti per training di cybersecurity nella PA italiana. Tono amichevole e rassicurante. Indica pause con [pausa breve].";
                $user   = "Genera uno script per un file audio di training focalizzato sulla prevenzione degli attacchi di {$attackName}, per un utente con debolezze in: ".implode(', ', $items).".
Includi:
- Introduzione chiara e non tecnica: cos'è {$attackName}.
- Segnali d'allarme comuni (errori grammaticali, urgenze sospette, link anomali).
- Consigli pratici per aumentare la vigilanza quotidiana (3-5 suggerimenti).
- Strategie per migliorare la consapevolezza (aggiornarsi sulle truffe, osservare le prassi sicure dei colleghi).
Usa frasi brevi, inviti all'azione e suggerisci [pausa breve] dove opportuno.";
            }
        } else {
            // EN version (se servisse)
            if ($mode === 'text') {
                $system = "You generate friendly, reassuring cybersecurity training for public administration employees. Avoid jargon. Provide concrete examples and checklists.";
                $user   = "Write a training text about preventing {$attackName} attacks, targeted to a user weak in: ".implode(', ', $items).".
Include: 1) simple explanation, 2) practical red flags with examples, 3) daily vigilance exercises (5-point checklist), 4) tips to increase digital awareness. Friendly tone, short sentences.";
            } else {
                $system = "You write short, engaging audio scripts for cybersecurity training. Friendly, reassuring tone. Indicate pauses with [short pause].";
                $user   = "Generate an audio script about preventing {$attackName} attacks for a user weak in: ".implode(', ', $items).".
Include: clear intro, common red flags, practical vigilance tips, strategies to increase awareness. Short sentences, calls to action, add [short pause] markers.";
            }
        }

        return [$system, $user];
    }

    private function chatOpenAICompatible(string $system, string $user): string
    {
        $provider = env('LLM_PROVIDER','g4f');
        $base     = rtrim(env('LLM_BASE_URL','http://g4f:1337/v1'), '/');
        $model    = env('LLM_MODEL','gpt-4o-mini');

        if ($provider === 'openai') {
            $base  = rtrim(env('OPENAI_BASE_URL','https://api.openai.com/v1'), '/');
            $model = env('OPENAI_MODEL','gpt-4o-mini');
        }

        $req = [
            'model' => $model,
            'messages' => [
                ['role' => 'system', 'content' => $system],
                ['role' => 'user',   'content' => $user],
            ],
            'temperature' => 0.7,
            'max_tokens'  => 1200,
        ];

        $http = Http::timeout(60);
        if ($key = env('OPENAI_API_KEY')) {
            $http = $http->withToken($key);
        }

        $resp = $http->post("{$base}/chat/completions", $req);
        abort_unless($resp->ok(), 500, 'LLM error: '.$resp->status().' '.$resp->body());

        $text = data_get($resp->json(), 'choices.0.message.content');
        abort_if(!is_string($text) || $text === '', 500, 'LLM empty response');

        return $text;
    }
}
