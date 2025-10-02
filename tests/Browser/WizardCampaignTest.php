<?php
// REALIZZATO DA: Andrea Amodeo

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;
use App\Models\Attack;
use App\Models\PromptTemplate;
use App\Models\Campaign;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class WizardCampaignTest extends DuskTestCase
{
    use DatabaseMigrations;

    protected $evaluatorUser;

    public function setUp(): void
    {
        parent::setUp();

        $this->evaluatorUser = User::factory()->create([
            'role' => 'evaluator',
            'email' => 'evaluator@test.com',
            'name' => 'Test Evaluator'
        ]);

        // Crea dati di supporto
        Attack::create([
            'name' => 'Phishing Email',
            'description' => 'Email di phishing simulato',
            'category' => 'email'
        ]);

        PromptTemplate::create([
            'name' => 'Email Template',
            'content_type' => 'text',
            'template' => 'Template per {USER_NAME}',
            'variables' => json_encode(['USER_NAME']),
            'llm_integration_id' => 1
        ]);
    }

    /**
     * Test accesso al wizard di creazione campagna
     *
     * @test
     */
    public function evaluator_can_access_campaign_wizard()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->evaluatorUser)
                    ->visit('/wizard/campaign/create')
                    ->assertSee('Wizard Creazione Campagna')
                    ->assertSee('Step 1 di 6')
                    ->assertSee('Informazioni Base')
                    ->assertPresent('#wizardForm')
                    ->assertPresent('#campaign_name')
                    ->assertPresent('#campaign_description');
        });
    }

    /**
     * Test completamento Step 1 del wizard
     *
     * @test
     */
    public function evaluator_can_complete_wizard_step_1()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->evaluatorUser)
                    ->visit('/wizard/campaign/create')
                    ->waitFor('#wizardForm')
                    ->type('#campaign_name', 'Test Campaign Wizard')
                    ->type('#campaign_description', 'Campagna di test')
                    ->select('#attack_type', '1')
                    ->press('#nextStep')
                    ->waitFor('.step-2', 5)
                    ->assertSee('Step 2 di 6')
                    ->assertSee('Selezione Utenti Target');
        });
    }

    /**
     * Test navigazione completa attraverso tutti gli step
     *
     * @test
     */
    public function evaluator_can_navigate_through_all_wizard_steps()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->evaluatorUser)
                    ->visit('/wizard/campaign/create')
                    ->waitFor('#wizardForm')

                    // Step 1: Informazioni Base
                    ->type('#campaign_name', 'Campagna Test Completa')
                    ->type('#campaign_description', 'Test navigazione completa')
                    ->select('#attack_type', '1')
                    ->press('#nextStep')

                    // Step 2: Selezione Utenti
                    ->waitFor('.step-2', 5)
                    ->assertSee('Step 2 di 6')
                    ->check('#target_all_users')
                    ->press('#nextStep')

                    // Step 3: Configurazione Contenuto
                    ->waitFor('.step-3', 5)
                    ->assertSee('Step 3 di 6')
                    ->select('#content_type', 'text')
                    ->select('#template_id', '1')
                    ->press('#nextStep')

                    // Step 4: Human Factors
                    ->waitFor('.step-4', 5)
                    ->assertSee('Step 4 di 6')
                    ->press('#nextStep')

                    // Step 5: Pianificazione
                    ->waitFor('.step-5', 5)
                    ->assertSee('Step 5 di 6')
                    ->type('#start_date', now()->addDays(1)->format('Y-m-d'))
                    ->type('#end_date', now()->addDays(30)->format('Y-m-d'))
                    ->press('#nextStep')

                    // Step 6: Riepilogo
                    ->waitFor('.step-6', 5)
                    ->assertSee('Step 6 di 6')
                    ->assertSee('Riepilogo e Conferma')
                    ->assertSee('Campagna Test Completa');
        });
    }

    /**
     * Test creazione completa campagna tramite wizard
     *
     * @test
     */
    public function evaluator_can_create_campaign_through_wizard()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->evaluatorUser)
                    ->visit('/wizard/campaign/create')
                    ->waitFor('#wizardForm')

                    // Completa tutti gli step
                    ->type('#campaign_name', 'Campagna Creata da Wizard')
                    ->type('#campaign_description', 'Campagna di test completa')
                    ->select('#attack_type', '1')
                    ->press('#nextStep')

                    ->waitFor('.step-2')
                    ->check('#target_all_users')
                    ->press('#nextStep')

                    ->waitFor('.step-3')
                    ->select('#content_type', 'text')
                    ->select('#template_id', '1')
                    ->press('#nextStep')

                    ->waitFor('.step-4')
                    ->press('#nextStep')

                    ->waitFor('.step-5')
                    ->type('#start_date', now()->addDays(1)->format('Y-m-d'))
                    ->type('#end_date', now()->addDays(30)->format('Y-m-d'))
                    ->press('#nextStep')

                    ->waitFor('.step-6')
                    ->press('#finalSubmit')
                    ->waitFor('.alert-success', 10)
                    ->assertSee('Campagna creata con successo');
        });
    }
}
