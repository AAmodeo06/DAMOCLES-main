<?php

namespace App\Http\Controllers;

use App\Models\PhishingContext;
use App\Models\PhishingPersuasion;
use App\Models\PhishingEmailPhishingCampaign;
use App\Models\PhishingEmotionalTrigger;
use App\Models\LLM;
use App\Models\PhishingCampaign;
use App\Models\UserPhishingEmail;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use App\Jobs\SendPhishingEmail;

use Carbon\Carbon;
use Faker\Factory as Faker;
use GuzzleHttp\Client;

class PhishingCampaignController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $phishingCampaigns = [];

        if ($user->role === 'Evaluator') {
            $phishingCampaigns = PhishingCampaign::where('evaluator_id', $user->id)->get();
        }

        return view('phishing-campaign.phishing-campaign', compact('phishingCampaigns'));
    }

    public function new()
    {
        $contexts = PhishingContext::all();
        $persuasions = PhishingPersuasion::all();
        $emotionalTriggers = PhishingEmotionalTrigger::all();
        $llms = LLM::all();

        return view('phishing-campaign.new-phishing-campaign', compact('contexts', 'persuasions', 'emotionalTriggers', 'llms'));
    }

    public function create(Request $request)
    {
        $validatedData = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'numberEmails' => ['required', 'integer', 'min:1', 'max:10'],
            'contextId' => ['required', 'integer'],
            'emotionalTriggers' => ['nullable'],
            'persuasions' => ['nullable'],
            'llmId' => ['required', 'integer'],
            'prompt' => ['required'],
            'evaluatorId' => ['required', 'integer'],
            'state' => ['nullable', 'string', 'max:255'],
            'expirationDate' => ['required'],
            'timingEmail' => ['required', 'integer'],
        ]);

        $validatedData['context_id'] = $validatedData['contextId'];
        $validatedData['llm_id'] = $validatedData['llmId'];
        $validatedData['evaluator_id'] = $validatedData['evaluatorId'];

        $phishingCampaign = PhishingCampaign::create($validatedData);

        return redirect()->route('phishing-campaign.generate-emails', ['phishingCampaign' => $phishingCampaign->id]);
    }

    public function generate($phishingCampaignId)
    {
        $phishingCampaign = PhishingCampaign::findOrFail($phishingCampaignId);

        $emotionalTriggersIds = explode(',', $phishingCampaign->emotionalTriggers);
        $persuasionsIds = explode(',', $phishingCampaign->persuasions);

        $persuasions = PhishingPersuasion::whereIn('id', $persuasionsIds)->get();
        $emotionalTriggers = PhishingEmotionalTrigger::whereIn('id', $emotionalTriggersIds)->get();

        $llm = LLM::findOrFail($phishingCampaign->llm_id);
        $numberEmails = $phishingCampaign->numberEmails;
        $prompt = $phishingCampaign->prompt . ' You must use fake organization nationality real names for the sender. The model should generate the email based on these criteria and format the message using the following JSON template: {"subject": "subject of the email","body": "body of the email"}. The email should include this placeholders (-name, -surname, -email, -dob, -clickHere) to fill in the data of the recipient.';

        $existingEmails = PhishingEmailPhishingCampaign::where('phishing_campaign_id', $phishingCampaign->id);
        $existingEmails->delete();

        // Generate new emails
        $generatedEmails = $this->generateEmails($numberEmails, $llm, $prompt);

        // Save the generated emails to the database
        foreach ($generatedEmails['subjects'] as $index => $subject) {
            PhishingEmailPhishingCampaign::create([
                'phishing_campaign_id' => $phishingCampaign->id,
                'subject' => $subject,
                'body' => $generatedEmails['bodies'][$index],
            ]);
        }

        return view('phishing-campaign.generated-email', [
            'phishingCampaign' => $phishingCampaign,
            'persuasions' => $persuasions,
            'emotionalTriggers' => $emotionalTriggers,
            'llm' => $llm,
            'subjects' => $generatedEmails['subjects'],
            'bodies' => $generatedEmails['bodies'],
            'state' => $phishingCampaign->state,
        ]);
    }

    public function savePhishingEmails(Request $request)
    {
        $validatedData = $request->validate([
            'phishingCampaignId' => ['required', 'integer'],
            'subjects' => ['required', 'array'],
            'subjects.*' => ['required', 'string', 'max:255'],
            'bodies' => ['required', 'array'],
            'bodies.*' => ['required'],
        ]);

        $phishingCampaignId = $validatedData['phishingCampaignId'];

        // Delete existing emails for the campaign
        PhishingEmailPhishingCampaign::where('phishing_campaign_id', $phishingCampaignId)->delete();

        foreach ($validatedData['subjects'] as $index => $subject) {
            PhishingEmailPhishingCampaign::create([
                'phishing_campaign_id' => $phishingCampaignId,
                'subject' => $subject,
                'body' => $validatedData['bodies'][$index],
            ]);
        }

        return redirect()->route('phishing-campaign.users', ['phishingCampaign' => $phishingCampaignId]);
    }

    public function users($phishingCampaignId)
    {
        $phishingCampaign = PhishingCampaign::findOrFail($phishingCampaignId);
        $phishingEmailPhishingCampaign = PhishingEmailPhishingCampaign::where('phishing_campaign_id', $phishingCampaignId)->firstOrFail();

        $users = User::where('role', 'User')->get();

        return view('phishing-campaign.users-phishing', compact('users', 'phishingCampaignId'));
    }

    public function saveUsersPhishingEmails(Request $request)
    {
        $validatedData = $request->validate([
            'phishingCampaignId' => ['required', 'integer'],
            'usersIds' => ['required'],
            'usersIds.*' => ['required'],
        ]);

        $phishingCampaignId = $validatedData['phishingCampaignId'];
        $usersIds = explode(',', $validatedData['usersIds']);

        $emails = PhishingEmailPhishingCampaign::where('phishing_campaign_id', $phishingCampaignId)->get();
        $emailIds = $emails->pluck('id')->toArray();

        if (empty($usersIds) || empty($emailIds)) {
            return response()->json(['error' => 'Users or Phishing Campaign Id cannot be null'], 400);
        }

        foreach ($usersIds as $userId) {
            foreach ($emailIds as $emailId) {
                UserPhishingEmail::create([
                    'user_id' => $userId,
                    'email_id' => $emailId,
                ]);
            }
        }

        $this->changeState($phishingCampaignId, 'Ready');
        return redirect()->route('phishing-campaign.index')->with('success', 'Emails assigned successfully.');
    }

    public function changeState($phishingCampaignId, $state)
    {
        $phishingCampaign = PhishingCampaign::findOrFail($phishingCampaignId);
        $phishingCampaign->state = $state;
        $phishingCampaign->save();

        if ($state != 'Draft' && $state != 'Ready') {

            if ($state == 'Ongoing') {
                $this->sendEmails($phishingCampaign);
                return redirect()->back()->with('success', 'Campaign start successfully!');
            }

            if ($state == 'Finished') {
                return redirect()->back()->with('success', 'Campaign stopped successfully!');
            }

            return redirect()->back();
        }
    }

    public function sendEmails(PhishingCampaign $phishingCampaign)
    {
        // Retrieve all emails associated with the phishing campaign
        $emails = PhishingEmailPhishingCampaign::where('phishing_campaign_id', $phishingCampaign->id)->get();

        // Retrieve all email IDs associated with the campaign
        $emailIds = $emails->pluck('id');

        // Retrieve all email not sent
        $emailsNotSent = UserPhishingEmail::whereIn('email_id', $emailIds)
            ->whereNull('sent')
            ->get();

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
                        $subject = $this->replacePlaceholders($emailId, $subjectTemplate, $user);
                        $body = $this->replacePlaceholders($emailId, $bodyTemplate, $user);

                        // Dispatch the job
                        SendPhishingEmail::dispatch($emailId, $user, $subject, $body);

                        // Update the 'sent' field to true
                        // Retrieve the UserPhishingEmail for this user
                        $userPhishingEmail = $userPhishingEmailMap->get($user->id);

                        if ($userPhishingEmail) {
                            $userPhishingEmail->sent = Carbon::now();
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
    }

    public function opened($email, $user)
    {
        $emailPhishing = PhishingEmailPhishingCampaign::findOrFail($email);
        $phishingCampaign = PhishingCampaign::findOrFail($emailPhishing->phishing_campaign_id);

        if ($phishingCampaign->state === 'Ongoing') {

            $phishingEmail = UserPhishingEmail::where('email_id', $email)
                ->where('user_id', $user)
                ->whereNotNull('sent')
                ->first();

            if ($phishingEmail && $phishingEmail->opened === null) {
                $phishingEmail->opened = Carbon::now();
                $phishingEmail->save();
            }
        }

        // Return a response without content (status 204)
        return response()->noContent();
    }

    public function clicked($email, $user)
    {
        $emailPhishing = PhishingEmailPhishingCampaign::findOrFail($email);
        $phishingCampaign = PhishingCampaign::findOrFail($emailPhishing->phishing_campaign_id);

        if ($phishingCampaign->state === 'Ongoing') {
            $phishingEmail = UserPhishingEmail::where('email_id', $email)
                ->where('user_id', $user)
                ->whereNotNull('sent')
                ->first();

            if ($phishingEmail && $phishingEmail->clicked === null) {
                $phishingEmail->clicked = Carbon::now();
                $phishingEmail->save();
            }
        }

        // Return a response without content (status 204)
        return response()->noContent();
    }

    public function analyse($phishingCampaignId)
    {
        $phishingCampaign = PhishingCampaign::findOrFail($phishingCampaignId);

        // Collect the email IDs associated with the campaign
        $emails = $phishingCampaign->phishingEmails;
        $emailsIds = $emails->pluck('id')->toArray();

        // Collect the users and their click status for the emails in this campaign
        $userPhishingEmails = UserPhishingEmail::whereIn('email_id', $emailsIds)->get();

        $emailSent = UserPhishingEmail::whereIn('email_id', $emailsIds)
            ->whereNotNull('sent')
            ->get();

        $emailOpened = UserPhishingEmail::whereIn('email_id', $emailsIds)
            ->whereNotNull('sent')
            ->whereNotNull('opened')
            ->get();

        $emailNotOpened = UserPhishingEmail::whereIn('email_id', $emailsIds)
            ->whereNotNull('sent')
            ->whereNull('opened')
            ->get();

        $emailClicked = UserPhishingEmail::whereIn('email_id', $emailsIds)
            ->whereNotNull('sent')
            ->whereNotNull('clicked')
            ->get();

        $emailNotClicked = UserPhishingEmail::whereIn('email_id', $emailsIds)
            ->whereNotNull('sent')
            ->whereNull('clicked')
            ->get();

        // Count male, female and other users who opened the email phishing
        $openedMaleCount = User::whereIn('id', $emailOpened->pluck('user_id'))
            ->where('gender', 'Male')
            ->count();

        $openedFemaleCount = User::whereIn('id', $emailOpened->pluck('user_id'))
            ->where('gender', 'Female')
            ->count();

        $openedOtherCount = User::whereIn('id', $emailOpened->pluck('user_id'))
            ->where('gender', 'Other')
            ->count();

        // Count male, female and other users who clicked the phishing link
        $clickedMaleCount = User::whereIn('id', $emailClicked->pluck('user_id'))
            ->where('gender', 'Male')
            ->count();

        $clickedFemaleCount = User::whereIn('id', $emailClicked->pluck('user_id'))
            ->where('gender', 'Female')
            ->count();

        $clickedOtherCount = User::whereIn('id', $emailClicked->pluck('user_id'))
            ->where('gender', 'Other')
            ->count();

        // Collect the user data and their click status
        $users = User::whereIn('id', $userPhishingEmails->pluck('user_id')->unique())->get()->map(function ($user) use ($userPhishingEmails, $emails) {
            $user->emails = $emails->map(function ($email) use ($user, $userPhishingEmails) {
                $userEmail = $userPhishingEmails->filter(function ($ue) use ($user, $email) {
                    return $ue->user_id == $user->id && $ue->email_id == $email->id;
                })->first();
                return [
                    'email' => $email,
                    'sent' => $userEmail ? $userEmail->sent : null,
                    'opened' => $userEmail ? $userEmail->opened : null,
                    'clicked' => $userEmail ? $userEmail->clicked : null,
                    'updated_at' => $userEmail->updated_at
                ];
            });
            return $user;
        });

        return view('phishing-campaign.phishing-campaign-analyse', compact('phishingCampaign', 'users', 'userPhishingEmails', 'emailSent', 'emailOpened', 'emailNotOpened', 'emailClicked', 'emailNotClicked', 'openedMaleCount', 'openedFemaleCount', 'openedOtherCount', 'clickedMaleCount', 'clickedFemaleCount', 'clickedOtherCount'));
    }

    public function stop($phishingCampaignId)
    {
        try {
            $phishingCampaign = PhishingCampaign::findOrFail($phishingCampaignId);
            $this->changeState($phishingCampaignId, 'Finished');
            return redirect()->back()->with('success', 'Campaign stopped successfully!');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function details($phishingCampaignId)
    {
        $phishingCampaign = PhishingCampaign::findOrFail($phishingCampaignId);

        $emotionalTriggersIds = explode(',', $phishingCampaign->emotionalTriggers);
        $persuasionsIds = explode(',', $phishingCampaign->persuasions);

        $persuasions = PhishingPersuasion::whereIn('id', $emotionalTriggersIds)->get();
        $emotionalTriggers = PhishingEmotionalTrigger::whereIn('id', $persuasionsIds)->get();

        $llm = LLM::findOrFail($phishingCampaign->llm_id);

        // Collect the email with the foreign key
        $emails = $phishingCampaign->phishingEmails;
        $emailsIds = $emails->pluck('id')->toArray();

        // Collect the users with the foreign key from UserPhishingEmail
        $usersIds = UserPhishingEmail::whereIn('email_id', $emailsIds)->distinct()->pluck('user_id')->toArray();

        $users = User::whereIn('id', $usersIds)->get();

        return view('phishing-campaign.phishing-campaign-detail', compact('phishingCampaign', 'persuasions', 'emotionalTriggers', 'llm', 'emails', 'users'));
    }

    public function downloadDataCSV($phishingCampaignId)
    {
        try {
            $phishingCampaign = PhishingCampaign::findOrFail($phishingCampaignId);

            $csvData = $this->generateDataCSV([$phishingCampaign]);

            return $this->createCSVResponse($csvData, 'phishing_campaign_' . $phishingCampaignId);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function downloadAllDataCSV()
    {
        try {
            $phishingCampaigns = PhishingCampaign::all();

            $csvData = $this->generateDataCSV($phishingCampaigns);

            return $this->createCSVResponse($csvData, 'phishing_campaigns');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function duplicate($phishingCampaignId)
    {
        try {
            $phishingCampaign = PhishingCampaign::findOrFail($phishingCampaignId);

            $newPhishingCampaign = $phishingCampaign->replicate();

            $newPhishingCampaign->state = 'Draft';
            $newPhishingCampaign->title .= ' (Copy)';

            $newPhishingCampaign->save();

            return redirect()->back()->with('success', 'Campaign duplicated successfully!');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function destroy(PhishingCampaign $phishingCampaign)
    {
        $phishingCampaign->delete();

        return redirect()->back()->with('success', 'Campaign deleted successfully!');
    }

    public function option()
    {
        $contexts =  PhishingContext::all();
        $emotionalTriggers = PhishingEmotionalTrigger::all();
        $persuasions =  PhishingPersuasion::all();
        return view('phishing-campaign.phishing-campaign-option', compact('contexts', 'emotionalTriggers', 'persuasions'));
    }

    private function generateEmails($numberEmails, $llm, $prompt)
    {
        $subjects = [];
        $bodies = [];
        $errorCount = 0;

        for ($i = 0; $i < $numberEmails && $errorCount < 5; $i++) {
            try {
                $tempContent = $this->generateHTTPPost($llm, $prompt);

                $decodedContent = json_decode($tempContent, true);
                if (json_last_error() === JSON_ERROR_NONE && isset($decodedContent['subject']) && isset($decodedContent['body'])) {
                    $subjects[] = $decodedContent['subject'];
                    $bodies[] = $decodedContent['body'];
                    $errorCount = 0;
                } else {
                    $i--;
                    $errorCount++;
                }
            } catch (\Exception $e) {
                $i--;
                $errorCount++;
            }
        }

        return ['subjects' => $subjects, 'bodies' => $bodies];
    }

    private function generateHTTPPost($llm, $prompt)
    {
        $endpoint = $llm->endpoint;
        $provider = $llm->provider;
        $model = $llm->model;

        $data = [
            'provider' => $provider,
            'model' => $model,
            'messages' => [
                [
                    'role' => 'user',
                    'content' => $prompt,
                ]
            ]
        ];

        $response = Http::post($endpoint, $data);

        if ($response->successful()) {
            $responseData = $response->json();

            $choices = $responseData['choices'];
            $content = $choices[0]['message']['content'];

            // Remove any '#' or '*' characters from the content
            // $content = preg_replace('/[#*]/', '', $content);

            return $content;
        } else {
            throw new Exception('Request failed');
        }
    }

    private function replacePlaceholders($emailId, $text, $user)
    {
        $baseUrl = config('app.url') . "/clicked/";
        $longLink = $baseUrl . $emailId . "/" . $user->id;

        $shortLink = $this->shortenUrl($longLink);

        $placeholders = [
            '-name' => $user->name,
            '-surname' => $user->surname,
            '-email' => $user->email,
            '-dob' => $user->dob,
            '-clickHere' => $shortLink !== null ? $shortLink : '',
        ];

        foreach ($placeholders as $placeholder => $value) {
            $text = str_replace($placeholder, $value, $text);
        }

        return $text;
    }

    private function shortenUrl($longUrl)
    {
        // Create a new instance of Guzzle client
        $client = new Client();

        // URL of the TinyURL API
        $url = 'http://tinyurl.com/api-create.php?url=' . urlencode($longUrl);

        try {
            // Make a GET request to the TinyURL API
            $response = $client->get($url);

            // Get the shortened URL from the response body
            $shortUrl = (string) $response->getBody();

            return $shortUrl;
        } catch (\Exception $e) {
            // Handle any errors
            return null;
        }
    }

    private function generateDataCSV($phishingCampaigns)
    {
        $csvData = [
            ['ID', 'Phishing Campaign ID', 'Title', 'Description', 'State', 'Number of Emails', 'Context', 'Emotional Triggers', 'Persuasions', 'Subject', 'Body', 'User name', 'User surname', 'User gender', 'User dob', 'User company role', 'Sent', 'Opened', 'Clicked']
        ];

        $incrementalId = 1;

        foreach ($phishingCampaigns as $phishingCampaign) {
            $emotionalTriggersIds = explode(',', $phishingCampaign->emotionalTriggers);
            $persuasionsIds = explode(',', $phishingCampaign->persuasions);

            $persuasions = PhishingPersuasion::whereIn('id', $persuasionsIds)->pluck('description')->toArray();
            $emotionalTriggers = PhishingEmotionalTrigger::whereIn('id', $emotionalTriggersIds)->pluck('description')->toArray();
            $context = PhishingContext::where('id', $phishingCampaign->context_id)->pluck('description')->first();
            
            $context = $context ?: null;
            $persuasionsDescriptions = "'" . implode("', '", $persuasions) . "'";
            $emotionalTriggersDescriptions = "'" . implode("', '", $emotionalTriggers) . "'";

            $generatedEmails = PhishingEmailPhishingCampaign::where('phishing_campaign_id', $phishingCampaign->id)
                ->get(['id as email_id', 'subject', 'body']);

            if ($generatedEmails->isEmpty()) {
                $csvData[] = [
                    $incrementalId++,
                    $phishingCampaign->id,
                    $phishingCampaign->title,
                    $phishingCampaign->description,
                    $phishingCampaign->state,
                    $phishingCampaign->numberEmails,
                    $context,
                    $emotionalTriggersDescriptions,
                    $persuasionsDescriptions,
                    '', // Empty Subject
                    '', // Empty Body
                    '', // Empty User name
                    '', // Empty User surname
                    '', // Empty User gender
                    '', // Empty User dob
                    '', // Empty User company role
                    '', // Empty Sent
                    '', // Empty Opened
                    '', // Empty Clicked
                ];
            } else {
                foreach ($generatedEmails as $email) {
                    $userPhishingEmails = UserPhishingEmail::where('email_id', $email->email_id)->get();

                    if ($userPhishingEmails->isEmpty()) {
                        $csvData[] = [
                            $incrementalId++,
                            $phishingCampaign->id,
                            $phishingCampaign->title,
                            $phishingCampaign->description,
                            $phishingCampaign->state,
                            $phishingCampaign->numberEmails,
                            $context,
                            $emotionalTriggersDescriptions,
                            $persuasionsDescriptions,
                            $email->subject,
                            $email->body,
                            '', // Empty User name
                            '', // Empty User surname
                            '', // Empty User gender
                            '', // Empty User dob
                            '', // Empty User company role
                            '', // Empty Sent
                            '', // Empty Opened
                            '', // Empty Clicked
                        ];
                    } else {
                        foreach ($userPhishingEmails as $userPhishingEmail) {

                            $user = User::find($userPhishingEmail->user_id);

                            $emailSubject = $email->subject ?: null;
                            $emailBody = $email->body ?: null;
                            
                            $userName = $user->name ?? null;
                            $userSurname = $user->surname ?? null;
                            $userGender = $user->gender ?? null;
                            $userDob = $user->dob ?? null;
                            $userCompanyRole = $user->company_role ?? null;
                            
                            $sent = $userPhishingEmail->sent ?: null;
                            $opened = $userPhishingEmail->opened ?: null;
                            $clicked = $userPhishingEmail->clicked ?: null;

                            $csvData[] = [
                                $incrementalId++,
                                $phishingCampaign->id,
                                $phishingCampaign->title,
                                $phishingCampaign->description,
                                $phishingCampaign->state,
                                $phishingCampaign->numberEmails,
                                $context,
                                $emotionalTriggersDescriptions,
                                $persuasionsDescriptions,
                                $emailSubject,
                                $emailBody,
                                $userName,
                                $userSurname,
                                $userGender,
                                $userDob,
                                $userCompanyRole,
                                $sent,
                                $opened,
                                $clicked,
                            ];
                        }
                    }
                }
            }
        }

        return $csvData;
    }

    private function createCSVResponse($csvData, $fileNamePrefix)
    {
        $fileName = $fileNamePrefix . '_' . date('Y-m-d_H-i-s') . '.csv';
        $csvContent = '';

        foreach ($csvData as $row) {
            $csvContent .= implode(',', array_map(function ($value) {
                return is_null($value) ? '' : '"' . str_replace('"', '""', $value) . '"';
            }, $row)) . "\n";
        }

        return Response::make($csvContent, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$fileName\"",
        ]);
    }
}
