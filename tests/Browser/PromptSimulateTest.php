<?php
// Implementato da: Andrea Amodeo
namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Laravel\Dusk\TestCase as DuskTestCase;
use App\Models\User;
use App\Models\PromptTemplate;
use App\Models\Vulnerability;

class PromptSimulateTest extends DuskTestCase
{
    public function evaluator_can_view_template_catalog()
    {
        $evaluator = User::factory()->create(['role' => 'evaluator']);
        PromptTemplate::factory()->count(3)->create();

        $this->browse(function (Browser $browser) use ($evaluator) {
            $browser->loginAs($evaluator)
                    ->visit('/evaluator/prompt-templates')
                    ->assertSee('Template Prompt')
                    ->assertPresent('.template-card');
        });
    }
    public function evaluator_can_simulate_template_with_fake_users()
    {
        $evaluator = User::factory()->create(['role' => 'evaluator']);
        $template = PromptTemplate::factory()->create();
        $fakeUsers = User::factory()->count(2)->create(['isFake' => true]);
        $vulnerability = Vulnerability::factory()->create();

        $this->browse(function (Browser $browser) use ($evaluator, $template, $fakeUsers, $vulnerability) {
            $browser->loginAs($evaluator)
                    ->visit('/evaluator/prompt-templates')
                    ->click('.simulate-btn')
                    ->waitForText('Simulazione Template')
                    ->select('template_id', $template->id)
                    ->select('vulnerability_id', $vulnerability->id)
                    ->check('fake_users[]', $fakeUsers->first()->id)
                    ->type('custom_instructions', 'Focus su esempi pratici')
                    ->press('Avvia Simulazione')
                    ->waitForText('Risultati Simulazione')
                    ->assertSee($fakeUsers->first()->name)
                    ->assertSee('Contenuto Generato');
        });
    }

    public function simulation_results_are_stored_in_session()
    {
        $evaluator = User::factory()->create(['role' => 'evaluator']);
        $template = PromptTemplate::factory()->create();
        $fakeUser = User::factory()->create(['isFake' => true]);
        $vulnerability = Vulnerability::factory()->create();

        $this->browse(function (Browser $browser) use ($evaluator, $template, $fakeUser, $vulnerability) {
            $browser->loginAs($evaluator)
                    ->visit('/evaluator/prompt-templates/simulate')
                    ->post('/evaluator/prompt-templates/simulate', [
                        'template_id' => $template->id,
                        'fake_users' => [$fakeUser->id],
                        'vulnerability_id' => $vulnerability->id,
                    ])
                    ->assertSessionHas('simulation_results')
                    ->assertSessionHas('template_settings');
        });
    }
}
