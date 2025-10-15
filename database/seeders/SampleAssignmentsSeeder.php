<?php
<<<<<<< Updated upstream
<<<<<<< Updated upstream
<<<<<<< Updated upstream
// Realizzato da: Luigi La Gioia
=======

//REALIZZATO DA: Luigi La Gioia
>>>>>>> Stashed changes
=======

//REALIZZATO DA: Luigi La Gioia
>>>>>>> Stashed changes
=======

//REALIZZATO DA: Luigi La Gioia
>>>>>>> Stashed changes

namespace Database\Seeders;

use Illuminate\Database\Seeder;
<<<<<<< Updated upstream
<<<<<<< Updated upstream
<<<<<<< Updated upstream
=======
use Illuminate\Support\Facades\DB;
>>>>>>> Stashed changes
=======
use Illuminate\Support\Facades\DB;
>>>>>>> Stashed changes
=======
use Illuminate\Support\Facades\DB;
>>>>>>> Stashed changes
use App\Models\User;
use App\Models\TrainingCampaign;
use App\Models\TrainingUnit;
use App\Models\TrainingAssignment;
use App\Models\Notification;
<<<<<<< Updated upstream
<<<<<<< Updated upstream
<<<<<<< Updated upstream
use App\Models\AttackType;
use App\Models\PromptTemplate;
=======
>>>>>>> Stashed changes
=======
>>>>>>> Stashed changes
=======
>>>>>>> Stashed changes

class SampleAssignmentsSeeder extends Seeder
{
    public function run(): void
    {
<<<<<<< Updated upstream
<<<<<<< Updated upstream
<<<<<<< Updated upstream
        $users = User::whereHas('role', function($q) {
            $q->where('name', '!=', 'Evaluator');
        })->get();

        $phishingType = AttackType::where('name', 'Phishing')->first();
        $template = PromptTemplate::where('type', 'text')->first();

        $campaign = TrainingCampaign::create([
            'title' => 'Campagna Anti-Phishing Q4 2024',
            'attack_type_id' => $phishingType->id,
            'template_id' => $template->id,
            'training_type' => 'text',
            'status' => 'active'
        ]);

        TrainingUnit::create([
            'campaign_id' => $campaign->id,
            'content_type' => 'text',
            'content_body' => 'Unit 1: Riconoscere email di phishing',
            'order_index' => 1
        ]);

        TrainingUnit::create([
            'campaign_id' => $campaign->id,
            'content_type' => 'text',
            'content_body' => 'Unit 2: Verificare mittenti e link',
            'order_index' => 2
        ]);

        foreach ($users as $user) {
            TrainingAssignment::create([
                'user_id' => $user->id,
                'campaign_id' => $campaign->id,
                'status' => 'assigned',
                'progress' => 0,
                'assigned_at' => now()
            ]);

            Notification::create([
                'user_id' => $user->id,
                'campaign_id' => $campaign->id,
                'message' => "Nuova campagna: {$campaign->title}"
            ]);
        }
=======
=======
>>>>>>> Stashed changes
=======
>>>>>>> Stashed changes
        // 1) Utente demo (se non esiste)
        $user = User::first() ?? User::factory()->create([
            'name' => 'Target Demo',
            'email' => 'target@example.com',
            'password' => bcrypt('password'),
        ]);

        // 2) Campagna demo
        $campaign = TrainingCampaign::create([
            'title' => 'Campagna Anti-Phishing Q4 2024',
            'description' => 'Percorso base anti-phishing con due unit dimostrative.',
        ]);

        // 3) Due unit ordinate (order_index)
        $u1 = TrainingUnit::create([
            'campaign_id'  => $campaign->id,
            'content_type' => 'text',
            'content_body' => 'Unit 1: Riconoscere email di phishing',
            'order_index'  => 1,
        ]);

        $u2 = TrainingUnit::create([
            'campaign_id'  => $campaign->id,
            'content_type' => 'text',
            'content_body' => 'Unit 2: Link sicuri e domini sospetti',
            'order_index'  => 2,
        ]);

        // 4) Assegnazione al nostro utente
        $assignment = TrainingAssignment::updateOrCreate(
            ['campaign_id' => $campaign->id, 'user_id' => $user->id],
            ['status' => 'assigned', 'assigned_at' => now()]
        );

        // 5) Notifica di assegnazione (opzionale ma utile per la demo)
        Notification::create([
            'user_id'     => $user->id,
            'campaign_id' => $campaign->id,
            'message'     => 'Nuova campagna assegnata!',
            'read_at'     => null,
        ]);
<<<<<<< Updated upstream
<<<<<<< Updated upstream
>>>>>>> Stashed changes
=======
>>>>>>> Stashed changes
=======
>>>>>>> Stashed changes
    }
}
