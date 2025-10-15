<?php
// Realizzato da: Luigi La Gioia

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;
use App\Models\TrainingCampaign;
use App\Models\TrainingUnit;
use App\Models\TrainingAssignment;
use App\Models\AttackType;
use App\Models\Role;

class UserFollowTrainingTest extends DuskTestCase
{
    public function test_user_can_complete_unit_and_see_progress()
    {
        $role = Role::factory()->create(['name' => 'Impiegato']);
        $user = User::factory()->create(['role_id' => $role->id]);
        $attackType = AttackType::factory()->create();

        $campaign = TrainingCampaign::factory()->create([
            'attack_type_id' => $attackType->id,
            'status' => 'active'
        ]);

        $unit = TrainingUnit::factory()->create([
            'campaign_id' => $campaign->id,
            'order_index' => 1
        ]);

        $assignment = TrainingAssignment::create([
            'user_id' => $user->id,
            'campaign_id' => $campaign->id,
            'status' => 'assigned',
            'progress' => 0,
            'assigned_at' => now()
        ]);

        $this->browse(function (Browser $browser) use ($user, $unit, $assignment) {
            $browser->loginAs($user)
                    ->visit('/user/training')
                    ->assertSee($assignment->campaign->title)
                    ->assertSee('Progress: 0%')
                    ->clickLink('Continua Training')
                    ->assertPathIs("/user/training/units/{$unit->id}")
                    ->assertSee($unit->content_body)
                    ->press('Completa Unit')
                    ->assertPathIs('/user/training')
                    ->assertSee('Unit completata!');
        });
    }
}
