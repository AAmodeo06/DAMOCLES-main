<?php

namespace App\Jobs;

use App\Models\PhishingCampaign;
use App\Models\PhishingEmailPhishingCampaign;
use App\Models\UserPhishingEmail;
use App\Models\User;
use App\Jobs\SendPhishingEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SendPeriodicPhishingEmails implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Retrieve all ongoing phishing campaigns that have not expired
        $ongoingCampaigns = PhishingCampaign::where('state', 'Ongoing')
            ->where('expirationDate', '>', now())
            ->get();

        foreach ($ongoingCampaigns as $phishingCampaign) {
            // Check the last email sent time for the campaign
            $lastEmailSentAt = UserPhishingEmail::whereHas('phishingEmail', function ($query) use ($phishingCampaign) {
                $query->where('phishing_campaign_id', $phishingCampaign->id);
            })->max('sent');

            // Calculate the next send time
            $nextSendTime = $lastEmailSentAt ? Carbon::parse($lastEmailSentAt)->addDays($phishingCampaign->timingEmail) : now();

            // If the next send time is in the future, skip this campaign
            if ($nextSendTime->isFuture()) {
                continue;
            }

            // Retrieve all emails associated with the phishing campaign
            $emails = $phishingCampaign->phishingEmails;

            if ($emails->isEmpty()) {
                $this->changeState($phishingCampaign->id, 'Finished');
                continue;
            }

            // Retrieve all email IDs associated with the campaign
            $emailIds = $emails->pluck('id');

            // Retrieve all email not sent
            $emailsNotSent = UserPhishingEmail::whereIn('email_id', $emailIds)
                ->whereNull('sent')
                ->get();

            if ($emailsNotSent->isEmpty()) {
                $this->changeState($phishingCampaign->id, 'Finished');
                continue;
            }

            // Get the first email not sent ID
            $emailId = $emailsNotSent->first()->email_id;

            // Retrieve the details of the first email not sent
            $email = PhishingEmailPhishingCampaign::find($emailId);

            // Retrieve the user IDs associated with that email
            $userPhishingEmails = UserPhishingEmail::where('email_id', $emailId)->get();
            $userIds = $userPhishingEmails->pluck('user_id')->unique();

            // Retrieve users using the obtained IDs
            $users = User::whereIn('id', $userIds)->get();

            // Create a map of user_id to UserPhishingEmail for easy access
            $userPhishingEmailMap = $userPhishingEmails->keyBy('user_id');

            if ($phishingCampaign->state == "Ongoing") {
                DB::beginTransaction();
                try {
                    $subjectTemplate = $email->subject;
                    $bodyTemplate = $email->body;

                    foreach ($users as $user) {
                        try {
                            $subject = $this->replacePlaceholders($subjectTemplate, $user);
                            $body = $this->replacePlaceholders($bodyTemplate, $user);

                            // Dispatch the job
                            SendPhishingEmail::dispatch($emailId, $user, $subject, $body);

                            // Retrieve the UserPhishingEmail for this user
                            $userPhishingEmail = $userPhishingEmailMap->get($user->id);

                            if ($userPhishingEmail) {
                                // Update the 'sent' field to true
                                $userPhishingEmail->sent = true;

                                // Simulate the clicked field
                                $userPhishingEmail->clicked = (bool)rand(0, 1);

                                $userPhishingEmail->save();
                            }
                        } catch (\Exception $e) {
                            // Handle exception if necessary
                        }
                    }

                    DB::commit();
                } catch (\Exception $e) {
                    DB::rollBack();
                    return response()->json(['error' => 'Failed to dispatch jobs: ' . $e->getMessage()], 500);
                }
            }

            // Check if all the emails are sent
            $remainingEmailsNotSent = UserPhishingEmail::whereIn('email_id', $emailIds)
                ->whereNull('sent')
                ->count();

            if ($remainingEmailsNotSent == 0) {
                $this->changeState($phishingCampaign->id, 'Finished');
            }
        }
    }

    private function replacePlaceholders($text, $user)
    {
        $placeholders = [
            '-name' => $user->name,
            '-surname' => $user->surname,
            '-email' => $user->email,
            '-dob' => $user->dob,
        ];

        foreach ($placeholders as $placeholder => $value) {
            $text = str_replace($placeholder, $value, $text);
        }

        return $text;
    }

    private function changeState($phishingCampaignId, $state)
    {
        $phishingCampaign = PhishingCampaign::findOrFail($phishingCampaignId);
        $phishingCampaign->state = $state;
        $phishingCampaign->save();
    }
}
