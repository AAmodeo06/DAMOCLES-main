<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row item-center gap-3">
            <!-- Back to questionnaires campaign -->
            <a href="{{ url()->previous() }}" class="cursor-pointer">
                <x-primary-button>
                    @lang('questionnaire-campaign.damocles.back')
                </x-primary-button>
            </a>
            <!-- Breadcrumb -->
            <ul class="flex flex-row gap-1 flex-wrap break-words text-sky-800">
                <li><a href="{{ route('questionnaires-campaign.index') }}">@lang('questionnaire-campaign.damocles.questionnairesCampaigns')</a></li>
                <li>/</li>
                <li><a>@lang('questionnaire-campaign.damocles.damocles')</a></li>
            </ul>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-sky-900">

                    <!-- Results -->
                    <p class="text-2xl font-semibold text-center">@lang('questionnaire-campaign.damocles.result')</p>

                    <div>
                        <!-- Tab 1 -->
                        <div class="tab hidden">

                            <!-- Q1 -->
                            <div class="py-3 flex flex-col border-b-2">
                                <p class="text-center font-medium py-3">I provide my personal credentials to a third
                                    party via
                                    email without first verifying the authenticity of the sender.</p>
                                <div
                                    class="flex flex-col md:flex-row items-top md:items-center w-full md:justify-around">
                                    <div class="flex flex-row md:flex-col items-center">
                                        <input disabled class="checked:bg-sky-800" type="radio" id="q1_1"
                                            name="q1" value="1"
                                            {{ isset($answers['q1']) && $answers['q1'] == 1 ? 'checked' : '' }}>
                                        <label for="q1_1" class="italic">@lang('questionnaire-campaign.damocles.stronglyDisagree')</label>
                                    </div>
                                    <div class="flex flex-row md:flex-col items-center">
                                        <input disabled class="checked:bg-sky-800" type="radio" id="q1_2"
                                            name="q1" value="2"
                                            {{ isset($answers['q2']) && $answers['q2'] == 2 ? 'checked' : '' }}>
                                        <label for="q1_2" class="italic">@lang('questionnaire-campaign.damocles.disagree')</label>
                                    </div>
                                    <div class="flex flex-row md:flex-col items-center">
                                        <input disabled class="checked:bg-sky-800" type="radio" id="q1_3"
                                            name="q1" value="3"
                                            {{ isset($answers['q3']) && $answers['q3'] == 3 ? 'checked' : '' }}>
                                        <label for="q1_3" class="italic">@lang('questionnaire-campaign.damocles.neutral')</label>
                                    </div>
                                    <div class="flex flex-row md:flex-col items-center">
                                        <input disabled class="checked:bg-sky-800" type="radio" id="q1_4"
                                            name="q1" value="4"
                                            {{ isset($answers['q4']) && $answers['q4'] == 4 ? 'checked' : '' }}>
                                        <label for="q1_4" class="italic">@lang('questionnaire-campaign.damocles.agree')</label>
                                    </div>
                                    <div class="flex flex-row md:flex-col items-center">
                                        <input disabled class="checked:bg-sky-800" type="radio" id="q1_5"
                                            name="q1" value="5"
                                            {{ isset($answers['q5']) && $answers['q5'] == 5 ? 'checked' : '' }}>
                                        <label for="q1_5" class="italic">@lang('questionnaire-campaign.damocles.stronglyAgree')</label>
                                    </div>
                                </div>
                            </div>

                            <!-- Q2 -->
                            <div class="py-3 flex flex-col border-b-2">
                                <p class="text-center font-medium py-3">I find myself tempted by curiosity to click on
                                    links in
                                    emails.</p>
                                <div
                                    class="flex flex-col md:flex-row items-top md:items-center w-full md:justify-around">
                                    <div class="flex flex-row md:flex-col items-center">
                                        <input disabled class="checked:bg-sky-800" type="radio" id="q2_1"
                                            name="q2" value="1"
                                            {{ isset($answers['q2']) && $answers['q2'] == 1 ? 'checked' : '' }}>
                                        <label for="q2_1" class="italic">@lang('questionnaire-campaign.damocles.stronglyDisagree')</label>
                                    </div>
                                    <div class="flex flex-row md:flex-col items-center">
                                        <input disabled class="checked:bg-sky-800" type="radio" id="q2_2"
                                            name="q2" value="2"
                                            {{ isset($answers['q2']) && $answers['q2'] == 2 ? 'checked' : '' }}>
                                        <label for="q2_2" class="italic">@lang('questionnaire-campaign.damocles.disagree')</label>
                                    </div>
                                    <div class="flex flex-row md:flex-col items-center">
                                        <input disabled class="checked:bg-sky-800" type="radio" id="q2_3"
                                            name="q2" value="3"
                                            {{ isset($answers['q2']) && $answers['q2'] == 3 ? 'checked' : '' }}>
                                        <label for="q2_3" class="italic">@lang('questionnaire-campaign.damocles.neutral')</label>
                                    </div>
                                    <div class="flex flex-row md:flex-col items-center">
                                        <input disabled class="checked:bg-sky-800" type="radio" id="q2_4"
                                            name="q2" value="4"
                                            {{ isset($answers['q2']) && $answers['q2'] == 4 ? 'checked' : '' }}>
                                        <label for="q2_4" class="italic">@lang('questionnaire-campaign.damocles.agree')</label>
                                    </div>
                                    <div class="flex flex-row md:flex-col items-center">
                                        <input disabled class="checked:bg-sky-800" type="radio" id="q2_5"
                                            name="q2" value="5"
                                            {{ isset($answers['q2']) && $answers['q2'] == 5 ? 'checked' : '' }}>
                                        <label for="q2_5" class="italic">@lang('questionnaire-campaign.damocles.stronglyAgree')</label>
                                    </div>
                                </div>
                            </div>

                            <!-- Q3 -->
                            <div class="py-3 flex flex-col border-b-2">
                                <p class="text-center font-medium py-3">I think that I can be targeted as a victim of a
                                    phishing attack.</p>
                                <div
                                    class="flex flex-col md:flex-row items-top md:items-center w-full md:justify-around">
                                    <div class="flex flex-row md:flex-col items-center">
                                        <input disabled class="checked:bg-sky-800" type="radio" id="q3_1"
                                            name="q3" value="1"
                                            {{ isset($answers['q3']) && $answers['q3'] == 1 ? 'checked' : '' }}>
                                        <label for="q3_1" class="italic">@lang('questionnaire-campaign.damocles.stronglyDisagree')</label>
                                    </div>
                                    <div class="flex flex-row md:flex-col items-center">
                                        <input disabled class="checked:bg-sky-800" type="radio" id="q3_2"
                                            name="q3" value="2"
                                            {{ isset($answers['q3']) && $answers['q3'] == 2 ? 'checked' : '' }}>
                                        <label for="q3_2" class="italic">@lang('questionnaire-campaign.damocles.disagree')</label>
                                    </div>
                                    <div class="flex flex-row md:flex-col items-center">
                                        <input disabled class="checked:bg-sky-800" type="radio" id="q3_3"
                                            name="q3" value="3"
                                            {{ isset($answers['q3']) && $answers['q3'] == 3 ? 'checked' : '' }}>
                                        <label for="q3_3" class="italic">@lang('questionnaire-campaign.damocles.neutral')</label>
                                    </div>
                                    <div class="flex flex-row md:flex-col items-center">
                                        <input disabled class="checked:bg-sky-800" type="radio" id="q3_4"
                                            name="q3" value="4"
                                            {{ isset($answers['q3']) && $answers['q3'] == 4 ? 'checked' : '' }}>
                                        <label for="q3_4" class="italic">@lang('questionnaire-campaign.damocles.agree')</label>
                                    </div>
                                    <div class="flex flex-row md:flex-col items-center">
                                        <input disabled class="checked:bg-sky-800" type="radio" id="q3_5"
                                            name="q3" value="5"
                                            {{ isset($answers['q3']) && $answers['q3'] == 5 ? 'checked' : '' }}>
                                        <label for="q3_5" class="italic">@lang('questionnaire-campaign.damocles.stronglyAgree')</label>
                                    </div>
                                </div>
                            </div>

                            <!-- Q4 -->
                            <div class="py-3 flex flex-col border-b-2">
                                <p class="text-center font-medium py-3">I use different ways of communication (e.g.
                                    phone call)
                                    to check the legitimacy of the request made in an email/message from a known
                                    sender.</p>
                                <div
                                    class="flex flex-col md:flex-row items-top md:items-center w-full md:justify-around">
                                    <div class="flex flex-row md:flex-col items-center">
                                        <input disabled class="checked:bg-sky-800" type="radio" id="q4_1"
                                            name="q4" value="1"
                                            {{ isset($answers['q4']) && $answers['q4'] == 1 ? 'checked' : '' }}>
                                        <label for="q4_1" class="italic">@lang('questionnaire-campaign.damocles.stronglyDisagree')</label>
                                    </div>
                                    <div class="flex flex-row md:flex-col items-center">
                                        <input disabled class="checked:bg-sky-800" type="radio" id="q4_2"
                                            name="q4" value="2"
                                            {{ isset($answers['q4']) && $answers['q4'] == 2 ? 'checked' : '' }}>
                                        <label for="q4_2" class="italic">@lang('questionnaire-campaign.damocles.disagree')</label>
                                    </div>
                                    <div class="flex flex-row md:flex-col items-center">
                                        <input disabled class="checked:bg-sky-800" type="radio" id="q4_3"
                                            name="q4" value="3"
                                            {{ isset($answers['q4']) && $answers['q4'] == 3 ? 'checked' : '' }}>
                                        <label for="q4_3" class="italic">@lang('questionnaire-campaign.damocles.neutral')</label>
                                    </div>
                                    <div class="flex flex-row md:flex-col items-center">
                                        <input disabled class="checked:bg-sky-800" type="radio" id="q4_4"
                                            name="q4" value="4"
                                            {{ isset($answers['q4']) && $answers['q4'] == 4 ? 'checked' : '' }}>
                                        <label for="q4_4" class="italic">@lang('questionnaire-campaign.damocles.agree')</label>
                                    </div>
                                    <div class="flex flex-row md:flex-col items-center">
                                        <input disabled class="checked:bg-sky-800" type="radio" id="q4_5"
                                            name="q4" value="5"
                                            {{ isset($answers['q4']) && $answers['q4'] == 5 ? 'checked' : '' }}>
                                        <label for="q4_5" class="italic">@lang('questionnaire-campaign.damocles.stronglyAgree')</label>
                                    </div>
                                </div>
                            </div>

                            <!-- Q5 -->
                            <div class="py-3 flex flex-col border-b-2">
                                <p class="text-center font-medium py-3">I am likely to collaborate with other people to
                                    assess
                                    the authenticity of the emails I receive.</p>
                                <div
                                    class="flex flex-col md:flex-row items-top md:items-center w-full md:justify-around">
                                    <div class="flex flex-row md:flex-col items-center">
                                        <input disabled class="checked:bg-sky-800" type="radio" id="q5_1"
                                            name="q5" value="1"
                                            {{ isset($answers['q5']) && $answers['q5'] == 1 ? 'checked' : '' }}>
                                        <label for="q5_1" class="italic">@lang('questionnaire-campaign.damocles.stronglyDisagree')</label>
                                    </div>
                                    <div class="flex flex-row md:flex-col items-center">
                                        <input disabled class="checked:bg-sky-800" type="radio" id="q5_2"
                                            name="q5" value="2"
                                            {{ isset($answers['q5']) && $answers['q5'] == 2 ? 'checked' : '' }}>
                                        <label for="q5_2" class="italic">@lang('questionnaire-campaign.damocles.disagree')</label>
                                    </div>
                                    <div class="flex flex-row md:flex-col items-center">
                                        <input disabled class="checked:bg-sky-800" type="radio" id="q5_3"
                                            name="q5" value="3"
                                            {{ isset($answers['q5']) && $answers['q5'] == 3 ? 'checked' : '' }}>
                                        <label for="q5_3" class="italic">@lang('questionnaire-campaign.damocles.neutral')</label>
                                    </div>
                                    <div class="flex flex-row md:flex-col items-center">
                                        <input disabled class="checked:bg-sky-800" type="radio" id="q5_4"
                                            name="q5" value="4"
                                            {{ isset($answers['q5']) && $answers['q5'] == 4 ? 'checked' : '' }}>
                                        <label for="q5_4" class="italic">@lang('questionnaire-campaign.damocles.agree')</label>
                                    </div>
                                    <div class="flex flex-row md:flex-col items-center">
                                        <input disabled class="checked:bg-sky-800" type="radio" id="q5_5"
                                            name="q5" value="5"
                                            {{ isset($answers['q5']) && $answers['q5'] == 5 ? 'checked' : '' }}>
                                        <label for="q5_5" class="italic">@lang('questionnaire-campaign.damocles.stronglyAgree')</label>
                                    </div>
                                </div>
                            </div>

                            <!-- Q6 -->
                            <div class="py-3 flex flex-col border-b-2">
                                <p class="text-center font-medium py-3">I use apps or websites to discover who is the
                                    sender, if
                                    I receive a message from an unknown telephone number.</p>
                                <div
                                    class="flex flex-col md:flex-row items-top md:items-center w-full md:justify-around">
                                    <div class="flex flex-row md:flex-col items-center">
                                        <input disabled class="checked:bg-sky-800" type="radio" id="q6_1"
                                            name="q6" value="1"
                                            {{ isset($answers['q6']) && $answers['q6'] == 1 ? 'checked' : '' }}>
                                        <label for="q6_1" class="italic">@lang('questionnaire-campaign.damocles.stronglyDisagree')</label>
                                    </div>
                                    <div class="flex flex-row md:flex-col items-center">
                                        <input disabled class="checked:bg-sky-800" type="radio" id="q6_2"
                                            name="q6" value="2"
                                            {{ isset($answers['q6']) && $answers['q6'] == 2 ? 'checked' : '' }}>
                                        <label for="q6_2" class="italic">@lang('questionnaire-campaign.damocles.disagree')</label>
                                    </div>
                                    <div class="flex flex-row md:flex-col items-center">
                                        <input disabled class="checked:bg-sky-800" type="radio" id="q6_3"
                                            name="q6" value="3"
                                            {{ isset($answers['q6']) && $answers['q6'] == 3 ? 'checked' : '' }}>
                                        <label for="q6_3" class="italic">@lang('questionnaire-campaign.damocles.neutral')</label>
                                    </div>
                                    <div class="flex flex-row md:flex-col items-center">
                                        <input disabled class="checked:bg-sky-800" type="radio" id="q6_4"
                                            name="q6" value="4"
                                            {{ isset($answers['q6']) && $answers['q6'] == 4 ? 'checked' : '' }}>
                                        <label for="q6_4" class="italic">@lang('questionnaire-campaign.damocles.agree')</label>
                                    </div>
                                    <div class="flex flex-row md:flex-col items-center">
                                        <input disabled class="checked:bg-sky-800" type="radio" id="q6_5"
                                            name="q6" value="5"
                                            {{ isset($answers['q6']) && $answers['q6'] == 5 ? 'checked' : '' }}>
                                        <label for="q6_5" class="italic">@lang('questionnaire-campaign.damocles.stronglyAgree')</label>
                                    </div>
                                </div>
                            </div>

                            <!-- Q7 -->
                            <div class="py-3 flex flex-col border-b-2">
                                <p class="text-center font-medium py-3">I depend on my own knowledge to assess the
                                    credibility
                                    of the content in the emails I receive.</p>
                                <div
                                    class="flex flex-col md:flex-row items-top md:items-center w-full md:justify-around">
                                    <div class="flex flex-row md:flex-col items-center">
                                        <input disabled class="checked:bg-sky-800" type="radio" id="q7_1"
                                            name="q7" value="1"
                                            {{ isset($answers['q7']) && $answers['q7'] == 1 ? 'checked' : '' }}>
                                        <label for="q7_1" class="italic">@lang('questionnaire-campaign.damocles.stronglyDisagree')</label>
                                    </div>
                                    <div class="flex flex-row md:flex-col items-center">
                                        <input disabled class="checked:bg-sky-800" type="radio" id="q7_2"
                                            name="q7" value="2"
                                            {{ isset($answers['q7']) && $answers['q7'] == 2 ? 'checked' : '' }}>
                                        <label for="q7_2" class="italic">@lang('questionnaire-campaign.damocles.disagree')</label>
                                    </div>
                                    <div class="flex flex-row md:flex-col items-center">
                                        <input disabled class="checked:bg-sky-800" type="radio" id="q7_3"
                                            name="q7" value="3"
                                            {{ isset($answers['q7']) && $answers['q7'] == 3 ? 'checked' : '' }}>
                                        <label for="q7_3" class="italic">@lang('questionnaire-campaign.damocles.neutral')</label>
                                    </div>
                                    <div class="flex flex-row md:flex-col items-center">
                                        <input disabled class="checked:bg-sky-800" type="radio" id="q7_4"
                                            name="q7" value="4"
                                            {{ isset($answers['q7']) && $answers['q7'] == 4 ? 'checked' : '' }}>
                                        <label for="q7_4" class="italic">@lang('questionnaire-campaign.damocles.agree')</label>
                                    </div>
                                    <div class="flex flex-row md:flex-col items-center">
                                        <input disabled class="checked:bg-sky-800" type="radio" id="q7_5"
                                            name="q7" value="5"
                                            {{ isset($answers['q7']) && $answers['q7'] == 5 ? 'checked' : '' }}>
                                        <label for="q7_5" class="italic">@lang('questionnaire-campaign.damocles.stronglyAgree')</label>
                                    </div>
                                </div>
                            </div>

                            <!-- Q8 -->
                            <div class="py-3 flex flex-col border-b-2">
                                <p class="text-center font-medium py-3">I manage my reactions when dealing with
                                    stressful
                                    emails.</p>
                                <div
                                    class="flex flex-col md:flex-row items-top md:items-center w-full md:justify-around">
                                    <div class="flex flex-row md:flex-col items-center">
                                        <input disabled class="checked:bg-sky-800" type="radio" id="q8_1"
                                            name="q8" value="1"
                                            {{ isset($answers['q8']) && $answers['q8'] == 1 ? 'checked' : '' }}>
                                        <label for="q8_1" class="italic">@lang('questionnaire-campaign.damocles.stronglyDisagree')</label>
                                    </div>
                                    <div class="flex flex-row md:flex-col items-center">
                                        <input disabled class="checked:bg-sky-800" type="radio" id="q8_2"
                                            name="q8" value="2"
                                            {{ isset($answers['q8']) && $answers['q8'] == 2 ? 'checked' : '' }}>
                                        <label for="q8_2" class="italic">@lang('questionnaire-campaign.damocles.disagree')</label>
                                    </div>
                                    <div class="flex flex-row md:flex-col items-center">
                                        <input disabled class="checked:bg-sky-800" type="radio" id="q8_3"
                                            name="q8" value="3"
                                            {{ isset($answers['q8']) && $answers['q8'] == 3 ? 'checked' : '' }}>
                                        <label for="q8_3" class="italic">@lang('questionnaire-campaign.damocles.neutral')</label>
                                    </div>
                                    <div class="flex flex-row md:flex-col items-center">
                                        <input disabled class="checked:bg-sky-800" type="radio" id="q8_4"
                                            name="q8" value="4"
                                            {{ isset($answers['q8']) && $answers['q8'] == 4 ? 'checked' : '' }}>
                                        <label for="q8_4" class="italic">@lang('questionnaire-campaign.damocles.agree')</label>
                                    </div>
                                    <div class="flex flex-row md:flex-col items-center">
                                        <input disabled class="checked:bg-sky-800" type="radio" id="q8_5"
                                            name="q8" value="5"
                                            {{ isset($answers['q8']) && $answers['q8'] == 5 ? 'checked' : '' }}>
                                        <label for="q8_5" class="italic">@lang('questionnaire-campaign.damocles.stronglyAgree')</label>
                                    </div>
                                </div>
                            </div>

                            <!-- Q9 -->
                            <div class="py-3 flex flex-col border-b-2">
                                <p class="text-center font-medium py-3">I wait a few (e.g., 2, 3 minutes) minutes
                                    before
                                    interacting with emails that make me feel strong emotions or a sense of urgency.
                                </p>
                                <div
                                    class="flex flex-col md:flex-row items-top md:items-center w-full md:justify-around">
                                    <div class="flex flex-row md:flex-col items-center">
                                        <input disabled class="checked:bg-sky-800" type="radio" id="q9_1"
                                            name="q9" value="1"
                                            {{ isset($answers['q9']) && $answers['q9'] == 1 ? 'checked' : '' }}>
                                        <label for="q9_1" class="italic">@lang('questionnaire-campaign.damocles.stronglyDisagree')</label>
                                    </div>
                                    <div class="flex flex-row md:flex-col items-center">
                                        <input disabled class="checked:bg-sky-800" type="radio" id="q9_2"
                                            name="q9" value="2"
                                            {{ isset($answers['q9']) && $answers['q9'] == 2 ? 'checked' : '' }}>
                                        <label for="q9_2" class="italic">@lang('questionnaire-campaign.damocles.disagree')</label>
                                    </div>
                                    <div class="flex flex-row md:flex-col items-center">
                                        <input disabled class="checked:bg-sky-800" type="radio" id="q9_3"
                                            name="q9" value="3"
                                            {{ isset($answers['q9']) && $answers['q9'] == 3 ? 'checked' : '' }}>
                                        <label for="q9_3" class="italic">@lang('questionnaire-campaign.damocles.neutral')</label>
                                    </div>
                                    <div class="flex flex-row md:flex-col items-center">
                                        <input disabled class="checked:bg-sky-800" type="radio" id="q9_4"
                                            name="q9" value="4"
                                            {{ isset($answers['q9']) && $answers['q9'] == 4 ? 'checked' : '' }}>
                                        <label for="q9_4" class="italic">@lang('questionnaire-campaign.damocles.agree')</label>
                                    </div>
                                    <div class="flex flex-row md:flex-col items-center">
                                        <input disabled class="checked:bg-sky-800" type="radio" id="q9_5"
                                            name="q9" value="5"
                                            {{ isset($answers['q9']) && $answers['q9'] == 5 ? 'checked' : '' }}>
                                        <label for="q9_5" class="italic">@lang('questionnaire-campaign.damocles.stronglyAgree')</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tab 2-->
                        <div class="tab hidden">

                            <!-- Q10 -->
                            <div class="py-3 flex flex-col border-b-2">
                                <p class="text-center font-medium py-3">I take breaks during the day when I use
                                    computer systems.
                                </p>
                                <div
                                    class="flex flex-col md:flex-row items-top md:items-center w-full md:justify-around">
                                    <div class="flex flex-row md:flex-col items-center">
                                        <input disabled class="checked:bg-sky-800" type="radio" id="q10_1"
                                            name="q10" value="1"
                                            {{ isset($answers['q10']) && $answers['q10'] == 1 ? 'checked' : '' }}>
                                        <label for="q10_1" class="italic">@lang('questionnaire-campaign.damocles.stronglyDisagree')</label>
                                    </div>
                                    <div class="flex flex-row md:flex-col items-center">
                                        <input disabled class="checked:bg-sky-800" type="radio" id="q10_2"
                                            name="q10" value="2"
                                            {{ isset($answers['q10']) && $answers['q10'] == 2 ? 'checked' : '' }}>
                                        <label for="q10_2" class="italic">@lang('questionnaire-campaign.damocles.disagree')</label>
                                    </div>
                                    <div class="flex flex-row md:flex-col items-center">
                                        <input disabled class="checked:bg-sky-800" type="radio" id="q10_3"
                                            name="q10" value="3"
                                            {{ isset($answers['q10']) && $answers['q10'] == 3 ? 'checked' : '' }}>
                                        <label for="q10_3" class="italic">@lang('questionnaire-campaign.damocles.neutral')</label>
                                    </div>
                                    <div class="flex flex-row md:flex-col items-center">
                                        <input disabled class="checked:bg-sky-800" type="radio" id="q10_4"
                                            name="q10" value="4"
                                            {{ isset($answers['q10']) && $answers['q10'] == 4 ? 'checked' : '' }}>
                                        <label for="q10_4" class="italic">@lang('questionnaire-campaign.damocles.agree')</label>
                                    </div>
                                    <div class="flex flex-row md:flex-col items-center">
                                        <input disabled class="checked:bg-sky-800" type="radio" id="q10_5"
                                            name="q10" value="5"
                                            {{ isset($answers['q10']) && $answers['q10'] == 5 ? 'checked' : '' }}>
                                        <label for="q10_5" class="italic">@lang('questionnaire-campaign.damocles.stronglyAgree')</label>
                                    </div>
                                </div>
                            </div>

                            <!-- Q11 -->
                            <div class="py-3 flex flex-col border-b-2">
                                <p class="text-center font-medium py-3">I am interested in attending courses about
                                    ransomware
                                    threats.</p>
                                <div
                                    class="flex flex-col md:flex-row items-top md:items-center w-full md:justify-around">
                                    <div class="flex flex-row md:flex-col items-center">
                                        <input disabled class="checked:bg-sky-800" type="radio" id="q11_1"
                                            name="q11" value="1"
                                            {{ isset($answers['q11']) && $answers['q11'] == 1 ? 'checked' : '' }}>
                                        <label for="q11_1" class="italic">@lang('questionnaire-campaign.damocles.stronglyDisagree')</label>
                                    </div>
                                    <div class="flex flex-row md:flex-col items-center">
                                        <input disabled class="checked:bg-sky-800" type="radio" id="q11_2"
                                            name="q11" value="2"
                                            {{ isset($answers['q11']) && $answers['q11'] == 2 ? 'checked' : '' }}>
                                        <label for="q11_2" class="italic">@lang('questionnaire-campaign.damocles.disagree')</label>
                                    </div>
                                    <div class="flex flex-row md:flex-col items-center">
                                        <input disabled class="checked:bg-sky-800" type="radio" id="q11_3"
                                            name="q11" value="3"
                                            {{ isset($answers['q11']) && $answers['q11'] == 3 ? 'checked' : '' }}>
                                        <label for="q11_3" class="italic">@lang('questionnaire-campaign.damocles.neutral')</label>
                                    </div>
                                    <div class="flex flex-row md:flex-col items-center">
                                        <input disabled class="checked:bg-sky-800" type="radio" id="q11_4"
                                            name="q11" value="4"
                                            {{ isset($answers['q11']) && $answers['q11'] == 4 ? 'checked' : '' }}>
                                        <label for="q11_4" class="italic">@lang('questionnaire-campaign.damocles.agree')</label>
                                    </div>
                                    <div class="flex flex-row md:flex-col items-center">
                                        <input disabled class="checked:bg-sky-800" type="radio" id="q11_5"
                                            name="q11" value="5"
                                            {{ isset($answers['q11']) && $answers['q11'] == 5 ? 'checked' : '' }}>
                                        <label for="q11_5" class="italic">@lang('questionnaire-campaign.damocles.stronglyAgree')</label>
                                    </div>
                                </div>
                            </div>

                            <!-- Q12 -->
                            <div class="py-3 flex flex-col border-b-2">
                                <p class="text-center font-medium py-3">I verify the authenticity of websites by
                                    examining webpages
                                    for grammatical errors and identifying any suspicious links while browsing.</p>
                                <div
                                    class="flex flex-col md:flex-row items-top md:items-center w-full md:justify-around">
                                    <div class="flex flex-row md:flex-col items-center">
                                        <input disabled class="checked:bg-sky-800" type="radio" id="q12_1"
                                            name="q12" value="1"
                                            {{ isset($answers['q12']) && $answers['q12'] == 1 ? 'checked' : '' }}>
                                        <label for="q12_1" class="italic">@lang('questionnaire-campaign.damocles.stronglyDisagree')</label>
                                    </div>
                                    <div class="flex flex-row md:flex-col items-center">
                                        <input disabled class="checked:bg-sky-800" type="radio" id="q12_2"
                                            name="q12" value="2"
                                            {{ isset($answers['q12']) && $answers['q12'] == 2 ? 'checked' : '' }}>
                                        <label for="q12_2" class="italic">@lang('questionnaire-campaign.damocles.disagree')</label>
                                    </div>
                                    <div class="flex flex-row md:flex-col items-center">
                                        <input disabled class="checked:bg-sky-800" type="radio" id="q12_3"
                                            name="q12" value="3"
                                            {{ isset($answers['q12']) && $answers['q12'] == 3 ? 'checked' : '' }}>
                                        <label for="q12_3" class="italic">@lang('questionnaire-campaign.damocles.neutral')</label>
                                    </div>
                                    <div class="flex flex-row md:flex-col items-center">
                                        <input disabled class="checked:bg-sky-800" type="radio" id="q12_4"
                                            name="q12" value="4"
                                            {{ isset($answers['q12']) && $answers['q12'] == 4 ? 'checked' : '' }}>
                                        <label for="q12_4" class="italic">@lang('questionnaire-campaign.damocles.agree')</label>
                                    </div>
                                    <div class="flex flex-row md:flex-col items-center">
                                        <input disabled class="checked:bg-sky-800" type="radio" id="q12_5"
                                            name="q12" value="5"
                                            {{ isset($answers['q12']) && $answers['q12'] == 5 ? 'checked' : '' }}>
                                        <label for="q12_5" class="italic">@lang('questionnaire-campaign.damocles.stronglyAgree')</label>
                                    </div>
                                </div>
                            </div>

                            <!-- Q13 -->
                            <div class="py-3 flex flex-col border-b-2">
                                <p class="text-center font-medium py-3">I make sure that all programs installed on my
                                    computer are
                                    up to date.</p>
                                <div
                                    class="flex flex-col md:flex-row items-top md:items-center w-full md:justify-around">
                                    <div class="flex flex-row md:flex-col items-center">
                                        <input disabled class="checked:bg-sky-800" type="radio" id="q13_1"
                                            name="q13" value="1"
                                            {{ isset($answers['q13']) && $answers['q13'] == 1 ? 'checked' : '' }}>
                                        <label for="q13_1" class="italic">@lang('questionnaire-campaign.damocles.stronglyDisagree')</label>
                                    </div>
                                    <div class="flex flex-row md:flex-col items-center">
                                        <input disabled class="checked:bg-sky-800" type="radio" id="q13_2"
                                            name="q13" value="2"
                                            {{ isset($answers['q13']) && $answers['q13'] == 2 ? 'checked' : '' }}>
                                        <label for="q13_2" class="italic">@lang('questionnaire-campaign.damocles.disagree')</label>
                                    </div>
                                    <div class="flex flex-row md:flex-col items-center">
                                        <input disabled class="checked:bg-sky-800" type="radio" id="q13_3"
                                            name="q13" value="3"
                                            {{ isset($answers['q13']) && $answers['q13'] == 3 ? 'checked' : '' }}>
                                        <label for="q13_3" class="italic">@lang('questionnaire-campaign.damocles.neutral')</label>
                                    </div>
                                    <div class="flex flex-row md:flex-col items-center">
                                        <input disabled class="checked:bg-sky-800" type="radio" id="q13_4"
                                            name="q13" value="4"
                                            {{ isset($answers['q13']) && $answers['q13'] == 4 ? 'checked' : '' }}>
                                        <label for="q13_4" class="italic">@lang('questionnaire-campaign.damocles.agree')</label>
                                    </div>
                                    <div class="flex flex-row md:flex-col items-center">
                                        <input disabled class="checked:bg-sky-800" type="radio" id="q13_5"
                                            name="q13" value="5"
                                            {{ isset($answers['q13']) && $answers['q13'] == 5 ? 'checked' : '' }}>
                                        <label for="q13_5" class="italic">@lang('questionnaire-campaign.damocles.stronglyAgree')</label>
                                    </div>
                                </div>
                            </div>

                            <!-- Q14 -->
                            <div class="py-3 flex flex-col border-b-2">
                                <p class="text-center font-medium py-3">I back up all the data I store on my PC.</p>
                                <div
                                    class="flex flex-col md:flex-row items-top md:items-center w-full md:justify-around">
                                    <div class="flex flex-row md:flex-col items-center">
                                        <input disabled class="checked:bg-sky-800" type="radio" id="q14_1"
                                            name="q14" value="1"
                                            {{ isset($answers['q14']) && $answers['q14'] == 1 ? 'checked' : '' }}>
                                        <label for="q14_1" class="italic">@lang('questionnaire-campaign.damocles.stronglyDisagree')</label>
                                    </div>
                                    <div class="flex flex-row md:flex-col items-center">
                                        <input disabled class="checked:bg-sky-800" type="radio" id="q14_2"
                                            name="q14" value="2"
                                            {{ isset($answers['q14']) && $answers['q14'] == 2 ? 'checked' : '' }}>
                                        <label for="q14_2" class="italic">@lang('questionnaire-campaign.damocles.disagree')</label>
                                    </div>
                                    <div class="flex flex-row md:flex-col items-center">
                                        <input disabled class="checked:bg-sky-800" type="radio" id="q14_3"
                                            name="q14" value="3"
                                            {{ isset($answers['q14']) && $answers['q14'] == 3 ? 'checked' : '' }}>
                                        <label for="q14_3" class="italic">@lang('questionnaire-campaign.damocles.neutral')</label>
                                    </div>
                                    <div class="flex flex-row md:flex-col items-center">
                                        <input disabled class="checked:bg-sky-800" type="radio" id="q14_4"
                                            name="q14" value="4"
                                            {{ isset($answers['q14']) && $answers['q14'] == 4 ? 'checked' : '' }}>
                                        <label for="q14_4" class="italic">@lang('questionnaire-campaign.damocles.agree')</label>
                                    </div>
                                    <div class="flex flex-row md:flex-col items-center">
                                        <input disabled class="checked:bg-sky-800" type="radio" id="q14_5"
                                            name="q14" value="5"
                                            {{ isset($answers['q14']) && $answers['q14'] == 5 ? 'checked' : '' }}>
                                        <label for="q14_5" class="italic">@lang('questionnaire-campaign.damocles.stronglyAgree')</label>
                                    </div>
                                </div>
                            </div>

                            <!-- Q15 -->
                            <div class="py-3 flex flex-col border-b-2">
                                <p class="text-center font-medium py-3">Password managers are a reliable tool for
                                    protecting my
                                    privacy and sensitive data.</p>
                                <div
                                    class="flex flex-col md:flex-row items-top md:items-center w-full md:justify-around">
                                    <div class="flex flex-row md:flex-col items-center">
                                        <input disabled class="checked:bg-sky-800" type="radio" id="q15_1"
                                            name="q15" value="1"
                                            {{ isset($answers['q15']) && $answers['q15'] == 1 ? 'checked' : '' }}>
                                        <label for="q15_1" class="italic">@lang('questionnaire-campaign.damocles.stronglyDisagree')</label>
                                    </div>
                                    <div class="flex flex-row md:flex-col items-center">
                                        <input disabled class="checked:bg-sky-800" type="radio" id="q15_2"
                                            name="q15" value="2"
                                            {{ isset($answers['q15']) && $answers['q15'] == 2 ? 'checked' : '' }}>
                                        <label for="q15_2" class="italic">@lang('questionnaire-campaign.damocles.disagree')</label>
                                    </div>
                                    <div class="flex flex-row md:flex-col items-center">
                                        <input disabled class="checked:bg-sky-800" type="radio" id="q15_3"
                                            name="q15" value="3"
                                            {{ isset($answers['q15']) && $answers['q15'] == 3 ? 'checked' : '' }}>
                                        <label for="q15_3" class="italic">@lang('questionnaire-campaign.damocles.neutral')</label>
                                    </div>
                                    <div class="flex flex-row md:flex-col items-center">
                                        <input disabled class="checked:bg-sky-800" type="radio" id="q15_4"
                                            name="q15" value="4"
                                            {{ isset($answers['q15']) && $answers['q15'] == 4 ? 'checked' : '' }}>
                                        <label for="q15_4" class="italic">@lang('questionnaire-campaign.damocles.agree')</label>
                                    </div>
                                    <div class="flex flex-row md:flex-col items-center">
                                        <input disabled class="checked:bg-sky-800" type="radio" id="q15_5"
                                            name="q15" value="5"
                                            {{ isset($answers['q15']) && $answers['q15'] == 5 ? 'checked' : '' }}>
                                        <label for="q15_5" class="italic">@lang('questionnaire-campaign.damocles.stronglyAgree')</label>
                                    </div>
                                </div>
                            </div>

                            <!-- Q16 -->
                            <div class="py-3 flex flex-col border-b-2">
                                <p class="text-center font-medium py-3">I am inclined to improve my knowledge about a
                                    password
                                    manager.</p>
                                <div
                                    class="flex flex-col md:flex-row items-top md:items-center w-full md:justify-around">
                                    <div class="flex flex-row md:flex-col items-center">
                                        <input disabled class="checked:bg-sky-800" type="radio" id="q16_1"
                                            name="q16" value="1"
                                            {{ isset($answers['q16']) && $answers['q16'] == 1 ? 'checked' : '' }}>
                                        <label for="q16_1" class="italic">@lang('questionnaire-campaign.damocles.stronglyDisagree')</label>
                                    </div>
                                    <div class="flex flex-row md:flex-col items-center">
                                        <input disabled class="checked:bg-sky-800" type="radio" id="q16_2"
                                            name="q16" value="2"
                                            {{ isset($answers['q16']) && $answers['q16'] == 2 ? 'checked' : '' }}>
                                        <label for="q16_2" class="italic">@lang('questionnaire-campaign.damocles.disagree')</label>
                                    </div>
                                    <div class="flex flex-row md:flex-col items-center">
                                        <input disabled class="checked:bg-sky-800" type="radio" id="q16_3"
                                            name="q16" value="3"
                                            {{ isset($answers['q16']) && $answers['q16'] == 3 ? 'checked' : '' }}>
                                        <label for="q16_3" class="italic">@lang('questionnaire-campaign.damocles.neutral')</label>
                                    </div>
                                    <div class="flex flex-row md:flex-col items-center">
                                        <input disabled class="checked:bg-sky-800" type="radio" id="q16_4"
                                            name="q16" value="4"
                                            {{ isset($answers['q16']) && $answers['q16'] == 4 ? 'checked' : '' }}>
                                        <label for="q16_4" class="italic">@lang('questionnaire-campaign.damocles.agree')</label>
                                    </div>
                                    <div class="flex flex-row md:flex-col items-center">
                                        <input disabled class="checked:bg-sky-800" type="radio" id="q16_5"
                                            name="q16" value="5"
                                            {{ isset($answers['q16']) && $answers['q16'] == 5 ? 'checked' : '' }}>
                                        <label for="q16_5" class="italic">@lang('questionnaire-campaign.damocles.stronglyAgree')</label>
                                    </div>
                                </div>
                            </div>

                            <!-- Q17 -->
                            <div class="py-3 flex flex-col border-b-2">
                                <p class="text-center font-medium py-3">I experiment password managers with trial
                                    periods to assess
                                    their suitability for my needs..</p>
                                <div
                                    class="flex flex-col md:flex-row items-top md:items-center w-full md:justify-around">
                                    <div class="flex flex-row md:flex-col items-center">
                                        <input disabled class="checked:bg-sky-800" type="radio" id="q17_1"
                                            name="q17" value="1"
                                            {{ isset($answers['q17']) && $answers['q17'] == 1 ? 'checked' : '' }}>
                                        <label for="q17_1" class="italic">@lang('questionnaire-campaign.damocles.stronglyDisagree')</label>
                                    </div>
                                    <div class="flex flex-row md:flex-col items-center">
                                        <input disabled class="checked:bg-sky-800" type="radio" id="q17_2"
                                            name="q17" value="2"
                                            {{ isset($answers['q17']) && $answers['q17'] == 2 ? 'checked' : '' }}>
                                        <label for="q17_2" class="italic">@lang('questionnaire-campaign.damocles.disagree')</label>
                                    </div>
                                    <div class="flex flex-row md:flex-col items-center">
                                        <input disabled class="checked:bg-sky-800" type="radio" id="q17_3"
                                            name="q17" value="3"
                                            {{ isset($answers['q17']) && $answers['q17'] == 3 ? 'checked' : '' }}>
                                        <label for="q17_3" class="italic">@lang('questionnaire-campaign.damocles.neutral')</label>
                                    </div>
                                    <div class="flex flex-row md:flex-col items-center">
                                        <input disabled class="checked:bg-sky-800" type="radio" id="q17_4"
                                            name="q17" value="4"
                                            {{ isset($answers['q17']) && $answers['q17'] == 4 ? 'checked' : '' }}>
                                        <label for="q17_4" class="italic">@lang('questionnaire-campaign.damocles.agree')</label>
                                    </div>
                                    <div class="flex flex-row md:flex-col items-center">
                                        <input disabled class="checked:bg-sky-800" type="radio" id="q17_5"
                                            name="q17" value="5"
                                            {{ isset($answers['q17']) && $answers['q17'] == 5 ? 'checked' : '' }}>
                                        <label for="q17_5" class="italic">@lang('questionnaire-campaign.damocles.stronglyAgree')</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex w-full items-center pt-4">
                        <div class="flex w-1/3 justify-center">
                            <x-primary-button type="button" id="prevBtn"
                                onclick="nextPrev(-1)">Previous</x-primary-button>
                        </div>

                        <!-- Circles which indicates the steps of the form: -->
                        <div class="flex w-1/3 justify-center flex-row">
                            <span class="step"></span>
                            <span class="step"></span>
                        </div>

                        <div class="flex w-1/3 justify-center">
                            <x-primary-button type="button" id="nextBtn"
                                onclick="nextPrev(1)">Next</x-primary-button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    var currentTab = 0;
    showTab(currentTab);

    function showTab(n) {
        var x = document.getElementsByClassName("tab");
        x[n].style.display = "block";

        if (n == 0) {
            document.getElementById("prevBtn").style.display = "none";
        } else {
            document.getElementById("prevBtn").style.display = "inline";
        }

        if (n == (x.length - 1)) {
            document.getElementById("nextBtn").style.display = "none";
        } else {
            document.getElementById("nextBtn").style.display = "inline";
            document.getElementById("nextBtn").innerHTML = "Next";
        }

        // Scroll to the top of the page
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });

        fixStepIndicator(n);
    }

    function nextPrev(n) {
        var x = document.getElementsByClassName("tab");
        if (n == 1 && !validateForm()) return false;

        x[currentTab].style.display = "none";
        currentTab = currentTab + n;

        showTab(currentTab);
    }

    function validateForm() {
        var x, valid = true;
        x = document.getElementsByClassName("tab");

        // Implementa la tua logica di validazione qui, se necessario

        if (valid) {
            document.getElementsByClassName("step")[currentTab].className += " finish";
        }

        return valid;
    }

    function fixStepIndicator(n) {
        var i, x = document.getElementsByClassName("step");
        for (i = 0; i < x.length; i++) {
            x[i].className = x[i].className.replace(" active", "");
        }
        x[n].className += " active";

        if (n === x.length - 1) {
            x[n].className += " finish";
        }
    }
</script>