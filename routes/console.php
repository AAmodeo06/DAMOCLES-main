<?php

use App\Jobs\CheckEvaluationCampaignsExpiry;
use App\Jobs\SendPeriodicPhishingEmails;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

// Check on expiration campaign
Schedule::job(CheckEvaluationCampaignsExpiry::class)->hourly();

// Check and send the periodic emails
Schedule::job(SendPeriodicPhishingEmails::class)->hourly();
