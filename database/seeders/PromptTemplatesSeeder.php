<?php
// Realizzato da: Andrea Amodeo

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PromptTemplate;

class PromptTemplatesSeeder extends Seeder
{
    public function run()
    {
        // Template per Testo - Andrea Amodeo
        PromptTemplate::create([
            'name' => 'Template Phishing Base - Testo',
            'content_type' => 'text',
            'content' => 'Crea un contenuto formativo sul phishing per {{user_name}}.
                          Considera i seguenti human factors: {{human_factors}}.
                          Il contenuto deve essere adatto al livello {{education_level}}
                          e tenere conto di {{vulnerability_name}}.',
            'description' => 'Template base per contenuti testuali anti-phishing personalizzati'
        ]);

        PromptTemplate::create([
            'name' => 'Template Smishing Base - Testo',
            'content_type' => 'text',
            'content' => 'Genera una guida formativa sullo smishing per {{user_name}}.
                          Human factors da considerare: {{human_factors}}.
                          Adatta il linguaggio a {{personality_traits}}.',
            'description' => 'Template per training su attacchi SMS'
        ]);

        // Template per Audio/Podcast - Andrea Amodeo
        PromptTemplate::create([
            'name' => 'Template Phishing - Podcast',
            'content_type' => 'audio',
            'content' => 'Crea uno script per podcast formativo sul phishing destinato a {{user_name}}.
                          Durata: 5-7 minuti. Tono conversazionale.
                          Human factors: {{human_factors}}.
                          Includi esempi pratici e quiz finale.',
            'description' => 'Template per contenuti audio personalizzati'
        ]);

        PromptTemplate::create([
            'name' => 'Template Generale - Testo Avanzato',
            'content_type' => 'text',
            'content' => 'Sviluppa un modulo formativo avanzato su {{vulnerability_name}} per {{user_name}}.
                          Profilo utente: {{user_profile}}.
                          Human factors critici: {{critical_hf}}.
                          Includi: teoria, casi studio, esercizi pratici, autovalutazione.',
            'description' => 'Template completo per formazione approfondita'
        ]);
    }
}
