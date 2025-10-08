<?php
// Implementato da: Andrea Amodeo
namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;
use App\Models\HumanFactor;

class HumanFactorsCrudTest extends DuskTestCase
{
    public function evaluator_can_view_human_factors_list()
    {
        $evaluator = User::factory()->create(['role' => 'evaluator']);
        HumanFactor::factory()->count(3)->create();

        $this->browse(function (Browser $browser) use ($evaluator) {
            $browser->loginAs($evaluator)
                    ->visit('/evaluator/human-factors')
                    ->assertSee('Human Factors Management')
                    ->assertSee('Nuovo Human Factor');
        });
    }

    public function evaluator_can_create_new_human_factor()
    {
        $evaluator = User::factory()->create(['role' => 'evaluator']);

        $this->browse(function (Browser $browser) use ($evaluator) {
            $browser->loginAs($evaluator)
                    ->visit('/evaluator/human-factors')
                    ->click('button[data-bs-target="#createHFModal"]')
                    ->waitFor('#createHFModal')
                    ->type('name', 'Risk Perception')
                    ->type('description', 'Capacità di percepire rischi informatici')
                    ->press('Crea')
                    ->waitForText('Human Factor creato con successo')
                    ->assertSee('Risk Perception');
        });

        $this->assertDatabaseHas('human_factors', [
            'name' => 'Risk Perception'
        ]);
    }
    public function evaluator_can_delete_human_factor()
    {
        $evaluator = User::factory()->create(['role' => 'evaluator']);
        $hf = HumanFactor::factory()->create(['name' => 'Test Factor']);

        $this->browse(function (Browser $browser) use ($evaluator, $hf) {
            $browser->loginAs($evaluator)
                    ->visit('/evaluator/human-factors')
                    ->press('Elimina')
                    ->acceptDialog()
                    ->waitForText('Human Factor eliminato')
                    ->assertDontSee('Test Factor');
        });

        $this->assertDatabaseMissing('human_factors', ['id' => $hf->id]);
    }
}
