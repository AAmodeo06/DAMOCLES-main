<?php
// Realizzato da: Luigi La Gioia

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\TrainingCampaign;
use App\Models\TrainingUnit;
use App\Models\TrainingAssignment;
use App\Models\Notification;
use App\Models\AttackType;
use App\Models\PromptTemplate;

class SampleAssignmentsSeeder extends Seeder
{
    public function run(): void
    {
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
    }
}
