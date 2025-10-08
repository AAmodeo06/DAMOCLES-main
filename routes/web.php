<?php

//MODIFICATO DA: Andrea Amodeo
//MODIFICATO DA: Luigi La Gioia
//MODIFICATO DA: Cosimo Mandrillo

use App\Http\Controllers\HAISController;
use App\Http\Controllers\DAMOCLESController;
use App\Http\Controllers\CampaignManagementController;
use App\Http\Controllers\CampaignWizardController;
use App\Http\Controllers\UserTrainingController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PromptTemplateController;
use App\Http\Controllers\HumanFactorController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\QuestionnaireCampaignController;
use App\Http\Controllers\PhishingCampaignController;
use App\Http\Controllers\PhishingContextController;
use App\Http\Controllers\PhishingPersuasionController;
use App\Http\Controllers\PhishingEmotionalTriggerController;
use App\Http\Controllers\LLMController;
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

        //Human Factor-Modificato da Andrea Amodeo
        Route::get('/evaluator/human-factor', [HumanFactorController::class, 'index'])->name('human-factor.index');
        Route::post('/evaluator/human-factors', [HumanFactorController::class, 'store'])->name('human-factor.store');
        Route::put('/evaluator/human-factors/{humanFactor}', [HumanFactorController::class, 'update'])->name('human-factors.update');
        Route::delete('/evaluator/human-factors/{humanFactor}', [HumanFactorController::class, 'destroy'])->name('human-factors.destroy');

        //Prompt Templates-Modificato da Andrea Amodeo
        Route::get('/evaluator/prompt-templates', [PromptTemplateController::class, 'index'])->name('prompt-templates.index');
        Route::post('/evaluator/prompt-templates/simulate', [PromptTemplateController::class, 'simulate'])->name('prompt-templates.simulate');

        // HAIS
        Route::get('/hais', [HAISController::class, 'preview'])->name('hais.preview');
        Route::get('/hais/result/{hais}', [HAISController::class, 'result'])->name('hais.result');
        //Route::delete('/hais/result/{hais}', [HAISController::class, 'destroy'])->name('hais.destroy');

        //CAMPAIGN WIZARD-Modificato da Cosimo Mandrillo
        Route::get('/evaluator/campaigns/create', [CampaignWizardController::class, 'create'])->name('campaigns.create');
        Route::post('/evaluator/campaigns', [CampaignWizardController::class, 'store'])->name('campaigns.store');
        Route::get('/evaluator/campaigns/{campaign}/preview', [CampaignManagementController::class, 'preview'])->name('campaigns.preview');

        //CAMPAIGN MANAGEMENT-Modificato da Cosimo Mandrillo
        Route::get('/evaluator/campaigns', [CampaignManagementController::class, 'index'])->name('campaigns.index');
        Route::get('/evaluator/campaigns/{campaign}', [CampaignManagementController::class, 'show'])->name('campaigns.show');
        Route::post('/evaluator/campaigns/{campaign}/state', [CampaignManagementController::class, 'changeState'])->name('campaigns.changeState');

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

        //TRAINING-Modificato da Luigi La Gioia
        Route::get('/user/training', [UserTrainingController::class, 'index'])->name('user.training.index');
        Route::get('/user/training/{session}', [UserTrainingController::class, 'show'])->name('user.training.show');
        Route::post('/user/training/{session}/complete', [UserTrainingController::class, 'complete'])->name('user.training.complete');

        //NOTIFICATION-Modificato da Luigi La Gioia
        Route::get('/user/notifications', [NotificationController::class, 'index'])->name('notifications.index');
        Route::post('/notifications/{notification}/read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
        Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.readAll');
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
