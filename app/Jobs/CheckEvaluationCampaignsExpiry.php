<?php

namespace App\Jobs;

use App\Models\PhishingCampaign;
use App\Models\QuestionnaireCampaign;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CheckEvaluationCampaignsExpiry implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Retrieve all Ongoing Phishing campaigns that are not expired
        $phishingCampaigns = PhishingCampaign::where('state', 'Ongoing')
            ->whereDate('expirationDate', '<', Carbon::now())
            ->get();

        foreach ($phishingCampaigns as $phishingCampaign) {
            $phishingCampaign->state = 'Finished';
            $phishingCampaign->save();
        }

        // Retrieve all Ongoing Questionnaire campaigns that are not expired
        $questionnaireCampaigns = QuestionnaireCampaign::where('state', 'Ongoing')
            ->whereDate('expirationDate', '<', Carbon::now())
            ->get();

        foreach ($questionnaireCampaigns as $questionnaireCampaign) {
            $questionnaireCampaign->state = 'Finished';
            $questionnaireCampaign->save();
        }
    }
}
