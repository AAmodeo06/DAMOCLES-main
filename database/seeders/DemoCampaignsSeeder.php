<?php
// Implementato da: Cosimo Mandrillo
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TrainingCampaign;
use App\Models\User;
use App\Models\Vulnerability;
use App\Models\PromptTemplate;
use App\Models\LLM;
use Carbon\Carbon;

class DemoCampaignsSeeder extends Seeder
{
    public function run()
    {
        // Ottieni dati necessari - Cosimo Mandrillo
        $evaluator = User::where('role', 'evaluator')->first();

        if (!$evaluator) {
            $evaluator = User::factory()->create(['role' => 'evaluator']);
        }

        $vulnerabilities = Vulnerability::all();
        $templates = PromptTemplate::all();
        $llm = LLM::first();

        if ($vulnerabilities->isEmpty() || $templates->isEmpty() || !$llm) {
            $this->command->warn('Esegui prima VulnerabilitiesSeeder, PromptTemplatesSeeder e addLLMSeeder');
            return;
        }

        // Campagna 1: Draft - Cosimo Mandrillo
        TrainingCampaign::create([
            'evaluator_id' => $evaluator->id,
            'title' => 'Sensibilizzazione Phishing Base',
            'description' => 'Campagna introduttiva per riconoscere email di phishing',
            'vulnerability_id' => $vulnerabilities->where('name', 'Phishing')->first()->id,
            'content_type' => 'text',
            'verbosity' => 'medium',
            'template_id' => $templates->first()->id,
            'llm_id' => $llm->id,
            'state' => 'draft',
            'creation_phase' => 3,
            'creation_date' => now(),
            'expiration_date' => now()->addMonths(2),
        ]);

        // Campagna 2: Ready - Cosimo Mandrillo
        TrainingCampaign::create([
            'evaluator_id' => $evaluator->id,
            'title' => 'Difesa da Smishing Avanzato',
            'description' => 'Training avanzato per identificare SMS fraudolenti',
            'vulnerability_id' => $vulnerabilities->where('name', 'Smishing')->first()->id,
            'content_type' => 'audio',
            'verbosity' => 'high',
            'template_id' => $templates->where('content_type', 'audio')->first()->id,
            'llm_id' => $llm->id,
            'state' => 'ready',
            'creation_phase' => 6,
            'creation_date' => now(),
            'expiration_date' => now()->addMonths(3),
        ]);

        // Campagna 3: Ongoing - Cosimo Mandrillo
        $ongoingCampaign = TrainingCampaign::create([
            'evaluator_id' => $evaluator->id,
            'title' => 'Protezione Email Aziendale',
            'description' => 'Come proteggere le comunicazioni aziendali da attacchi BEC',
            'vulnerability_id' => $vulnerabilities->where('name', 'Business Email Compromise')->first()->id,
            'content_type' => 'text',
            'verbosity' => 'high',
            'template_id' => $templates->where('content_type', 'text')->skip(1)->first()->id,
            'llm_id' => $llm->id,
            'state' => 'ongoing',
            'creation_phase' => 6,
            'creation_date' => now()->subWeek(),
            'expiration_date' => now()->addMonth(),
        ]);

        // Campagna 4: Finished - Cosimo Mandrillo
        TrainingCampaign::create([
            'evaluator_id' => $evaluator->id,
            'title' => 'Social Engineering Basics',
            'description' => 'Fondamenti di riconoscimento tecniche di ingegneria sociale',
            'vulnerability_id' => $vulnerabilities->where('name', 'Social Engineering')->first()->id,
            'content_type' => 'text',
            'verbosity' => 'low',
            'template_id' => $templates->first()->id,
            'llm_id' => $llm->id,
            'state' => 'finished',
            'creation_phase' => 6,
            'creation_date' => now()->subMonths(2),
            'expiration_date' => now()->subWeek(),
        ]);

        $this->command->info('Campagne demo create con successo!');
    }
}
