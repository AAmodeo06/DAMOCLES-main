<?php
// REALIZZATO DA: Andrea Amodeo

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;
use App\Models\LLMIntegration;
use App\Models\PromptTemplate;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class LLMSimulationTest extends DuskTestCase
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

        // Crea dati di test
        LLMIntegration::create([
            'name' => 'Test OpenAI',
            'provider' => 'openai',
            'model' => 'gpt-4',
            'api_endpoint' => 'https://api.openai.com/v1/chat/completions',
            'config' => json_encode(['max_tokens' => 1000]),
            'is_active' => true
        ]);

        PromptTemplate::create([
            'name' => 'Test Template',
            'content_type' => 'text',
            'template' => 'Test prompt for {USER_NAME}',
            'variables' => json_encode(['USER_NAME']),
            'llm_integration_id' => 1
        ]);
    }

    /**
     * Test accesso alla pagina di simulazione LLM
     *
     * @test
     */
    public function evaluator_can_access_llm_simulation_page()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->evaluatorUser)
                    ->visit('/llm/simulation')
                    ->assertSee('Simulazione LLM Personalizzata')
                    ->assertSee('Configurazione Utente Fittizio')
                    ->assertPresent('#simulationForm')
                    ->assertPresent('#fake_user_name')
                    ->assertPresent('#fake_user_role');
        });
    }

    /**
     * Test compilazione form di simulazione
     *
     * @test
     */
    public function evaluator_can_fill_simulation_form()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->evaluatorUser)
                    ->visit('/llm/simulation')
                    ->waitFor('#simulationForm')
                    ->type('#fake_user_name', 'Mario Rossi')
                    ->type('#fake_user_role', 'Impiegato')
                    ->type('#fake_user_organization', 'Regione Puglia')
                    ->select('#attack_type', '1')
                    ->select('#content_type', 'text')
                    ->select('#template_id', '1')
                    ->type('#custom_prompt', 'Prompt personalizzato per test')
                    ->assertInputValue('#fake_user_name', 'Mario Rossi')
                    ->assertSelected('#content_type', 'text');
        });
    }

    /**
     * Test generazione contenuto LLM
     *
     * @test
     */
    public function evaluator_can_generate_llm_content()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->evaluatorUser)
                    ->visit('/llm/simulation')
                    ->waitFor('#simulationForm')
                    ->type('#fake_user_name', 'Anna Verdi')
                    ->type('#fake_user_role', 'Manager')
                    ->type('#fake_user_organization', 'Test Corp')
                    ->select('#attack_type', '1')
                    ->select('#content_type', 'text')
                    ->select('#template_id', '1')
                    ->press('#generateContent')
                    ->waitFor('#simulationResult', 10)
                    ->assertSee('Contenuto Generato')
                    ->assertPresent('#generatedContent');
        });
    }

    /**
     * Test preview prompt personalizzato
     *
     * @test
     */
    public function evaluator_can_preview_custom_prompt()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->evaluatorUser)
                    ->visit('/llm/simulation')
                    ->waitFor('#simulationForm')
                    ->type('#fake_user_name', 'Luigi Bianchi')
                    ->type('#fake_user_role', 'Sviluppatore')
                    ->type('#custom_prompt', 'Ciao {USER_NAME}, lavori come {JOB_ROLE}')
                    ->press('#previewPrompt')
                    ->waitFor('.swal2-container', 5)
                    ->assertSeeIn('.swal2-html-container', 'Luigi Bianchi')
                    ->assertSeeIn('.swal2-html-container', 'Sviluppatore')
                    ->press('.swal2-close');
        });
    }

    /**
     * Test validazione campi obbligatori
     *
     * @test
     */
    public function simulation_form_validates_required_fields()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->evaluatorUser)
                    ->visit('/llm/simulation')
                    ->waitFor('#simulationForm')
                    ->press('#generateContent')
                    ->waitFor('.alert-danger', 5)
                    ->assertSee('richiesto')
                    ->assertPresent('.is-invalid');
        });
    }
}
