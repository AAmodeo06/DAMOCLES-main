<?php

//MODIFICATO DA: Andrea Amodeo

use App\Http\Controllers\HAISController;
use App\Http\Controllers\DAMOCLESController;
<<<<<<< Updated upstream
use App\Http\Controllers\LLMController;
use App\Http\Controllers\WizardController;
=======
use App\Http\Controllers\CampaignManagementController;
use App\Http\Controllers\CampaignWizardController;
use App\Http\Controllers\UserTrainingController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\HumanFactorController;
>>>>>>> Stashed changes
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\QuestionnaireCampaignController;
use App\Http\Controllers\PhishingCampaignController;
use App\Http\Controllers\PhishingContextController;
use App\Http\Controllers\PhishingPersuasionController;
use App\Http\Controllers\PhishingEmotionalTriggerController;
<<<<<<< Updated upstream
=======
use App\Http\Controllers\LLMController;

>>>>>>> Stashed changes
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {

    Route::middleware(['role:Admin'])->group(function () {
        Route::get('/llms', [LLMController::class, 'index'])->name('llms.index');
        Route::post('/llm/create', [LLMController::class, 'create'])->name('llm.create');
        Route::put('/llm/{llm}', [LLMController::class, 'update'])->name('llm.update');
        Route::delete('/llm/{llm}', [LLMController::class, 'destroy'])->name('llm.destroy');
        Route::patch('/profile/updateFromAdmin', [UserController::class, 'updateFromAdmin'])->name('profile.updateFromAdmin');
        Route::delete('/profile/{id}', [UserController::class, 'destroyFromAdmin'])->name('profile.destroyFromAdmin');
        Route::get('/users/{role?}', [UserController::class, 'index'])
            ->middleware(['auth', 'verified'])
            ->name('users');

        //TRAINING-Modificato da Luigi La Gioia
        Route::get('/user/training', [UserTrainingController::class, 'index'])->name('user.training.index');
        Route::get('/user/training/units/{unit}', [UserTrainingController::class, 'showUnit'])->name('user.training.unit.show');
        Route::post('/user/training/units/{unit}/complete', [UserTrainingController::class, 'completeUnit'])->name('user.training.unit.complete');

        //NOTIFICATION-Modificato da Luigi La Gioia
        Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
        Route::post('/notifications/{notification}/read', [NotificationController::class, 'read'])->name('notifications.read');
    });

    Route::middleware(['role:Evaluator'])->group(function () {

        // Questionnaires campaigns
        Route::get('/questionnaires', [QuestionnaireCampaignController::class, 'questionnaires'])->name('questionnaires');
        Route::get('/questionnaires-campaign', [QuestionnaireCampaignController::class, 'index'])->name('questionnaires-campaign.index');

        Route::get('/questionnaires-campaign/new', [QuestionnaireCampaignController::class, 'new'])->name('questionnaires-campaign.new');
        Route::post('/questionnaire-campaign/create', [QuestionnaireCampaignController::class, 'create'])->name('questionnaire-campaign.create');

        Route::get('/questionnaire-campaign/questionnaires/{questionnaireCampaign}', [QuestionnaireCampaignController::class, 'questionnairesQuestionnaireCampaign'])->name('questionnaire-campaign.questionnaires');
        Route::post('/questionnaire-campaign/questionnaires-questionnaire-campaign', [QuestionnaireCampaignController::class, 'saveQuestionnairesQuestionnaireCampaign'])->name('questionnaire-campaign.questionnaires-questionnaire-campaign');

        Route::get('/questionnaire-campaign/users/{questionnaireCampaign}', [QuestionnaireCampaignController::class, 'users'])->name('questionnaire-campaign.users');
        Route::post('/questionnaire-campaign/users-questionnaire', [QuestionnaireCampaignController::class, 'saveUsersQuestionnaireCampaign'])->name('questionnaire-campaign.users-questionnaire-campaign');

        Route::post('/questionnaire-campaign/change-state/{questionnaireCampaign}/{state}', [QuestionnaireCampaignController::class, 'changeState'])->name('questionnaire-campaign.change-state');
        Route::get('/questionnaire-campaign/analyse/{questionnaireCampaign}', [QuestionnaireCampaignController::class, 'analyse'])->name('questionnaire-campaign.analyse');
        Route::get('/questionnaire-campaign/stop/{questionnaireCampaign}', [QuestionnaireCampaignController::class, 'stop'])->name('questionnaire-campaign.stop');
        Route::get('/questionnaire-campaign/detail/{questionnaireCampaign}', [QuestionnaireCampaignController::class, 'details'])->name('questionnaire-campaign.details');
        Route::get('/questionnaire-campaign/duplicate/{questionnaireCampaign}', [QuestionnaireCampaignController::class, 'duplicate'])->name('questionnaire-campaign.duplicate');
        Route::delete('/questionnaire-campaign/delete/{questionnaireCampaign}', [QuestionnaireCampaignController::class, 'destroy'])->name('questionnaire-campaign.destroy');

        // Questionnaires
        Route::delete('/result/{answer}', [QuestionnaireCampaignController::class, 'deleteAnswer'])->name('result.destroy');

<<<<<<< Updated upstream
=======
        //Human Factor-Modificato da Andrea Amodeo
        Route::get('/evaluator/human-factors', [HumanFactorController::class, 'index'])->name('human-factors.index');
        Route::post('/evaluator/human-factors', [HumanFactorController::class, 'store'])->name('human-factors.store');
        Route::patch('/evaluator/human-factors/{humanFactor}', [HumanFactorController::class, 'update'])->name('human-factors.update');
        Route::delete('/evaluator/human-factors/{humanFactor}', [HumanFactorController::class, 'destroy'])->name('human-factors.destroy');

        Route::get('/evaluator/users/{user}/human-factors', [HumanFactorController::class, 'assignForm'])->name('human-factors.assign');
        Route::post('/evaluator/users/{user}/human-factors', [HumanFactorController::class, 'assignStore'])->name('human-factors.assign.store');

        //LLMController-Modificato da Andrea Amodeo
        Route::get('/evaluator/llm/personalized', [LLMController::class, 'personalizedForm'])->name('llm.personalized.form');
        Route::post('/evaluator/llm/personalized', [LLMController::class, 'personalizedGenerate'])->name('llm.personalized.generate');

>>>>>>> Stashed changes
        // HAIS
        Route::get('/hais', [HAISController::class, 'preview'])->name('hais.preview');
        Route::get('/hais/result/{hais}', [HAISController::class, 'result'])->name('hais.result');
        //Route::delete('/hais/result/{hais}', [HAISController::class, 'destroy'])->name('hais.destroy');

        // DAMOCLES
        Route::get('/damocles', [DAMOCLESController::class, 'preview'])->name('damocles.preview');
        Route::get('/damocles/result/{damocles}', [DAMOCLESController::class, 'result'])->name('damocles.result');
        //Route::delete('/damocles/result/{damocles}', [DAMOCLESController::class, 'destroy'])->name('damocles.destroy');

        // Phishing campaigns
        Route::get('/phishing-campaign', [PhishingCampaignController::class, 'index'])->name('phishing-campaign.index');

        Route::get('/phishing-campaign/new', [PhishingCampaignController::class, 'new'])->name('phishing-campaign.new');
        Route::post('/phishing-campaign/create', [PhishingCampaignController::class, 'create'])->name('phishing-campaign.create');

        Route::get('/phishing-campaign/emails/{phishingCampaign}', [PhishingCampaignController::class, 'generate'])->name('phishing-campaign.generate-emails');
        Route::post('/phishing-campaign/emails', [PhishingCampaignController::class, 'savePhishingEmails'])->name('phishing-campaign.save-emails');

        Route::get('/phishing-campaign/users/{phishingCampaign}', [PhishingCampaignController::class, 'users'])->name('phishing-campaign.users');
        Route::post('/phishing-campaign/users-phishing-email', [PhishingCampaignController::class, 'saveUsersPhishingEmails'])->name('phishing-campaign.users-phishing-email');

        Route::post('/phishing-campaign/change-state/{phishingCampaign}/{state}', [PhishingCampaignController::class, 'changeState'])->name('phishing-campaign.change-state');
        Route::get('/phishing-campaign/analyse/{phishingCampaign}', [PhishingCampaignController::class, 'analyse'])->name('phishing-campaign.analyse');
        Route::get('/phishing-campaign/stop/{phishingCampaign}', [PhishingCampaignController::class, 'stop'])->name('phishing-campaign.stop');
        Route::get('/phishing-campaign/detail/{phishingCampaign}', [PhishingCampaignController::class, 'details'])->name('phishing-campaign.details');
        Route::get('/phishing-campaign/duplicate/{phishingCampaign}', [PhishingCampaignController::class, 'duplicate'])->name('phishing-campaign.duplicate');
        Route::delete('/phishing-campaign/delete/{phishingCampaign}', [PhishingCampaignController::class, 'destroy'])->name('phishing-campaign.destroy');

        Route::get('/phishing-campaign/download-data/{phishingCampaign}', [PhishingCampaignController::class, 'downloadDataCSV'])->name('phishing-campaign.download-data-csv');
        Route::get('/phishing-campaign/download-all-data', [PhishingCampaignController::class, 'downloadAllDataCSV'])->name('phishing-campaign.download-all-data-csv');

        // Wizard for creating a new phishing campaign
        //REALIZZATO DA: Andrea Amodeo
        Route::prefix('wizard')->group(function () {
            Route::get('/create-campaign', [WizardController::class, 'step1'])->name('wizard.step1');
            Route::post('/step1', [WizardController::class, 'processStep1'])->name('wizard.process.step1');
            Route::get('/step2/{session}', [WizardController::class, 'step2'])->name('wizard.step2');
            Route::post('/step2/{session}', [WizardController::class, 'processStep2'])->name('wizard.process.step2');
            Route::get('/step3/{session}', [WizardController::class, 'step3'])->name('wizard.step3');
            Route::post('/step3/{session}', [WizardController::class, 'processStep3'])->name('wizard.process.step3');
            Route::get('/step4/{session}', [WizardController::class, 'step4'])->name('wizard.step4');
            Route::post('/step4/{session}', [WizardController::class, 'processStep4'])->name('wizard.process.step4');
            Route::get('/step5/{session}', [WizardController::class, 'step5'])->name('wizard.step5');
            Route::post('/step5/{session}', [WizardController::class, 'processStep5'])->name('wizard.process.step5');
            Route::get('/step6/{session}', [WizardController::class, 'step6'])->name('wizard.step6');
            Route::post('/complete/{session}', [WizardController::class, 'complete'])->name('wizard.complete');
        });

        // LLM WEB ROUTES - Integration for simulation interface
        //REALIZZATO DA: Andrea Amodeo
        Route::prefix('llm')->group(function () {
            Route::get('/simulation/{campaign}', [LLMController::class, 'showSimulation'])->name('llm.simulation');
        });

        // LLM API ROUTES - Endpoint JSON for asynchronous communication with the LLM server
        //REALIZZATO DA: Andrea Amodeo
        Route::prefix('api/llm')->group(function () {
            Route::post('/generate-content', [LLMController::class, 'generateContent'])->name('api.llm.generate');
            Route::get('/simulation/{campaign}', [LLMController::class, 'getSimulation'])->name('api.llm.simulation');
            Route::post('/simulation/{llmGeneration}/execute', [LLMController::class, 'executeSimulation'])->name('api.llm.execute');
            Route::get('/status/{generation}', [LLMController::class, 'getStatus'])->name('api.llm.status');
        });

        // Phishing email attributes
        Route::get('/phishing-campaign/option', [PhishingCampaignController::class, 'option'])->name('phishing-campaign.option');
        Route::post('/phishing-campaign/context', [PhishingContextController::class, 'create'])->name('context.create');
        Route::delete('/phishing-campaign/context/{context}', [PhishingContextController::class, 'destroy'])->name('context.destroy');

        Route::post('/phishing-campaign/persuasion', [PhishingPersuasionController::class, 'create'])->name('persuasion.create');
        Route::delete('/phishing-campaign/persuasion/{persuasion}', [PhishingPersuasionController::class, 'destroy'])->name('persuasion.destroy');

        Route::post('/phishing-campaign/emotional-trigger', [PhishingEmotionalTriggerController::class, 'create'])->name('emotional-trigger.create');
        Route::delete('/phishing-campaign/emotional-trigger/{emotionalTrigger}', [PhishingEmotionalTriggerController::class, 'destroy'])->name('emotional-trigger.destroy');
    });

    Route::middleware(['role:Admin,Evaluator'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    });

    Route::middleware(['role:User'])->group(function () {
        Route::get('/questionnaires-campaign', [QuestionnaireCampaignController::class, 'index'])->name('questionnaires-campaign.index');
        Route::get('/questionnaires-campaign/{questionnaireCampaign}', [QuestionnaireCampaignController::class, 'joinQuestionnaireCampaign'])->name('questionnaires-campaign.questionnaire-campaign-join');

        // HAIS
        Route::post('/hais', [HAISController::class, 'create'])->name('hais.create');
        Route::get('/hais/answer/{user}/{questionnaireCampaign}/{questionnaire}', [HAISController::class, 'answer'])->name('hais.answer');

        // DAMOCLES
        Route::post('/damocles', [DAMOCLESController::class, 'create'])->name('damocles.create');
        Route::get('/damocles/answer/{user}/{questionnaireCampaign}/{questionnaire}', [DAMOCLESController::class, 'answer'])->name('damocles.answer');
    });

    Route::middleware(['role:Evaluator,User'])->group(function () {
        Route::get('/questionnaires-campaign', [QuestionnaireCampaignController::class, 'index'])->name('questionnaires-campaign.index');

        // HAIS
        Route::get('/hais/{questionnaireCampaign}/{questionnaire}', [HAISController::class, 'index'])->name('hais.index');

        // DAMOCLES
        Route::get('/damocles/{questionnaireCampaign}/{questionnaire}', [DAMOCLESController::class, 'index'])->name('damocles.index');
    });
});

// Endpoint for the link opened in the email
Route::get('/opened/{email}/{user}', [PhishingCampaignController::class, 'opened'])->name('phishing.campaign.opened');

// Endpoint for the link clicked in the email
Route::get('/clicked/{email}/{user}', [PhishingCampaignController::class, 'clicked'])->name('phishing.campaign.clicked');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [UserController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [UserController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [UserController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
