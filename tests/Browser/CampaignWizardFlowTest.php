<?php
// Realizzato da: Andrea Amodeo

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;
use App\Models\Role;
use App\Models\PromptTemplate;

class CampaignWizardFlowTest extends DuskTestCase
{
    public function test_evaluator_can_simulate_prompt_template()
    {
        $evaluatorRole = Role::factory()->create(['name' => 'Evaluator']);
        $evaluator = User::factory()->create(['role_id' => $evaluatorRole->id]);

        $template = PromptTemplate::factory()->create([
            'body' => 'Ciao {{user_name}}, il tuo ruolo è {{user_role}}.'
        ]);

        $this->browse(function (Browser $browser) use ($evaluator, $template) {
            $browser->loginAs($evaluator)
                    ->visit('/evaluator/prompt-templates/1')
                    ->type('user_name', 'Mario Rossi')
                    ->type('user_role', 'Manager')
                    ->click('button[onclick="generatePreview()"]')
                    ->waitForText('Preview Generata')
                    ->assertSee('Ciao Mario Rossi, il tuo ruolo è Manager');
        });
    }
}
