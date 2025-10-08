<?php
// Realizzato da: Cosimo Mandrillo

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;
use App\Models\Role;
use App\Models\TrainingCampaign;
use App\Models\TrainingAssignment;
use App\Models\AttackType;

class CampaignPauseFlowTest extends DuskTestCase
{
    public function test_evaluator_can_pause_campaign()
    {
        $evaluatorRole = Role::factory()->create(['name' => 'Evaluator']);
        $evaluator = User::factory()->create(['role_id' => $evaluatorRole->id]);

        $userRole = Role::factory()->create(['name' => 'Impiegato']);
        $user = User::factory()->create(['role_id' => $userRole->id]);

        $attackType = AttackType::factory()->create();
        $campaign = TrainingCampaign::factory()->create([
            'attack_type_id' => $attackType->id,
            'status' => 'active'
        ]);

        TrainingAssignment::create([
            'user_id' => $user->id,
            'campaign_id' => $campaign->id,
            'status' => 'in_progress',
            'progress' => 50,
            'assigned_at' => now()
        ]);

        $this->browse(function (Browser $browser) use ($evaluator, $campaign) {
            $browser->loginAs($evaluator)
                    ->visit("/evaluator/campaigns/{$campaign->id}")
                    ->assertSee('Stato:')
                    ->assertSee('active')
                    ->press('Metti in Pausa')
                    ->waitForText('Stato campagna aggiornato')
                    ->assertSee('paused');
        });
    }
}
