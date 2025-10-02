<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row item-center gap-3">
            <!-- Back to questionnaires campaign -->
            <a href="{{ url()->previous() }}" class="cursor-pointer">
                <x-primary-button>
                    @lang('questionnaire-campaign.hais.back')
                </x-primary-button>
            </a>
            <!-- Breadcrumb -->
            <ul class="flex flex-row gap-1 flex-wrap break-words text-sky-800">
                <li><a href="{{ route('questionnaires-campaign.index') }}">@lang('questionnaire-campaign.hais.questionnairesCampaigns')</a></li>
                <li>/</li>
                <li><a>@lang('questionnaire-campaign.hais.hais')</a></li>
            </ul>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-sky-900">

                    <!-- Results -->
                    <p class="text-2xl font-semibold text-center">@lang('questionnaire-campaign.hais.result')</p>

                    <!-- Focus area: Password management -->
                    <div class="tab hidden">

                        <p class="italic font-semibold text-center pt-6">Focus area: Password management</p>

                        <p class="font-semibold text-center pt-4">Using the same password</p>

                        <!-- Q1 -->
                        <div class="py-3 flex flex-col border-b-2">
                            <p class="text-center font-medium py-3">It's acceptable to use my social media passwords on
                                my
                                work
                                accounts.</p>
                            <div class="flex flex-col md:flex-row items-top md:items-center w-full md:justify-around">
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q1_1"
                                        name="q1" value="1"
                                        {{ isset($answers['q1']) && $answers['q1'] == 1 ? 'checked' : '' }}>
                                    <label for="q1_1" class="italic">@lang('questionnaire-campaign.hais.stronglyAgree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q1_2"
                                        name="q1" value="2"
                                        {{ isset($answers['q1']) && $answers['q1'] == 2 ? 'checked' : '' }}>
                                    <label for="q1_2" class="italic">@lang('questionnaire-campaign.hais.agree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q1_3"
                                        name="q1" value="3"
                                        {{ isset($answers['q1']) && $answers['q1'] == 3 ? 'checked' : '' }}>
                                    <label for="q1_3" class="italic">@lang('questionnaire-campaign.hais.neutral')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q1_4"
                                        name="q1" value="4"
                                        {{ isset($answers['q1']) && $answers['q1'] == 4 ? 'checked' : '' }}>
                                    <label for="q1_4" class="italic">@lang('questionnaire-campaign.hais.disagree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q1_5"
                                        name="q1" value="5"
                                        {{ isset($answers['q1']) && $answers['q1'] == 5 ? 'checked' : '' }}>
                                    <label for="q1_5" class="italic">@lang('questionnaire-campaign.hais.stronglyDisagree')</label>
                                </div>
                            </div>
                        </div>

                        <!-- Q2 -->
                        <div class="py-3 flex flex-col border-b-2">
                            <p class="text-center font-medium py-3">It's safe to use the same password for social media
                                and work accounts.</p>
                            <div class="flex flex-col md:flex-row items-top md:items-center w-full md:justify-around">
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q2_1"
                                        name="q2" value="1"
                                        {{ isset($answers['q2']) && $answers['q2'] == 1 ? 'checked' : '' }}>
                                    <label for="q2_1" class="italic">@lang('questionnaire-campaign.hais.stronglyAgree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q2_2"
                                        name="q2" value="2"
                                        {{ isset($answers['q2']) && $answers['q2'] == 2 ? 'checked' : '' }}>
                                    <label for="q2_2" class="italic">@lang('questionnaire-campaign.hais.agree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q2_3"
                                        name="q2" value="3"
                                        {{ isset($answers['q2']) && $answers['q2'] == 3 ? 'checked' : '' }}>
                                    <label for="q2_3" class="italic">@lang('questionnaire-campaign.hais.neutral')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q2_4"
                                        name="q2" value="4"
                                        {{ isset($answers['q2']) && $answers['q2'] == 4 ? 'checked' : '' }}>
                                    <label for="q2_4" class="italic">@lang('questionnaire-campaign.hais.disagree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q2_5"
                                        name="q2" value="5"
                                        {{ isset($answers['q2']) && $answers['q2'] == 5 ? 'checked' : '' }}>
                                    <label for="q2_5" class="italic">@lang('questionnaire-campaign.hais.stronglyDisagree')</label>
                                </div>
                            </div>
                        </div>

                        <!-- Q3 -->
                        <div class="py-3 flex flex-col border-b-2">
                            <p class="text-center font-medium py-3">I use a different password for my social media and
                                work
                                accounts.</p>
                            <div class="flex flex-col md:flex-row items-top md:items-center w-full md:justify-around">
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q3_1"
                                        name="q3" value="1"
                                        {{ isset($answers['q3']) && $answers['q3'] == 1 ? 'checked' : '' }}>
                                    <label for="q3_1" class="italic">@lang('questionnaire-campaign.hais.stronglyDisagree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q3_2"
                                        name="q3" value="2"
                                        {{ isset($answers['q3']) && $answers['q3'] == 2 ? 'checked' : '' }}>
                                    <label for="q3_2" class="italic">@lang('questionnaire-campaign.hais.disagree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q3_3"
                                        name="q3" value="3"
                                        {{ isset($answers['q3']) && $answers['q3'] == 3 ? 'checked' : '' }}>
                                    <label for="q3_3" class="italic">@lang('questionnaire-campaign.hais.neutral')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q3_4"
                                        name="q3" value="4"
                                        {{ isset($answers['q3']) && $answers['q3'] == 4 ? 'checked' : '' }}>
                                    <label for="q3_4" class="italic">@lang('questionnaire-campaign.hais.agree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q3_5"
                                        name="q3" value="5"
                                        {{ isset($answers['q3']) && $answers['q3'] == 5 ? 'checked' : '' }}>
                                    <label for="q3_5" class="italic">@lang('questionnaire-campaign.hais.stronglyAgree')</label>
                                </div>
                            </div>
                        </div>

                        <p class="font-semibold text-center pt-4">Sharing passwords</p>

                        <!-- Q4 -->
                        <div class="py-3 flex flex-col border-b-2">
                            <p class="text-center font-medium py-3">I am allowed to share my work passwords with
                                colleagues.
                            </p>
                            <div class="flex flex-col md:flex-row items-top md:items-center w-full md:justify-around">
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q4_1"
                                        name="q4" value="1"
                                        {{ isset($answers['q4']) && $answers['q4'] == 1 ? 'checked' : '' }}>
                                    <label for="q4_1" class="italic">@lang('questionnaire-campaign.hais.stronglyAgree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q4_2"
                                        name="q4" value="2"
                                        {{ isset($answers['q4']) && $answers['q4'] == 2 ? 'checked' : '' }}>
                                    <label for="q4_2" class="italic">@lang('questionnaire-campaign.hais.agree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q4_3"
                                        name="q4" value="3"
                                        {{ isset($answers['q4']) && $answers['q4'] == 3 ? 'checked' : '' }}>
                                    <label for="q4_3" class="italic">@lang('questionnaire-campaign.hais.neutral')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q4_4"
                                        name="q4" value="4"
                                        {{ isset($answers['q4']) && $answers['q4'] == 4 ? 'checked' : '' }}>
                                    <label for="q4_4" class="italic">@lang('questionnaire-campaign.hais.disagree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q4_5"
                                        name="q4" value="5"
                                        {{ isset($answers['q4']) && $answers['q4'] == 5 ? 'checked' : '' }}>
                                    <label for="q4_5" class="italic">@lang('questionnaire-campaign.hais.stronglyDisagree')</label>
                                </div>
                            </div>
                        </div>

                        <!-- Q5 -->
                        <div class="py-3 flex flex-col border-b-2">
                            <p class="text-center font-medium py-3">It's a bad idea to share my work passwords, even if
                                a
                                colleague asks for it.</p>
                            <div class="flex flex-col md:flex-row items-top md:items-center w-full md:justify-around">
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q5_1"
                                        name="q5" value="1"
                                        {{ isset($answers['q5']) && $answers['q5'] == 1 ? 'checked' : '' }}>
                                    <label for="q5_1" class="italic">@lang('questionnaire-campaign.hais.stronglyDisagree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q5_2"
                                        name="q5" value="2"
                                        {{ isset($answers['q5']) && $answers['q5'] == 2 ? 'checked' : '' }}>
                                    <label for="q5_2" class="italic">@lang('questionnaire-campaign.hais.disagree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q5_3"
                                        name="q5" value="3"
                                        {{ isset($answers['q5']) && $answers['q5'] == 3 ? 'checked' : '' }}>
                                    <label for="q5_3" class="italic">@lang('questionnaire-campaign.hais.neutral')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q5_4"
                                        name="q5" value="4"
                                        {{ isset($answers['q5']) && $answers['q5'] == 4 ? 'checked' : '' }}>
                                    <label for="q5_4" class="italic">@lang('questionnaire-campaign.hais.agree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q5_5"
                                        name="q5" value="5"
                                        {{ isset($answers['q5']) && $answers['q5'] == 5 ? 'checked' : '' }}>
                                    <label for="q5_5" class="italic">@lang('questionnaire-campaign.hais.stronglyAgree')</label>
                                </div>
                            </div>
                        </div>

                        <!-- Q6 -->
                        <div class="py-3 flex flex-col border-b-2">
                            <p class="text-center font-medium py-3">I share my work passwords with colleagues.</p>
                            <div class="flex flex-col md:flex-row items-top md:items-center w-full md:justify-around">
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q6_1"
                                        name="q6" value="1"
                                        {{ isset($answers['q6']) && $answers['q6'] == 1 ? 'checked' : '' }}>
                                    <label for="q6_1" class="italic">@lang('questionnaire-campaign.hais.stronglyAgree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q6_2"
                                        name="q6" value="2"
                                        {{ isset($answers['q6']) && $answers['q6'] == 2 ? 'checked' : '' }}>
                                    <label for="q6_2" class="italic">@lang('questionnaire-campaign.hais.agree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q6_3"
                                        name="q6" value="3"
                                        {{ isset($answers['q6']) && $answers['q6'] == 3 ? 'checked' : '' }}>
                                    <label for="q6_3" class="italic">@lang('questionnaire-campaign.hais.neutral')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q6_4"
                                        name="q6" value="4"
                                        {{ isset($answers['q6']) && $answers['q6'] == 4 ? 'checked' : '' }}>
                                    <label for="q6_4" class="italic">@lang('questionnaire-campaign.hais.disagree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q6_5"
                                        name="q6" value="5"
                                        {{ isset($answers['q6']) && $answers['q6'] == 5 ? 'checked' : '' }}>
                                    <label for="q6_5" class="italic">@lang('questionnaire-campaign.hais.stronglyDisagree')</label>
                                </div>
                            </div>
                        </div>

                        <p class="font-semibold text-center pt-4">Using a strong password</p>

                        <!-- Q7 -->
                        <div class="py-3 flex flex-col border-b-2">
                            <p class="text-center font-medium py-3">A mixture of letters, numbers and symbols is
                                necessary
                                for
                                work passwords.</p>
                            <div class="flex flex-col md:flex-row items-top md:items-center w-full md:justify-around">
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q7_1"
                                        name="q7" value="1"
                                        {{ isset($answers['q7']) && $answers['q7'] == 1 ? 'checked' : '' }}>
                                    <label for="q7_1" class="italic">@lang('questionnaire-campaign.hais.stronglyDisagree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q7_2"
                                        name="q7" value="2"
                                        {{ isset($answers['q7']) && $answers['q7'] == 2 ? 'checked' : '' }}>
                                    <label for="q7_2" class="italic">@lang('questionnaire-campaign.hais.disagree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q7_3"
                                        name="q7" value="3"
                                        {{ isset($answers['q7']) && $answers['q7'] == 3 ? 'checked' : '' }}>
                                    <label for="q7_3" class="italic">@lang('questionnaire-campaign.hais.neutral')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q7_4"
                                        name="q7" value="4"
                                        {{ isset($answers['q7']) && $answers['q7'] == 4 ? 'checked' : '' }}>
                                    <label for="q7_4" class="italic">@lang('questionnaire-campaign.hais.agree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q7_5"
                                        name="q7" value="5"
                                        {{ isset($answers['q7']) && $answers['q7'] == 5 ? 'checked' : '' }}>
                                    <label for="q7_5" class="italic">@lang('questionnaire-campaign.hais.stronglyAgree')</label>
                                </div>
                            </div>
                        </div>

                        <!-- Q8 -->
                        <div class="py-3 flex flex-col border-b-2">
                            <p class="text-center font-medium py-3">It's safe to have a work password with just
                                letters.
                            </p>
                            <div class="flex flex-col md:flex-row items-top md:items-center w-full md:justify-around">
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q8_1"
                                        name="q8" value="1"
                                        {{ isset($answers['q8']) && $answers['q8'] == 1 ? 'checked' : '' }}>
                                    <label for="q8_1" class="italic">@lang('questionnaire-campaign.hais.stronglyAgree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q8_2"
                                        name="q8" value="2"
                                        {{ isset($answers['q8']) && $answers['q8'] == 2 ? 'checked' : '' }}>
                                    <label for="q8_2" class="italic">@lang('questionnaire-campaign.hais.agree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q8_3"
                                        name="q8" value="3"
                                        {{ isset($answers['q8']) && $answers['q8'] == 3 ? 'checked' : '' }}>
                                    <label for="q8_3" class="italic">@lang('questionnaire-campaign.hais.neutral')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q8_4"
                                        name="q8" value="4"
                                        {{ isset($answers['q8']) && $answers['q8'] == 4 ? 'checked' : '' }}>
                                    <label for="q8_4" class="italic">@lang('questionnaire-campaign.hais.disagree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q8_5"
                                        name="q8" value="5"
                                        {{ isset($answers['q8']) && $answers['q8'] == 5 ? 'checked' : '' }}>
                                    <label for="q8_5" class="italic">@lang('questionnaire-campaign.hais.stronglyDisagree')</label>
                                </div>
                            </div>
                        </div>

                        <!-- Q9 -->
                        <div class="py-3 flex flex-col border-b-2">
                            <p class="text-center font-medium py-3">I use a combination of letters, numbers and symbols
                                in
                                my
                                work passwords.</p>
                            <div class="flex flex-col md:flex-row items-top md:items-center w-full md:justify-around">
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q9_1"
                                        name="q9" value="1"
                                        {{ isset($answers['q9']) && $answers['q9'] == 1 ? 'checked' : '' }}>
                                    <label for="q9_1" class="italic">@lang('questionnaire-campaign.hais.stronglyDisagree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q9_2"
                                        name="q9" value="2"
                                        {{ isset($answers['q9']) && $answers['q9'] == 2 ? 'checked' : '' }}>
                                    <label for="q9_2" class="italic">@lang('questionnaire-campaign.hais.disagree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q9_3"
                                        name="q9" value="3"
                                        {{ isset($answers['q9']) && $answers['q9'] == 3 ? 'checked' : '' }}>
                                    <label for="q9_3" class="italic">@lang('questionnaire-campaign.hais.neutral')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q9_4"
                                        name="q9" value="4"
                                        {{ isset($answers['q9']) && $answers['q9'] == 4 ? 'checked' : '' }}>
                                    <label for="q9_4" class="italic">@lang('questionnaire-campaign.hais.agree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q9_5"
                                        name="q9" value="5"
                                        {{ isset($answers['q9']) && $answers['q9'] == 5 ? 'checked' : '' }}>
                                    <label for="q9_5" class="italic">@lang('questionnaire-campaign.hais.stronglyAgree')</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Focus area: Email use -->
                    <div class="tab hidden">

                        <p class="italic font-semibold text-center pt-6">Focus area: Email use</p>

                        <p class="font-semibold text-center pt-4">Clicking on links in emails from known
                            senders</p>

                        <!-- Q10 -->
                        <div class="py-3 flex flex-col border-b-2">
                            <p class="text-center font-medium py-3">I am allowed to click on any links in emails from
                                people I
                                know.</p>
                            <div class="flex flex-col md:flex-row items-top md:items-center w-full md:justify-around">
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q10_1"
                                        name="q10" value="1"
                                        {{ isset($answers['q10']) && $answers['q10'] == 1 ? 'checked' : '' }}>
                                    <label for="q10_1" class="italic">@lang('questionnaire-campaign.hais.stronglyAgree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q10_2"
                                        name="q10" value="2"
                                        {{ isset($answers['q10']) && $answers['q10'] == 2 ? 'checked' : '' }}>
                                    <label for="q10_2" class="italic">@lang('questionnaire-campaign.hais.agree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q10_3"
                                        name="q10" value="3"
                                        {{ isset($answers['q10']) && $answers['q10'] == 3 ? 'checked' : '' }}>
                                    <label for="q10_3" class="italic">@lang('questionnaire-campaign.hais.neutral')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q10_4"
                                        name="q10" value="4"
                                        {{ isset($answers['q10']) && $answers['q10'] == 4 ? 'checked' : '' }}>
                                    <label for="q10_4" class="italic">@lang('questionnaire-campaign.hais.disagree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q10_5"
                                        name="q10" value="5"
                                        {{ isset($answers['q10']) && $answers['q10'] == 5 ? 'checked' : '' }}>
                                    <label for="q10_5" class="italic">@lang('questionnaire-campaign.hais.stronglyDisagree')</label>
                                </div>
                            </div>
                        </div>

                        <!-- Q11 -->
                        <div class="py-3 flex flex-col border-b-2">
                            <p class="text-center font-medium py-3">It's always safe to click on links in emails from
                                people I
                                know.</p>
                            <div class="flex flex-col md:flex-row items-top md:items-center w-full md:justify-around">
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q11_1"
                                        name="q11" value="1"
                                        {{ isset($answers['q11']) && $answers['q11'] == 1 ? 'checked' : '' }}>
                                    <label for="q11_1" class="italic">@lang('questionnaire-campaign.hais.stronglyAgree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q11_2"
                                        name="q11" value="2"
                                        {{ isset($answers['q11']) && $answers['q11'] == 2 ? 'checked' : '' }}>
                                    <label for="q11_2" class="italic">@lang('questionnaire-campaign.hais.agree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q11_3"
                                        name="q11" value="3"
                                        {{ isset($answers['q11']) && $answers['q11'] == 3 ? 'checked' : '' }}>
                                    <label for="q11_3" class="italic">@lang('questionnaire-campaign.hais.neutral')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q11_4"
                                        name="q11" value="4"
                                        {{ isset($answers['q11']) && $answers['q11'] == 4 ? 'checked' : '' }}>
                                    <label for="q11_4" class="italic">@lang('questionnaire-campaign.hais.disagree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q11_5"
                                        name="q11" value="5"
                                        {{ isset($answers['q11']) && $answers['q11'] == 5 ? 'checked' : '' }}>
                                    <label for="q11_5" class="italic">@lang('questionnaire-campaign.hais.stronglyDisagree')</label>
                                </div>
                            </div>
                        </div>

                        <!-- Q12 -->
                        <div class="py-3 flex flex-col border-b-2">
                            <p class="text-center font-medium py-3">I don't always click on links in emails just
                                because
                                they
                                come from someone I know.</p>
                            <div class="flex flex-col md:flex-row items-top md:items-center w-full md:justify-around">
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q12_1"
                                        name="q12" value="1"
                                        {{ isset($answers['q12']) && $answers['q12'] == 1 ? 'checked' : '' }}>
                                    <label for="q12_1" class="italic">@lang('questionnaire-campaign.hais.stronglyDisagree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q12_2"
                                        name="q12" value="2"
                                        {{ isset($answers['q12']) && $answers['q12'] == 2 ? 'checked' : '' }}>
                                    <label for="q12_2" class="italic">@lang('questionnaire-campaign.hais.disagree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q12_3"
                                        name="q12" value="3"
                                        {{ isset($answers['q12']) && $answers['q12'] == 3 ? 'checked' : '' }}>
                                    <label for="q12_3" class="italic">@lang('questionnaire-campaign.hais.neutral')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q12_4"
                                        name="q12" value="4"
                                        {{ isset($answers['q12']) && $answers['q12'] == 4 ? 'checked' : '' }}>
                                    <label for="q12_4" class="italic">@lang('questionnaire-campaign.hais.agree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q12_5"
                                        name="q12" value="5"
                                        {{ isset($answers['q12']) && $answers['q12'] == 5 ? 'checked' : '' }}>
                                    <label for="q12_5" class="italic">@lang('questionnaire-campaign.hais.stronglyAgree')</label>
                                </div>
                            </div>
                        </div>

                        <p class="font-semibold text-center pt-4">Clicking on links in emails from unknown
                            senders
                        </p>

                        <!-- Q13 -->
                        <div class="py-3 flex flex-col border-b-2">
                            <p class="text-center font-medium py-3">I am not permitted to click on a link in an email
                                from
                                an
                                unknown sender.</p>
                            <div class="flex flex-col md:flex-row items-top md:items-center w-full md:justify-around">
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q13_1"
                                        name="q13" value="1"
                                        {{ isset($answers['q13']) && $answers['q13'] == 1 ? 'checked' : '' }}>
                                    <label for="q13_1" class="italic">@lang('questionnaire-campaign.hais.stronglyDisagree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q13_2"
                                        name="q13" value="2"
                                        {{ isset($answers['q13']) && $answers['q13'] == 2 ? 'checked' : '' }}>
                                    <label for="q13_2" class="italic">@lang('questionnaire-campaign.hais.disagree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q13_3"
                                        name="q13" value="3"
                                        {{ isset($answers['q13']) && $answers['q13'] == 3 ? 'checked' : '' }}>
                                    <label for="q13_3" class="italic">@lang('questionnaire-campaign.hais.neutral')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q13_4"
                                        name="q13" value="4"
                                        {{ isset($answers['q13']) && $answers['q13'] == 4 ? 'checked' : '' }}>
                                    <label for="q13_4" class="italic">@lang('questionnaire-campaign.hais.agree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q13_5"
                                        name="q13" value="5"
                                        {{ isset($answers['q13']) && $answers['q13'] == 5 ? 'checked' : '' }}>
                                    <label for="q13_5" class="italic">@lang('questionnaire-campaign.hais.stronglyAgree')</label>
                                </div>
                            </div>
                        </div>

                        <!-- Q14 -->
                        <div class="py-3 flex flex-col border-b-2">
                            <p class="text-center font-medium py-3">Nothing bad can happen if I click on a link in an
                                email
                                from an unknown sender.</p>
                            <div class="flex flex-col md:flex-row items-top md:items-center w-full md:justify-around">
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q14_1"
                                        name="q14" value="1"
                                        {{ isset($answers['q14']) && $answers['q14'] == 1 ? 'checked' : '' }}>
                                    <label for="q14_1" class="italic">@lang('questionnaire-campaign.hais.stronglyAgree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q14_2"
                                        name="q14" value="2"
                                        {{ isset($answers['q14']) && $answers['q14'] == 2 ? 'checked' : '' }}>
                                    <label for="q14_2" class="italic">@lang('questionnaire-campaign.hais.agree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q14_3"
                                        name="q14" value="3"
                                        {{ isset($answers['q14']) && $answers['q14'] == 3 ? 'checked' : '' }}>
                                    <label for="q14_3" class="italic">@lang('questionnaire-campaign.hais.neutral')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q14_4"
                                        name="q14" value="4"
                                        {{ isset($answers['q14']) && $answers['q14'] == 4 ? 'checked' : '' }}>
                                    <label for="q14_4" class="italic">@lang('questionnaire-campaign.hais.disagree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q14_5"
                                        name="q14" value="5"
                                        {{ isset($answers['q14']) && $answers['q14'] == 5 ? 'checked' : '' }}>
                                    <label for="q14_5" class="italic">@lang('questionnaire-campaign.hais.stronglyDisagree')</label>
                                </div>
                            </div>
                        </div>

                        <!-- Q15 -->
                        <div class="py-3 flex flex-col border-b-2">
                            <p class="text-center font-medium py-3">If an email from an unknown sender looks
                                interesting, I
                                click on a link within it.</p>
                            <div class="flex flex-col md:flex-row items-top md:items-center w-full md:justify-around">
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q15_1"
                                        name="q15" value="1"
                                        {{ isset($answers['q15']) && $answers['q15'] == 1 ? 'checked' : '' }}>
                                    <label for="q15_1" class="italic">@lang('questionnaire-campaign.hais.stronglyAgree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q15_2"
                                        name="q15" value="2"
                                        {{ isset($answers['q15']) && $answers['q15'] == 2 ? 'checked' : '' }}>
                                    <label for="q15_2" class="italic">@lang('questionnaire-campaign.hais.agree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q15_3"
                                        name="q15" value="3"
                                        {{ isset($answers['q15']) && $answers['q15'] == 3 ? 'checked' : '' }}>
                                    <label for="q15_3" class="italic">@lang('questionnaire-campaign.hais.neutral')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q15_4"
                                        name="q15" value="4"
                                        {{ isset($answers['q15']) && $answers['q15'] == 4 ? 'checked' : '' }}>
                                    <label for="q15_4" class="italic">@lang('questionnaire-campaign.hais.disagree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q15_5"
                                        name="q15" value="5"
                                        {{ isset($answers['q15']) && $answers['q15'] == 5 ? 'checked' : '' }}>
                                    <label for="q15_5" class="italic">@lang('questionnaire-campaign.hais.stronglyDisagree')</label>
                                </div>
                            </div>
                        </div>

                        <p class="font-semibold text-center pt-4">Opening attachments in emails from
                            unknown
                            senders
                        </p>

                        <!-- Q16 -->
                        <div class="py-3 flex flex-col border-b-2">
                            <p class="text-center font-medium py-3">I am allowed to open email attachments from unknown
                                senders.</p>
                            <div class="flex flex-col md:flex-row items-top md:items-center w-full md:justify-around">
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q16_1"
                                        name="q16" value="1"
                                        {{ isset($answers['q16']) && $answers['q16'] == 1 ? 'checked' : '' }}>
                                    <label for="q16_1" class="italic">@lang('questionnaire-campaign.hais.stronglyAgree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q16_2"
                                        name="q16" value="2"
                                        {{ isset($answers['q16']) && $answers['q16'] == 2 ? 'checked' : '' }}>
                                    <label for="q16_2" class="italic">@lang('questionnaire-campaign.hais.agree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q16_3"
                                        name="q16" value="3"
                                        {{ isset($answers['q16']) && $answers['q16'] == 3 ? 'checked' : '' }}>
                                    <label for="q16_3" class="italic">@lang('questionnaire-campaign.hais.neutral')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q16_4"
                                        name="q16" value="4"
                                        {{ isset($answers['q16']) && $answers['q16'] == 4 ? 'checked' : '' }}>
                                    <label for="q16_4" class="italic">@lang('questionnaire-campaign.hais.disagree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q16_5"
                                        name="q16" value="5"
                                        {{ isset($answers['q16']) && $answers['q16'] == 5 ? 'checked' : '' }}>
                                    <label for="q16_5" class="italic">@lang('questionnaire-campaign.hais.stronglyDisagree')</label>
                                </div>
                            </div>
                        </div>

                        <!-- Q17 -->
                        <div class="py-3 flex flex-col border-b-2">
                            <p class="text-center font-medium py-3">It's risky to open an email attachment from an
                                unknown
                                sender.</p>
                            <div class="flex flex-col md:flex-row items-top md:items-center w-full md:justify-around">
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q17_1"
                                        name="q17" value="1"
                                        {{ isset($answers['q17']) && $answers['q17'] == 1 ? 'checked' : '' }}>
                                    <label for="q17_1" class="italic">@lang('questionnaire-campaign.hais.stronglyDisagree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q17_2"
                                        name="q17" value="2"
                                        {{ isset($answers['q17']) && $answers['q17'] == 2 ? 'checked' : '' }}>
                                    <label for="q17_2" class="italic">@lang('questionnaire-campaign.hais.disagree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q17_3"
                                        name="q17" value="3"
                                        {{ isset($answers['q17']) && $answers['q17'] == 3 ? 'checked' : '' }}>
                                    <label for="q17_3" class="italic">@lang('questionnaire-campaign.hais.neutral')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q17_4"
                                        name="q17" value="4"
                                        {{ isset($answers['q17']) && $answers['q17'] == 4 ? 'checked' : '' }}>
                                    <label for="q17_4" class="italic">@lang('questionnaire-campaign.hais.agree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q17_5"
                                        name="q17" value="5"
                                        {{ isset($answers['q17']) && $answers['q17'] == 5 ? 'checked' : '' }}>
                                    <label for="q17_5" class="italic">@lang('questionnaire-campaign.hais.stronglyAgree')</label>
                                </div>
                            </div>
                        </div>

                        <!-- Q18 -->
                        <div class="py-3 flex flex-col border-b-2">
                            <p class="text-center font-medium py-3">I don't open email attachments if
                                the sender is unknown to me.</p>
                            <div class="flex flex-col md:flex-row items-top md:items-center w-full md:justify-around">
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q18_1"
                                        name="q18" value="1"
                                        {{ isset($answers['q18']) && $answers['q18'] == 1 ? 'checked' : '' }}>
                                    <label for="q18_1" class="italic">@lang('questionnaire-campaign.hais.stronglyDisagree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q18_2"
                                        name="q18" value="2"
                                        {{ isset($answers['q18']) && $answers['q18'] == 2 ? 'checked' : '' }}>
                                    <label for="q18_2" class="italic">@lang('questionnaire-campaign.hais.disagree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q18_3"
                                        name="q18" value="3"
                                        {{ isset($answers['q18']) && $answers['q18'] == 3 ? 'checked' : '' }}>
                                    <label for="q18_3" class="italic">@lang('questionnaire-campaign.hais.neutral')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q18_4"
                                        name="q18" value="4"
                                        {{ isset($answers['q18']) && $answers['q18'] == 4 ? 'checked' : '' }}>
                                    <label for="q18_4" class="italic">@lang('questionnaire-campaign.hais.agree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q18_5"
                                        name="q18" value="5"
                                        {{ isset($answers['q18']) && $answers['q18'] == 5 ? 'checked' : '' }}>
                                    <label for="q18_5" class="italic">@lang('questionnaire-campaign.hais.stronglyAgree')</label>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Focus area: Internet use -->
                    <div class="tab hidden">

                        <p class="italic font-semibold text-center pt-6">Focus area: Internet use</p>

                        <p class="font-semibold text-center pt-4">Downloading files</p>

                        <!-- Q19 -->
                        <div class="py-3 flex flex-col border-b-2">
                            <p class="text-center font-medium py-3">I am allowed to download any files onto my work
                                computer if they help me to do my job.</p>
                            <div class="flex flex-col md:flex-row items-top md:items-center w-full md:justify-around">
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q19_1"
                                        name="q19" value="1"
                                        {{ isset($answers['q19']) && $answers['q19'] == 1 ? 'checked' : '' }}>
                                    <label for="q19_1" class="italic">@lang('questionnaire-campaign.hais.stronglyAgree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q19_2"
                                        name="q19" value="2"
                                        {{ isset($answers['q19']) && $answers['q19'] == 2 ? 'checked' : '' }}>
                                    <label for="q19_2" class="italic">@lang('questionnaire-campaign.hais.agree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q19_3"
                                        name="q19" value="3"
                                        {{ isset($answers['q19']) && $answers['q19'] == 3 ? 'checked' : '' }}>
                                    <label for="q19_3" class="italic">@lang('questionnaire-campaign.hais.neutral')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q19_4"
                                        name="q19" value="4"
                                        {{ isset($answers['q19']) && $answers['q19'] == 4 ? 'checked' : '' }}>
                                    <label for="q19_4" class="italic">@lang('questionnaire-campaign.hais.disagree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q19_5"
                                        name="q19" value="5"
                                        {{ isset($answers['q19']) && $answers['q19'] == 5 ? 'checked' : '' }}>
                                    <label for="q19_5" class="italic">@lang('questionnaire-campaign.hais.stronglyDisagree')</label>
                                </div>
                            </div>
                        </div>

                        <!-- Q20 -->
                        <div class="py-3 flex flex-col border-b-2">
                            <p class="text-center font-medium py-3">It can be risky to download files on my work
                                computer.
                            </p>
                            <div class="flex flex-col md:flex-row items-top md:items-center w-full md:justify-around">
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q20_1"
                                        name="q20" value="1"
                                        {{ isset($answers['q20']) && $answers['q20'] == 1 ? 'checked' : '' }}>
                                    <label for="q20_1" class="italic">@lang('questionnaire-campaign.hais.stronglyDisagree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q20_2"
                                        name="q20" value="2"
                                        {{ isset($answers['q20']) && $answers['q20'] == 2 ? 'checked' : '' }}>
                                    <label for="q20_2" class="italic">@lang('questionnaire-campaign.hais.disagree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q20_3"
                                        name="q20" value="3"
                                        {{ isset($answers['q20']) && $answers['q20'] == 3 ? 'checked' : '' }}>
                                    <label for="q20_3" class="italic">@lang('questionnaire-campaign.hais.neutral')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q20_4"
                                        name="q20" value="4"
                                        {{ isset($answers['q20']) && $answers['q20'] == 4 ? 'checked' : '' }}>
                                    <label for="q20_4" class="italic">@lang('questionnaire-campaign.hais.agree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q20_5"
                                        name="q20" value="5"
                                        {{ isset($answers['q20']) && $answers['q20'] == 5 ? 'checked' : '' }}>
                                    <label for="q20_5" class="italic">@lang('questionnaire-campaign.hais.stronglyAgree')</label>
                                </div>
                            </div>
                        </div>

                        <!-- Q21 -->
                        <div class="py-3 flex flex-col border-b-2">
                            <p class="text-center font-medium py-3">I download any files onto my work computer that
                                will
                                help me get the job done.</p>
                            <div class="flex flex-col md:flex-row items-top md:items-center w-full md:justify-around">
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q21_1"
                                        name="q21" value="1"
                                        {{ isset($answers['q21']) && $answers['q21'] == 1 ? 'checked' : '' }}>
                                    <label for="q21_1" class="italic">@lang('questionnaire-campaign.hais.stronglyAgree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q21_2"
                                        name="q21" value="2"
                                        {{ isset($answers['q21']) && $answers['q21'] == 2 ? 'checked' : '' }}>
                                    <label for="q21_2" class="italic">@lang('questionnaire-campaign.hais.agree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q21_3"
                                        name="q21" value="3"
                                        {{ isset($answers['q21']) && $answers['q21'] == 3 ? 'checked' : '' }}>
                                    <label for="q21_3" class="italic">@lang('questionnaire-campaign.hais.neutral')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q21_4"
                                        name="q21" value="4"
                                        {{ isset($answers['q21']) && $answers['q21'] == 4 ? 'checked' : '' }}>
                                    <label for="q21_4" class="italic">@lang('questionnaire-campaign.hais.disagree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q21_5"
                                        name="q21" value="5"
                                        {{ isset($answers['q21']) && $answers['q21'] == 5 ? 'checked' : '' }}>
                                    <label for="q21_5" class="italic">@lang('questionnaire-campaign.hais.stronglyDisagree')</label>
                                </div>
                            </div>
                        </div>

                        <p class="font-semibold text-center pt-4">Accessing dubious websites</p>

                        <!-- Q22 -->
                        <div class="py-3 flex flex-col border-b-2">
                            <p class="text-center font-medium py-3">While I am at work, I shouldn't access certain
                                websites.</p>
                            <div class="flex flex-col md:flex-row items-top md:items-center w-full md:justify-around">
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q22_1"
                                        name="q22" value="1"
                                        {{ isset($answers['q22']) && $answers['q22'] == 1 ? 'checked' : '' }}>
                                    <label for="q22_1" class="italic">@lang('questionnaire-campaign.hais.stronglyDisagree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q22_2"
                                        name="q22" value="2"
                                        {{ isset($answers['q22']) && $answers['q22'] == 2 ? 'checked' : '' }}>
                                    <label for="q22_2" class="italic">@lang('questionnaire-campaign.hais.disagree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q22_3"
                                        name="q22" value="3"
                                        {{ isset($answers['q22']) && $answers['q22'] == 3 ? 'checked' : '' }}>
                                    <label for="q22_3" class="italic">@lang('questionnaire-campaign.hais.neutral')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q22_4"
                                        name="q22" value="4"
                                        {{ isset($answers['q22']) && $answers['q22'] == 4 ? 'checked' : '' }}>
                                    <label for="q22_4" class="italic">@lang('questionnaire-campaign.hais.agree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q22_5"
                                        name="q22" value="5"
                                        {{ isset($answers['q22']) && $answers['q22'] == 5 ? 'checked' : '' }}>
                                    <label for="q22_5" class="italic">@lang('questionnaire-campaign.hais.stronglyAgree')</label>
                                </div>
                            </div>
                        </div>

                        <!-- Q23 -->
                        <div class="py-3 flex flex-col border-b-2">
                            <p class="text-center font-medium py-3">Just because I can access a website at work,
                                doesn't
                                mean that it's safe.</p>
                            <div class="flex flex-col md:flex-row items-top md:items-center w-full md:justify-around">
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q23_1"
                                        name="q23" value="1"
                                        {{ isset($answers['q23']) && $answers['q23'] == 1 ? 'checked' : '' }}>
                                    <label for="q23_1" class="italic">@lang('questionnaire-campaign.hais.stronglyDisagree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q23_2"
                                        name="q23" value="2"
                                        {{ isset($answers['q23']) && $answers['q23'] == 2 ? 'checked' : '' }}>
                                    <label for="q23_2" class="italic">@lang('questionnaire-campaign.hais.disagree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q23_3"
                                        name="q23" value="3"
                                        {{ isset($answers['q23']) && $answers['q23'] == 3 ? 'checked' : '' }}>
                                    <label for="q23_3" class="italic">@lang('questionnaire-campaign.hais.neutral')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q23_4"
                                        name="q23" value="4"
                                        {{ isset($answers['q23']) && $answers['q23'] == 4 ? 'checked' : '' }}>
                                    <label for="q23_4" class="italic">@lang('questionnaire-campaign.hais.agree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q23_5"
                                        name="q23" value="5"
                                        {{ isset($answers['q23']) && $answers['q23'] == 5 ? 'checked' : '' }}>
                                    <label for="q23_5" class="italic">@lang('questionnaire-campaign.hais.stronglyAgree')</label>
                                </div>
                            </div>
                        </div>

                        <!-- Q24 -->
                        <div class="py-3 flex flex-col border-b-2">
                            <p class="text-center font-medium py-3">When accessing the Internet at work, I visit any
                                website that I want to.</p>
                            <div
                                class="flex flex-col md:flex-row items-top md:items-center w-full md:justify-around">
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q24_1"
                                        name="q24" value="1"
                                        {{ isset($answers['q24']) && $answers['q24'] == 1 ? 'checked' : '' }}>
                                    <label for="q24_1" class="italic">@lang('questionnaire-campaign.hais.stronglyAgree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q24_2"
                                        name="q24" value="2"
                                        {{ isset($answers['q24']) && $answers['q24'] == 2 ? 'checked' : '' }}>
                                    <label for="q24_2" class="italic">@lang('questionnaire-campaign.hais.agree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q24_3"
                                        name="q24" value="3"
                                        {{ isset($answers['q24']) && $answers['q24'] == 3 ? 'checked' : '' }}>
                                    <label for="q24_3" class="italic">@lang('questionnaire-campaign.hais.neutral')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q24_4"
                                        name="q24" value="4"
                                        {{ isset($answers['q24']) && $answers['q24'] == 4 ? 'checked' : '' }}>
                                    <label for="q24_4" class="italic">@lang('questionnaire-campaign.hais.disagree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q24_5"
                                        name="q24" value="5"
                                        {{ isset($answers['q24']) && $answers['q24'] == 5 ? 'checked' : '' }}>
                                    <label for="q24_5" class="italic">@lang('questionnaire-campaign.hais.stronglyDisagree')</label>
                                </div>
                            </div>
                        </div>

                        <p class="font-semibold text-center pt-4">Entering information online</p>

                        <!-- Q25 -->
                        <div class="py-3 flex flex-col border-b-2">
                            <p class="text-center font-medium py-3">I am allowed to enter any information on any
                                website if
                                it helps me do my job.</p>
                            <div
                                class="flex flex-col md:flex-row items-top md:items-center w-full md:justify-around">
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q25_1"
                                        name="q25" value="1"
                                        {{ isset($answers['q25']) && $answers['q25'] == 1 ? 'checked' : '' }}>
                                    <label for="q25_1" class="italic">@lang('questionnaire-campaign.hais.stronglyAgree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q25_2"
                                        name="q25" value="2"
                                        {{ isset($answers['q25']) && $answers['q25'] == 2 ? 'checked' : '' }}>
                                    <label for="q25_2" class="italic">@lang('questionnaire-campaign.hais.agree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q25_3"
                                        name="q25" value="3"
                                        {{ isset($answers['q25']) && $answers['q25'] == 3 ? 'checked' : '' }}>
                                    <label for="q25_3" class="italic">@lang('questionnaire-campaign.hais.neutral')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q25_4"
                                        name="q25" value="4"
                                        {{ isset($answers['q25']) && $answers['q25'] == 4 ? 'checked' : '' }}>
                                    <label for="q25_4" class="italic">@lang('questionnaire-campaign.hais.disagree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q25_5"
                                        name="q25" value="5"
                                        {{ isset($answers['q25']) && $answers['q25'] == 5 ? 'checked' : '' }}>
                                    <label for="q25_5" class="italic">@lang('questionnaire-campaign.hais.stronglyDisagree')</label>
                                </div>
                            </div>
                        </div>

                        <!-- Q26 -->
                        <div class="py-3 flex flex-col border-b-2">
                            <p class="text-center font-medium py-3">If it helps me to do my job, it doesn't matter
                                what
                                information I put on a website.</p>
                            <div
                                class="flex flex-col md:flex-row items-top md:items-center w-full md:justify-around">
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q26_1"
                                        name="q26" value="1"
                                        {{ isset($answers['q26']) && $answers['q26'] == 1 ? 'checked' : '' }}>
                                    <label for="q26_1" class="italic">@lang('questionnaire-campaign.hais.stronglyAgree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q26_2"
                                        name="q26" value="2"
                                        {{ isset($answers['q26']) && $answers['q26'] == 2 ? 'checked' : '' }}>
                                    <label for="q26_2" class="italic">@lang('questionnaire-campaign.hais.agree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q26_3"
                                        name="q26" value="3"
                                        {{ isset($answers['q26']) && $answers['q26'] == 3 ? 'checked' : '' }}>
                                    <label for="q26_3" class="italic">@lang('questionnaire-campaign.hais.neutral')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q26_4"
                                        name="q26" value="4"
                                        {{ isset($answers['q26']) && $answers['q26'] == 4 ? 'checked' : '' }}>
                                    <label for="q26_4" class="italic">@lang('questionnaire-campaign.hais.disagree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q26_5"
                                        name="q26" value="5"
                                        {{ isset($answers['q26']) && $answers['q26'] == 5 ? 'checked' : '' }}>
                                    <label for="q26_5" class="italic">@lang('questionnaire-campaign.hais.stronglyDisagree')</label>
                                </div>
                            </div>
                        </div>

                        <!-- Q27 -->
                        <div class="py-3 flex flex-col border-b-2">
                            <p class="text-center font-medium py-3">I assess the safety of websites before entering
                                information.</p>
                            <div
                                class="flex flex-col md:flex-row items-top md:items-center w-full md:justify-around">
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q27_1"
                                        name="q27" value="1"
                                        {{ isset($answers['q27']) && $answers['q27'] == 1 ? 'checked' : '' }}>
                                    <label for="q27_1" class="italic">@lang('questionnaire-campaign.hais.stronglyDisagree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q27_2"
                                        name="q27" value="2"
                                        {{ isset($answers['q27']) && $answers['q27'] == 2 ? 'checked' : '' }}>
                                    <label for="q27_2" class="italic">@lang('questionnaire-campaign.hais.disagree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q27_3"
                                        name="q27" value="3"
                                        {{ isset($answers['q27']) && $answers['q27'] == 3 ? 'checked' : '' }}>
                                    <label for="q27_3" class="italic">@lang('questionnaire-campaign.hais.neutral')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q27_4"
                                        name="q27" value="4"
                                        {{ isset($answers['q27']) && $answers['q27'] == 4 ? 'checked' : '' }}>
                                    <label for="q27_4" class="italic">@lang('questionnaire-campaign.hais.agree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q27_5"
                                        name="q27" value="5"
                                        {{ isset($answers['q27']) && $answers['q27'] == 5 ? 'checked' : '' }}>
                                    <label for="q27_5" class="italic">@lang('questionnaire-campaign.hais.stronglyAgree')</label>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Focus area: Social media use -->
                    <div class="tab hidden">

                        <p class="italic font-semibold text-center pt-6">Focus area: Social media use</p>

                        <p class="font-semibold text-center pt-4">SM privacy settings</p>

                        <!-- Q28 -->
                        <div class="py-3 flex flex-col border-b-2">
                            <p class="text-center font-medium py-3">I must periodically review the privacy settings on
                                my
                                social media accounts.</p>
                            <div
                                class="flex flex-col md:flex-row items-top md:items-center w-full md:justify-around">
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q28_1"
                                        name="q28" value="1"
                                        {{ isset($answers['q28']) && $answers['q28'] == 1 ? 'checked' : '' }}>
                                    <label for="q28_1" class="italic">@lang('questionnaire-campaign.hais.stronglyDisagree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q28_2"
                                        name="q28" value="2"
                                        {{ isset($answers['q28']) && $answers['q28'] == 2 ? 'checked' : '' }}>
                                    <label for="q28_2" class="italic">@lang('questionnaire-campaign.hais.disagree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q28_3"
                                        name="q28" value="3"
                                        {{ isset($answers['q28']) && $answers['q28'] == 3 ? 'checked' : '' }}>
                                    <label for="q28_3" class="italic">@lang('questionnaire-campaign.hais.neutral')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q28_4"
                                        name="q28" value="4"
                                        {{ isset($answers['q28']) && $answers['q28'] == 4 ? 'checked' : '' }}>
                                    <label for="q28_4" class="italic">@lang('questionnaire-campaign.hais.agree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q28_5"
                                        name="q28" value="5"
                                        {{ isset($answers['q28']) && $answers['q28'] == 5 ? 'checked' : '' }}>
                                    <label for="q28_5" class="italic">@lang('questionnaire-campaign.hais.stronglyAgree')</label>
                                </div>
                            </div>
                        </div>

                        <!-- Q29 -->
                        <div class="py-3 flex flex-col border-b-2">
                            <p class="text-center font-medium py-3">It's a good idea to regularly review my social
                                media
                                privacy settings.</p>
                            <div
                                class="flex flex-col md:flex-row items-top md:items-center w-full md:justify-around">
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q29_1"
                                        name="q29" value="1"
                                        {{ isset($answers['q29']) && $answers['q29'] == 1 ? 'checked' : '' }}>
                                    <label for="q29_1" class="italic">@lang('questionnaire-campaign.hais.stronglyDisagree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q29_2"
                                        name="q29" value="2"
                                        {{ isset($answers['q29']) && $answers['q29'] == 2 ? 'checked' : '' }}>
                                    <label for="q29_2" class="italic">@lang('questionnaire-campaign.hais.disagree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q29_3"
                                        name="q29" value="3"
                                        {{ isset($answers['q29']) && $answers['q29'] == 3 ? 'checked' : '' }}>
                                    <label for="q29_3" class="italic">@lang('questionnaire-campaign.hais.neutral')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q29_4"
                                        name="q29" value="4"
                                        {{ isset($answers['q29']) && $answers['q29'] == 4 ? 'checked' : '' }}>
                                    <label for="q29_4" class="italic">@lang('questionnaire-campaign.hais.agree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q29_5"
                                        name="q29" value="5"
                                        {{ isset($answers['q29']) && $answers['q29'] == 5 ? 'checked' : '' }}>
                                    <label for="q29_5" class="italic">@lang('questionnaire-campaign.hais.stronglyAgree')</label>
                                </div>
                            </div>
                        </div>

                        <!-- Q30 -->
                        <div class="py-3 flex flex-col border-b-2">
                            <p class="text-center font-medium py-3">I don't regularly review my social media privacy
                                settings.</p>
                            <div
                                class="flex flex-col md:flex-row items-top md:items-center w-full md:justify-around">
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q30_1"
                                        name="q30" value="1"
                                        {{ isset($answers['q30']) && $answers['q30'] == 1 ? 'checked' : '' }}>
                                    <label for="q30_1" class="italic">@lang('questionnaire-campaign.hais.stronglyAgree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q30_2"
                                        name="q30" value="2"
                                        {{ isset($answers['q30']) && $answers['q30'] == 2 ? 'checked' : '' }}>
                                    <label for="q30_2" class="italic">@lang('questionnaire-campaign.hais.agree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q30_3"
                                        name="q30" value="3"
                                        {{ isset($answers['q30']) && $answers['q30'] == 3 ? 'checked' : '' }}>
                                    <label for="q30_3" class="italic">@lang('questionnaire-campaign.hais.neutral')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q30_4"
                                        name="q30" value="4"
                                        {{ isset($answers['q30']) && $answers['q30'] == 4 ? 'checked' : '' }}>
                                    <label for="q30_4" class="italic">@lang('questionnaire-campaign.hais.disagree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q30_5"
                                        name="q30" value="5"
                                        {{ isset($answers['q30']) && $answers['q30'] == 5 ? 'checked' : '' }}>
                                    <label for="q30_5" class="italic">@lang('questionnaire-campaign.hais.stronglyDisagree')</label>
                                </div>
                            </div>
                        </div>

                        <p class="font-semibold text-center pt-4">Considering consequences</p>

                        <!-- Q31 -->
                        <div class="py-3 flex flex-col border-b-2">
                            <p class="text-center font-medium py-3">I can't be fired for something I post on social
                                media.
                            </p>
                            <div
                                class="flex flex-col md:flex-row items-top md:items-center w-full md:justify-around">
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q31_1"
                                        name="q31" value="1"
                                        {{ isset($answers['q31']) && $answers['q31'] == 1 ? 'checked' : '' }}>
                                    <label for="q31_1" class="italic">@lang('questionnaire-campaign.hais.stronglyAgree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q31_2"
                                        name="q31" value="2"
                                        {{ isset($answers['q31']) && $answers['q31'] == 2 ? 'checked' : '' }}>
                                    <label for="q31_2" class="italic">@lang('questionnaire-campaign.hais.agree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q31_3"
                                        name="q31" value="3"
                                        {{ isset($answers['q31']) && $answers['q31'] == 3 ? 'checked' : '' }}>
                                    <label for="q31_3" class="italic">@lang('questionnaire-campaign.hais.neutral')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q31_4"
                                        name="q31" value="4"
                                        {{ isset($answers['q31']) && $answers['q31'] == 4 ? 'checked' : '' }}>
                                    <label for="q31_4" class="italic">@lang('questionnaire-campaign.hais.disagree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q31_5"
                                        name="q31" value="5"
                                        {{ isset($answers['q31']) && $answers['q31'] == 5 ? 'checked' : '' }}>
                                    <label for="q31_5" class="italic">@lang('questionnaire-campaign.hais.stronglyDisagree')</label>
                                </div>
                            </div>
                        </div>

                        <!-- Q32 -->
                        <div class="py-3 flex flex-col border-b-2">
                            <p class="text-center font-medium py-3">It doesn't matter if I post things on social media
                                that
                                I wouldn't normally say in public.</p>
                            <div
                                class="flex flex-col md:flex-row items-top md:items-center w-full md:justify-around">
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q32_1"
                                        name="q32" value="1"
                                        {{ isset($answers['q32']) && $answers['q32'] == 1 ? 'checked' : '' }}>
                                    <label for="q32_1" class="italic">@lang('questionnaire-campaign.hais.stronglyAgree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q32_2"
                                        name="q32" value="2"
                                        {{ isset($answers['q32']) && $answers['q32'] == 2 ? 'checked' : '' }}>
                                    <label for="q32_2" class="italic">@lang('questionnaire-campaign.hais.agree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q32_3"
                                        name="q32" value="3"
                                        {{ isset($answers['q32']) && $answers['q32'] == 3 ? 'checked' : '' }}>
                                    <label for="q32_3" class="italic">@lang('questionnaire-campaign.hais.neutral')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q32_4"
                                        name="q32" value="4"
                                        {{ isset($answers['q32']) && $answers['q32'] == 4 ? 'checked' : '' }}>
                                    <label for="q32_4" class="italic">@lang('questionnaire-campaign.hais.disagree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q32_5"
                                        name="q32" value="5"
                                        {{ isset($answers['q32']) && $answers['q32'] == 5 ? 'checked' : '' }}>
                                    <label for="q32_5" class="italic">@lang('questionnaire-campaign.hais.stronglyDisagree')</label>
                                </div>
                            </div>
                        </div>

                        <!-- Q33 -->
                        <div class="py-3 flex flex-col border-b-2">
                            <p class="text-center font-medium py-3">I don't post anything on social media before
                                considering any negative consequences.</p>
                            <div
                                class="flex flex-col md:flex-row items-top md:items-center w-full md:justify-around">
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q33_1"
                                        name="q33" value="1"
                                        {{ isset($answers['q33']) && $answers['q33'] == 1 ? 'checked' : '' }}>
                                    <label for="q33_1" class="italic">@lang('questionnaire-campaign.hais.stronglyDisagree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q33_2"
                                        name="q33" value="2"
                                        {{ isset($answers['q33']) && $answers['q33'] == 2 ? 'checked' : '' }}>
                                    <label for="q33_2" class="italic">@lang('questionnaire-campaign.hais.disagree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q33_3"
                                        name="q33" value="3"
                                        {{ isset($answers['q33']) && $answers['q33'] == 3 ? 'checked' : '' }}>
                                    <label for="q33_3" class="italic">@lang('questionnaire-campaign.hais.neutral')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q33_4"
                                        name="q33" value="4"
                                        {{ isset($answers['q33']) && $answers['q33'] == 4 ? 'checked' : '' }}>
                                    <label for="q33_4" class="italic">@lang('questionnaire-campaign.hais.agree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q33_5"
                                        name="q33" value="5"
                                        {{ isset($answers['q33']) && $answers['q33'] == 5 ? 'checked' : '' }}>
                                    <label for="q33_5" class="italic">@lang('questionnaire-campaign.hais.stronglyAgree')</label>
                                </div>
                            </div>
                        </div>

                        <p class="font-semibold text-center pt-4">Posting about work</p>

                        <!-- Q34 -->
                        <div class="py-3 flex flex-col border-b-2">
                            <p class="text-center font-medium py-3">I can post what I want about work on social media.
                            </p>
                            <div
                                class="flex flex-col md:flex-row items-top md:items-center w-full md:justify-around">
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q34_1"
                                        name="q34" value="1"
                                        {{ isset($answers['q34']) && $answers['q34'] == 1 ? 'checked' : '' }}>
                                    <label for="q34_1" class="italic">@lang('questionnaire-campaign.hais.stronglyAgree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q34_2"
                                        name="q34" value="2"
                                        {{ isset($answers['q34']) && $answers['q34'] == 2 ? 'checked' : '' }}>
                                    <label for="q34_2" class="italic">@lang('questionnaire-campaign.hais.agree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q34_3"
                                        name="q34" value="3"
                                        {{ isset($answers['q34']) && $answers['q34'] == 3 ? 'checked' : '' }}>
                                    <label for="q34_3" class="italic">@lang('questionnaire-campaign.hais.neutral')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q34_4"
                                        name="q34" value="4"
                                        {{ isset($answers['q34']) && $answers['q34'] == 4 ? 'checked' : '' }}>
                                    <label for="q34_4" class="italic">@lang('questionnaire-campaign.hais.disagree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q34_5"
                                        name="q34" value="5"
                                        {{ isset($answers['q34']) && $answers['q34'] == 5 ? 'checked' : '' }}>
                                    <label for="q34_5" class="italic">@lang('questionnaire-campaign.hais.stronglyDisagree')</label>
                                </div>
                            </div>
                        </div>

                        <!-- Q35 -->
                        <div class="py-3 flex flex-col border-b-2">
                            <p class="text-center font-medium py-3">It's risky to post certain information about my
                                work
                                on social media.</p>
                            <div
                                class="flex flex-col md:flex-row items-top md:items-center w-full md:justify-around">
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q35_1"
                                        name="q35" value="1"
                                        {{ isset($answers['q35']) && $answers['q35'] == 1 ? 'checked' : '' }}>
                                    <label for="q35_1" class="italic">@lang('questionnaire-campaign.hais.stronglyDisagree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q35_2"
                                        name="q35" value="2"
                                        {{ isset($answers['q35']) && $answers['q35'] == 2 ? 'checked' : '' }}>
                                    <label for="q35_2" class="italic">@lang('questionnaire-campaign.hais.disagree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q35_3"
                                        name="q35" value="3"
                                        {{ isset($answers['q35']) && $answers['q35'] == 3 ? 'checked' : '' }}>
                                    <label for="q35_3" class="italic">@lang('questionnaire-campaign.hais.neutral')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q35_4"
                                        name="q35" value="4"
                                        {{ isset($answers['q35']) && $answers['q35'] == 4 ? 'checked' : '' }}>
                                    <label for="q35_4" class="italic">@lang('questionnaire-campaign.hais.agree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q35_5"
                                        name="q35" value="5"
                                        {{ isset($answers['q35']) && $answers['q35'] == 5 ? 'checked' : '' }}>
                                    <label for="q35_5" class="italic">@lang('questionnaire-campaign.hais.stronglyAgree')</label>
                                </div>
                            </div>
                        </div>

                        <!-- Q36 -->
                        <div class="py-3 flex flex-col border-b-2">
                            <p class="text-center font-medium py-3">I post whatever I want about my work on social
                                media.
                            </p>
                            <div
                                class="flex flex-col md:flex-row items-top md:items-center w-full md:justify-around">
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q36_1"
                                        name="q36" value="1"
                                        {{ isset($answers['q36']) && $answers['q36'] == 1 ? 'checked' : '' }}>
                                    <label for="q36_1" class="italic">@lang('questionnaire-campaign.hais.stronglyAgree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q36_2"
                                        name="q36" value="2"
                                        {{ isset($answers['q36']) && $answers['q36'] == 2 ? 'checked' : '' }}>
                                    <label for="q36_2" class="italic">@lang('questionnaire-campaign.hais.agree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q36_3"
                                        name="q36" value="3"
                                        {{ isset($answers['q36']) && $answers['q36'] == 3 ? 'checked' : '' }}>
                                    <label for="q36_3" class="italic">@lang('questionnaire-campaign.hais.neutral')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q36_4"
                                        name="q36" value="4"
                                        {{ isset($answers['q36']) && $answers['q36'] == 4 ? 'checked' : '' }}>
                                    <label for="q36_4" class="italic">@lang('questionnaire-campaign.hais.disagree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q36_5"
                                        name="q36" value="5"
                                        {{ isset($answers['q36']) && $answers['q36'] == 5 ? 'checked' : '' }}>
                                    <label for="q36_5" class="italic">@lang('questionnaire-campaign.hais.stronglyDisagree')</label>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Focus area: Mobile devices -->
                    <div class="tab hidden">

                        <p class="italic font-semibold text-center pt-6">Focus area: Mobile devices</p>

                        <p class="font-semibold text-center pt-4">Physically securing mobile devices</p>

                        <!-- Q37 -->
                        <div class="py-3 flex flex-col border-b-2">
                            <p class="text-center font-medium py-3">When working in a public place, I have to keep my
                                laptop with me at all times.</p>
                            <div
                                class="flex flex-col md:flex-row items-top md:items-center w-full md:justify-around">
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q37_1"
                                        name="q37" value="1"
                                        {{ isset($answers['q37']) && $answers['q37'] == 1 ? 'checked' : '' }}>
                                    <label for="q37_1" class="italic">@lang('questionnaire-campaign.hais.stronglyDisagree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q37_2"
                                        name="q37" value="2"
                                        {{ isset($answers['q37']) && $answers['q37'] == 2 ? 'checked' : '' }}>
                                    <label for="q37_2" class="italic">@lang('questionnaire-campaign.hais.disagree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q37_3"
                                        name="q37" value="3"
                                        {{ isset($answers['q37']) && $answers['q37'] == 3 ? 'checked' : '' }}>
                                    <label for="q37_3" class="italic">@lang('questionnaire-campaign.hais.neutral')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q37_4"
                                        name="q37" value="4"
                                        {{ isset($answers['q37']) && $answers['q37'] == 4 ? 'checked' : '' }}>
                                    <label for="q37_4" class="italic">@lang('questionnaire-campaign.hais.agree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q37_5"
                                        name="q37" value="5"
                                        {{ isset($answers['q37']) && $answers['q37'] == 5 ? 'checked' : '' }}>
                                    <label for="q37_5" class="italic">@lang('questionnaire-campaign.hais.stronglyAgree')</label>
                                </div>
                            </div>
                        </div>

                        <!-- Q38 -->
                        <div class="py-3 flex flex-col border-b-2">
                            <p class="text-center font-medium py-3">When working in a café, it's safe to leave my
                                laptop
                                unattended for a minute.</p>
                            <div
                                class="flex flex-col md:flex-row items-top md:items-center w-full md:justify-around">
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q38_1"
                                        name="q38" value="1"
                                        {{ isset($answers['q38']) && $answers['q38'] == 1 ? 'checked' : '' }}>
                                    <label for="q38_1" class="italic">@lang('questionnaire-campaign.hais.stronglyAgree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q38_2"
                                        name="q38" value="2"
                                        {{ isset($answers['q38']) && $answers['q38'] == 2 ? 'checked' : '' }}>
                                    <label for="q38_2" class="italic">@lang('questionnaire-campaign.hais.agree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q38_3"
                                        name="q38" value="3"
                                        {{ isset($answers['q38']) && $answers['q38'] == 3 ? 'checked' : '' }}>
                                    <label for="q38_3" class="italic">@lang('questionnaire-campaign.hais.neutral')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q38_4"
                                        name="q38" value="4"
                                        {{ isset($answers['q38']) && $answers['q38'] == 4 ? 'checked' : '' }}>
                                    <label for="q38_4" class="italic">@lang('questionnaire-campaign.hais.disagree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q38_5"
                                        name="q38" value="5"
                                        {{ isset($answers['q38']) && $answers['q38'] == 5 ? 'checked' : '' }}>
                                    <label for="q38_5" class="italic">@lang('questionnaire-campaign.hais.stronglyDisagree')</label>
                                </div>
                            </div>
                        </div>

                        <!-- Q39 -->
                        <div class="py-3 flex flex-col border-b-2">
                            <p class="text-center font-medium py-3">When working in a public place, I leave my laptop
                                unattended.</p>
                            <div
                                class="flex flex-col md:flex-row items-top md:items-center w-full md:justify-around">
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q39_1"
                                        name="q39" value="1"
                                        {{ isset($answers['q39']) && $answers['q39'] == 1 ? 'checked' : '' }}>
                                    <label for="q39_1" class="italic">@lang('questionnaire-campaign.hais.stronglyAgree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q39_2"
                                        name="q39" value="2"
                                        {{ isset($answers['q39']) && $answers['q39'] == 2 ? 'checked' : '' }}>
                                    <label for="q39_2" class="italic">@lang('questionnaire-campaign.hais.agree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q39_3"
                                        name="q39" value="3"
                                        {{ isset($answers['q39']) && $answers['q39'] == 3 ? 'checked' : '' }}>
                                    <label for="q39_3" class="italic">@lang('questionnaire-campaign.hais.neutral')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q39_4"
                                        name="q39" value="4"
                                        {{ isset($answers['q39']) && $answers['q39'] == 4 ? 'checked' : '' }}>
                                    <label for="q39_4" class="italic">@lang('questionnaire-campaign.hais.disagree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q39_5"
                                        name="q39" value="5"
                                        {{ isset($answers['q39']) && $answers['q39'] == 5 ? 'checked' : '' }}>
                                    <label for="q39_5" class="italic">@lang('questionnaire-campaign.hais.stronglyDisagree')</label>
                                </div>
                            </div>
                        </div>

                        <p class="font-semibold text-center pt-4">Sending sensitive information via Wi-Fi
                        </p>

                        <!-- Q40 -->
                        <div class="py-3 flex flex-col border-b-2">
                            <p class="text-center font-medium py-3">I am allowed to send sensitive work files via a
                                public
                                Wi-Fi network.</p>
                            <div
                                class="flex flex-col md:flex-row items-top md:items-center w-full md:justify-around">
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q40_1"
                                        name="q40" value="1"
                                        {{ isset($answers['q40']) && $answers['q40'] == 1 ? 'checked' : '' }}>
                                    <label for="q40_1" class="italic">@lang('questionnaire-campaign.hais.stronglyAgree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q40_2"
                                        name="q40" value="2"
                                        {{ isset($answers['q40']) && $answers['q40'] == 2 ? 'checked' : '' }}>
                                    <label for="q40_2" class="italic">@lang('questionnaire-campaign.hais.agree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q40_3"
                                        name="q40" value="3"
                                        {{ isset($answers['q40']) && $answers['q40'] == 3 ? 'checked' : '' }}>
                                    <label for="q40_3" class="italic">@lang('questionnaire-campaign.hais.neutral')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q40_4"
                                        name="q40" value="4"
                                        {{ isset($answers['q40']) && $answers['q40'] == 4 ? 'checked' : '' }}>
                                    <label for="q40_4" class="italic">@lang('questionnaire-campaign.hais.disagree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q40_5"
                                        name="q40" value="5"
                                        {{ isset($answers['q40']) && $answers['q40'] == 5 ? 'checked' : '' }}>
                                    <label for="q40_5" class="italic">@lang('questionnaire-campaign.hais.stronglyDisagree')</label>
                                </div>
                            </div>
                        </div>

                        <!-- Q41 -->
                        <div class="py-3 flex flex-col border-b-2">
                            <p class="text-center font-medium py-3">It's risky to send sensitive work files using a
                                public
                                Wi-Fi network.</p>
                            <div
                                class="flex flex-col md:flex-row items-top md:items-center w-full md:justify-around">
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q41_1"
                                        name="q41" value="1"
                                        {{ isset($answers['q41']) && $answers['q41'] == 1 ? 'checked' : '' }}>
                                    <label for="q41_1" class="italic">@lang('questionnaire-campaign.hais.stronglyDisagree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q41_2"
                                        name="q41" value="2"
                                        {{ isset($answers['q41']) && $answers['q41'] == 2 ? 'checked' : '' }}>
                                    <label for="q41_2" class="italic">@lang('questionnaire-campaign.hais.disagree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q41_3"
                                        name="q41" value="3"
                                        {{ isset($answers['q41']) && $answers['q41'] == 3 ? 'checked' : '' }}>
                                    <label for="q41_3" class="italic">@lang('questionnaire-campaign.hais.neutral')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q41_4"
                                        name="q41" value="4"
                                        {{ isset($answers['q41']) && $answers['q41'] == 4 ? 'checked' : '' }}>
                                    <label for="q41_4" class="italic">@lang('questionnaire-campaign.hais.agree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q41_5"
                                        name="q41" value="5"
                                        {{ isset($answers['q41']) && $answers['q41'] == 5 ? 'checked' : '' }}>
                                    <label for="q41_5" class="italic">@lang('questionnaire-campaign.hais.stronglyAgree')</label>
                                </div>
                            </div>
                        </div>

                        <!-- Q42 -->
                        <div class="py-3 flex flex-col border-b-2">
                            <p class="text-center font-medium py-3">I send sensitive work files using a public Wi-Fi
                                network.</p>
                            <div
                                class="flex flex-col md:flex-row items-top md:items-center w-full md:justify-around">
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q42_1"
                                        name="q42" value="1"
                                        {{ isset($answers['q42']) && $answers['q42'] == 1 ? 'checked' : '' }}>
                                    <label for="q42_1" class="italic">@lang('questionnaire-campaign.hais.stronglyAgree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q42_2"
                                        name="q42" value="2"
                                        {{ isset($answers['q42']) && $answers['q42'] == 2 ? 'checked' : '' }}>
                                    <label for="q42_2" class="italic">@lang('questionnaire-campaign.hais.agree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q42_3"
                                        name="q42" value="3"
                                        {{ isset($answers['q42']) && $answers['q42'] == 3 ? 'checked' : '' }}>
                                    <label for="q42_3" class="italic">@lang('questionnaire-campaign.hais.neutral')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q42_4"
                                        name="q42" value="4"
                                        {{ isset($answers['q42']) && $answers['q42'] == 4 ? 'checked' : '' }}>
                                    <label for="q42_4" class="italic">@lang('questionnaire-campaign.hais.disagree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q42_5"
                                        name="q42" value="5"
                                        {{ isset($answers['q42']) && $answers['q42'] == 5 ? 'checked' : '' }}>
                                    <label for="q42_5" class="italic">@lang('questionnaire-campaign.hais.stronglyDisagree')</label>
                                </div>
                            </div>
                        </div>

                        <p class="font-semibold text-center pt-4">Shoulder surfing</p>

                        <!-- Q43 -->
                        <div class="py-3 flex flex-col border-b-2">
                            <p class="text-center font-medium py-3">When working on a sensitive document, I must
                                ensure
                                that strangers can't see my laptop screen.</p>
                            <div
                                class="flex flex-col md:flex-row items-top md:items-center w-full md:justify-around">
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q43_1"
                                        name="q43" value="1"
                                        {{ isset($answers['q43']) && $answers['q43'] == 1 ? 'checked' : '' }}>
                                    <label for="q43_1" class="italic">@lang('questionnaire-campaign.hais.stronglyDisagree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q43_2"
                                        name="q43" value="2"
                                        {{ isset($answers['q43']) && $answers['q43'] == 2 ? 'checked' : '' }}>
                                    <label for="q43_2" class="italic">@lang('questionnaire-campaign.hais.disagree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q43_3"
                                        name="q43" value="3"
                                        {{ isset($answers['q43']) && $answers['q43'] == 3 ? 'checked' : '' }}>
                                    <label for="q43_3" class="italic">@lang('questionnaire-campaign.hais.neutral')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q43_4"
                                        name="q43" value="4"
                                        {{ isset($answers['q43']) && $answers['q43'] == 4 ? 'checked' : '' }}>
                                    <label for="q43_4" class="italic">@lang('questionnaire-campaign.hais.agree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q43_5"
                                        name="q43" value="5"
                                        {{ isset($answers['q43']) && $answers['q43'] == 5 ? 'checked' : '' }}>
                                    <label for="q43_5" class="italic">@lang('questionnaire-campaign.hais.stronglyAgree')</label>
                                </div>
                            </div>
                        </div>

                        <!-- Q44 -->
                        <div class="py-3 flex flex-col border-b-2">
                            <p class="text-center font-medium py-3">It's risky to access sensitive work files on a
                                laptop
                                if strangers can see my screen.</p>
                            <div
                                class="flex flex-col md:flex-row items-top md:items-center w-full md:justify-around">
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q44_1"
                                        name="q44" value="1"
                                        {{ isset($answers['q44']) && $answers['q44'] == 1 ? 'checked' : '' }}>
                                    <label for="q44_1" class="italic">@lang('questionnaire-campaign.hais.stronglyDisagree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q44_2"
                                        name="q44" value="2"
                                        {{ isset($answers['q44']) && $answers['q44'] == 2 ? 'checked' : '' }}>
                                    <label for="q44_2" class="italic">@lang('questionnaire-campaign.hais.disagree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q44_3"
                                        name="q44" value="3"
                                        {{ isset($answers['q44']) && $answers['q44'] == 3 ? 'checked' : '' }}>
                                    <label for="q44_3" class="italic">@lang('questionnaire-campaign.hais.neutral')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q44_4"
                                        name="q44" value="4"
                                        {{ isset($answers['q44']) && $answers['q44'] == 4 ? 'checked' : '' }}>
                                    <label for="q44_4" class="italic">@lang('questionnaire-campaign.hais.agree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q44_5"
                                        name="q44" value="5"
                                        {{ isset($answers['q44']) && $answers['q44'] == 5 ? 'checked' : '' }}>
                                    <label for="q44_5" class="italic">@lang('questionnaire-campaign.hais.stronglyAgree')</label>
                                </div>
                            </div>
                        </div>

                        <!-- Q45 -->
                        <div class="py-3 flex flex-col border-b-2">
                            <p class="text-center font-medium py-3">I check that strangers can't see my laptop screen
                                if
                                I'm working on a sensitive document.</p>
                            <div
                                class="flex flex-col md:flex-row items-top md:items-center w-full md:justify-around">
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q45_1"
                                        name="q45" value="1"
                                        {{ isset($answers['q45']) && $answers['q45'] == 1 ? 'checked' : '' }}>
                                    <label for="q45_1" class="italic">@lang('questionnaire-campaign.hais.stronglyDisagree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q45_2"
                                        name="q45" value="2"
                                        {{ isset($answers['q45']) && $answers['q45'] == 2 ? 'checked' : '' }}>
                                    <label for="q45_2" class="italic">@lang('questionnaire-campaign.hais.disagree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q45_3"
                                        name="q45" value="3"
                                        {{ isset($answers['q45']) && $answers['q45'] == 3 ? 'checked' : '' }}>
                                    <label for="q45_3" class="italic">@lang('questionnaire-campaign.hais.neutral')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q45_4"
                                        name="q45" value="4"
                                        {{ isset($answers['q45']) && $answers['q45'] == 4 ? 'checked' : '' }}>
                                    <label for="q45_4" class="italic">@lang('questionnaire-campaign.hais.agree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q45_5"
                                        name="q45" value="5"
                                        {{ isset($answers['q45']) && $answers['q45'] == 5 ? 'checked' : '' }}>
                                    <label for="q45_5" class="italic">@lang('questionnaire-campaign.hais.stronglyAgree')</label>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Focus area: Information handling -->
                    <div class="tab hidden">

                        <p class="italic font-semibold text-center pt-6">Focus area: Information handling
                        </p>

                        <p class="font-semibold text-center pt-4">Disposing of sensitive print-outs</p>

                        <!-- Q46 -->
                        <div class="py-3 flex flex-col border-b-2">
                            <p class="text-center font-medium py-3">Sensitive print-outs can be disposed of in the
                                same
                                way as non-sensitive ones.</p>
                            <div
                                class="flex flex-col md:flex-row items-top md:items-center w-full md:justify-around">
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q46_1"
                                        name="q46" value="1"
                                        {{ isset($answers['q46']) && $answers['q46'] == 1 ? 'checked' : '' }}>
                                    <label for="q46_1" class="italic">@lang('questionnaire-campaign.hais.stronglyAgree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q46_2"
                                        name="q46" value="2"
                                        {{ isset($answers['q46']) && $answers['q46'] == 2 ? 'checked' : '' }}>
                                    <label for="q46_2" class="italic">@lang('questionnaire-campaign.hais.agree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q46_3"
                                        name="q46" value="3"
                                        {{ isset($answers['q46']) && $answers['q46'] == 3 ? 'checked' : '' }}>
                                    <label for="q46_3" class="italic">@lang('questionnaire-campaign.hais.neutral')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q46_4"
                                        name="q46" value="4"
                                        {{ isset($answers['q46']) && $answers['q46'] == 4 ? 'checked' : '' }}>
                                    <label for="q46_4" class="italic">@lang('questionnaire-campaign.hais.disagree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q46_5"
                                        name="q46" value="5"
                                        {{ isset($answers['q46']) && $answers['q46'] == 5 ? 'checked' : '' }}>
                                    <label for="q46_5" class="italic">@lang('questionnaire-campaign.hais.stronglyDisagree')</label>
                                </div>
                            </div>
                        </div>

                        <!-- Q47 -->
                        <div class="py-3 flex flex-col border-b-2">
                            <p class="text-center font-medium py-3">Disposing of sensitive print-outs by putting them
                                in
                                the rubbish bin is safe.</p>
                            <div
                                class="flex flex-col md:flex-row items-top md:items-center w-full md:justify-around">
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q47_1"
                                        name="q47" value="1"
                                        {{ isset($answers['q47']) && $answers['q47'] == 1 ? 'checked' : '' }}>
                                    <label for="q47_1" class="italic">@lang('questionnaire-campaign.hais.stronglyAgree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q47_2"
                                        name="q47" value="2"
                                        {{ isset($answers['q47']) && $answers['q47'] == 2 ? 'checked' : '' }}>
                                    <label for="q47_2" class="italic">@lang('questionnaire-campaign.hais.agree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q47_3"
                                        name="q47" value="3"
                                        {{ isset($answers['q47']) && $answers['q47'] == 3 ? 'checked' : '' }}>
                                    <label for="q47_3" class="italic">@lang('questionnaire-campaign.hais.neutral')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q47_4"
                                        name="q47" value="4"
                                        {{ isset($answers['q47']) && $answers['q47'] == 4 ? 'checked' : '' }}>
                                    <label for="q47_4" class="italic">@lang('questionnaire-campaign.hais.disagree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q47_5"
                                        name="q47" value="5"
                                        {{ isset($answers['q47']) && $answers['q47'] == 5 ? 'checked' : '' }}>
                                    <label for="q47_5" class="italic">@lang('questionnaire-campaign.hais.stronglyDisagree')</label>
                                </div>
                            </div>
                        </div>

                        <!-- Q48 -->
                        <div class="py-3 flex flex-col border-b-2">
                            <p class="text-center font-medium py-3">When sensitive print-outs need to be disposed of,
                                I
                                ensure that they are shredded or destroyed.</p>
                            <div
                                class="flex flex-col md:flex-row items-top md:items-center w-full md:justify-around">
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q48_1"
                                        name="q48" value="1"
                                        {{ isset($answers['q48']) && $answers['q48'] == 1 ? 'checked' : '' }}>
                                    <label for="q48_1" class="italic">@lang('questionnaire-campaign.hais.stronglyDisagree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q48_2"
                                        name="q48" value="2"
                                        {{ isset($answers['q48']) && $answers['q48'] == 2 ? 'checked' : '' }}>
                                    <label for="q48_2" class="italic">@lang('questionnaire-campaign.hais.disagree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q48_3"
                                        name="q48" value="3"
                                        {{ isset($answers['q48']) && $answers['q48'] == 3 ? 'checked' : '' }}>
                                    <label for="q48_3" class="italic">@lang('questionnaire-campaign.hais.neutral')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q48_4"
                                        name="q48" value="4"
                                        {{ isset($answers['q48']) && $answers['q48'] == 4 ? 'checked' : '' }}>
                                    <label for="q48_4" class="italic">@lang('questionnaire-campaign.hais.agree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q48_5"
                                        name="q48" value="5"
                                        {{ isset($answers['q48']) && $answers['q48'] == 5 ? 'checked' : '' }}>
                                    <label for="q48_5" class="italic">@lang('questionnaire-campaign.hais.stronglyAgree')</label>
                                </div>
                            </div>
                        </div>

                        <p class="font-semibold text-center pt-4">Inserting removable media</p>

                        <!-- Q49 -->
                        <div class="py-3 flex flex-col border-b-2">
                            <p class="text-center font-medium py-3">If I find a USB stick in a public place, I
                                shouldn't
                                plug it into my work computer.</p>
                            <div
                                class="flex flex-col md:flex-row items-top md:items-center w-full md:justify-around">
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q49_1"
                                        name="q49" value="1"
                                        {{ isset($answers['q49']) && $answers['q49'] == 1 ? 'checked' : '' }}>
                                    <label for="q49_1" class="italic">@lang('questionnaire-campaign.hais.stronglyDisagree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q49_2"
                                        name="q49" value="2"
                                        {{ isset($answers['q49']) && $answers['q49'] == 2 ? 'checked' : '' }}>
                                    <label for="q49_2" class="italic">@lang('questionnaire-campaign.hais.disagree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q49_3"
                                        name="q49" value="3"
                                        {{ isset($answers['q49']) && $answers['q49'] == 3 ? 'checked' : '' }}>
                                    <label for="q49_3" class="italic">@lang('questionnaire-campaign.hais.neutral')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q49_4"
                                        name="q49" value="4"
                                        {{ isset($answers['q49']) && $answers['q49'] == 4 ? 'checked' : '' }}>
                                    <label for="q49_4" class="italic">@lang('questionnaire-campaign.hais.agree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q49_5"
                                        name="q49" value="5"
                                        {{ isset($answers['q49']) && $answers['q49'] == 5 ? 'checked' : '' }}>
                                    <label for="q49_5" class="italic">@lang('questionnaire-campaign.hais.stronglyAgree')</label>
                                </div>
                            </div>
                        </div>

                        <!-- Q50 -->
                        <div class="py-3 flex flex-col border-b-2">
                            <p class="text-center font-medium py-3">If I find a USB stick in a public place, nothing
                                bad
                                can happen if I plug it into my work computer.</p>
                            <div
                                class="flex flex-col md:flex-row items-top md:items-center w-full md:justify-around">
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q50_1"
                                        name="q50" value="1"
                                        {{ isset($answers['q50']) && $answers['q50'] == 1 ? 'checked' : '' }}>
                                    <label for="q50_1" class="italic">@lang('questionnaire-campaign.hais.stronglyAgree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q50_2"
                                        name="q50" value="2"
                                        {{ isset($answers['q50']) && $answers['q50'] == 2 ? 'checked' : '' }}>
                                    <label for="q50_2" class="italic">@lang('questionnaire-campaign.hais.agree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q50_3"
                                        name="q50" value="3"
                                        {{ isset($answers['q50']) && $answers['q50'] == 3 ? 'checked' : '' }}>
                                    <label for="q50_3" class="italic">@lang('questionnaire-campaign.hais.neutral')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q50_4"
                                        name="q50" value="4"
                                        {{ isset($answers['q50']) && $answers['q50'] == 4 ? 'checked' : '' }}>
                                    <label for="q50_4" class="italic">@lang('questionnaire-campaign.hais.disagree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q50_5"
                                        name="q50" value="5"
                                        {{ isset($answers['q50']) && $answers['q50'] == 5 ? 'checked' : '' }}>
                                    <label for="q50_5" class="italic">@lang('questionnaire-campaign.hais.stronglyDisagree')</label>
                                </div>
                            </div>
                        </div>

                        <!-- Q51 -->
                        <div class="py-3 flex flex-col border-b-2">
                            <p class="text-center font-medium py-3">I wouldn't plug a USB stick found in a public
                                place
                                into my work computer.</p>
                            <div
                                class="flex flex-col md:flex-row items-top md:items-center w-full md:justify-around">
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q51_1"
                                        name="q51" value="1"
                                        {{ isset($answers['q51']) && $answers['q51'] == 1 ? 'checked' : '' }}>
                                    <label for="q51_1" class="italic">@lang('questionnaire-campaign.hais.stronglyDisagree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q51_2"
                                        name="q51" value="2"
                                        {{ isset($answers['q51']) && $answers['q51'] == 2 ? 'checked' : '' }}>
                                    <label for="q51_2" class="italic">@lang('questionnaire-campaign.hais.disagree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q51_3"
                                        name="q51" value="3"
                                        {{ isset($answers['q51']) && $answers['q51'] == 3 ? 'checked' : '' }}>
                                    <label for="q51_3" class="italic">@lang('questionnaire-campaign.hais.neutral')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q51_4"
                                        name="q51" value="4"
                                        {{ isset($answers['q51']) && $answers['q51'] == 4 ? 'checked' : '' }}>
                                    <label for="q51_4" class="italic">@lang('questionnaire-campaign.hais.agree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q51_5"
                                        name="q51" value="5"
                                        {{ isset($answers['q51']) && $answers['q51'] == 5 ? 'checked' : '' }}>
                                    <label for="q51_5" class="italic">@lang('questionnaire-campaign.hais.stronglyAgree')</label>
                                </div>
                            </div>
                        </div>

                        <p class="font-semibold text-center pt-4">Leaving sensitive material</p>

                        <!-- Q52 -->
                        <div class="py-3 flex flex-col border-b-2">
                            <p class="text-center font-medium py-3">I am allowed to leave print-outs containing
                                sensitive
                                information on my desk overnight.</p>
                            <div
                                class="flex flex-col md:flex-row items-top md:items-center w-full md:justify-around">
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q52_1"
                                        name="q52" value="1"
                                        {{ isset($answers['q52']) && $answers['q52'] == 1 ? 'checked' : '' }}>
                                    <label for="q52_1" class="italic">@lang('questionnaire-campaign.hais.stronglyAgree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q52_2"
                                        name="q52" value="2"
                                        {{ isset($answers['q52']) && $answers['q52'] == 2 ? 'checked' : '' }}>
                                    <label for="q52_2" class="italic">@lang('questionnaire-campaign.hais.agree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q52_3"
                                        name="q52" value="3"
                                        {{ isset($answers['q52']) && $answers['q52'] == 3 ? 'checked' : '' }}>
                                    <label for="q52_3" class="italic">@lang('questionnaire-campaign.hais.neutral')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q52_4"
                                        name="q52" value="4"
                                        {{ isset($answers['q52']) && $answers['q52'] == 4 ? 'checked' : '' }}>
                                    <label for="q52_4" class="italic">@lang('questionnaire-campaign.hais.disagree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q52_5"
                                        name="q52" value="5"
                                        {{ isset($answers['q52']) && $answers['q52'] == 5 ? 'checked' : '' }}>
                                    <label for="q52_5" class="italic">@lang('questionnaire-campaign.hais.stronglyDisagree')</label>
                                </div>
                            </div>
                        </div>

                        <!-- Q53 -->
                        <div class="py-3 flex flex-col border-b-2">
                            <p class="text-center font-medium py-3">It's risky to leave print-outs that contain
                                sensitive
                                information on my desk overnight.</p>
                            <div
                                class="flex flex-col md:flex-row items-top md:items-center w-full md:justify-around">
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q53_1"
                                        name="q53" value="1"
                                        {{ isset($answers['q53']) && $answers['q53'] == 1 ? 'checked' : '' }}>
                                    <label for="q53_1" class="italic">@lang('questionnaire-campaign.hais.stronglyDisagree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q53_2"
                                        name="q53" value="2"
                                        {{ isset($answers['q53']) && $answers['q53'] == 2 ? 'checked' : '' }}>
                                    <label for="q53_2" class="italic">@lang('questionnaire-campaign.hais.disagree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q53_3"
                                        name="q53" value="3"
                                        {{ isset($answers['q53']) && $answers['q53'] == 3 ? 'checked' : '' }}>
                                    <label for="q53_3" class="italic">@lang('questionnaire-campaign.hais.neutral')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q53_4"
                                        name="q53" value="4"
                                        {{ isset($answers['q53']) && $answers['q53'] == 4 ? 'checked' : '' }}>
                                    <label for="q53_4" class="italic">@lang('questionnaire-campaign.hais.agree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q53_5"
                                        name="q53" value="5"
                                        {{ isset($answers['q53']) && $answers['q53'] == 5 ? 'checked' : '' }}>
                                    <label for="q53_5" class="italic">@lang('questionnaire-campaign.hais.stronglyAgree')</label>
                                </div>
                            </div>
                        </div>

                        <!-- Q54 -->
                        <div class="py-3 flex flex-col border-b-2">
                            <p class="text-center font-medium py-3">I leave print-outs that contain sensitive
                                information
                                on my desk when I'm not there.</p>
                            <div
                                class="flex flex-col md:flex-row items-top md:items-center w-full md:justify-around">
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q54_1"
                                        name="q54" value="1"
                                        {{ isset($answers['q54']) && $answers['q54'] == 1 ? 'checked' : '' }}>
                                    <label for="q54_1" class="italic">@lang('questionnaire-campaign.hais.stronglyAgree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q54_2"
                                        name="q54" value="2"
                                        {{ isset($answers['q54']) && $answers['q54'] == 2 ? 'checked' : '' }}>
                                    <label for="q54_2" class="italic">@lang('questionnaire-campaign.hais.agree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q54_3"
                                        name="q54" value="3"
                                        {{ isset($answers['q54']) && $answers['q54'] == 3 ? 'checked' : '' }}>
                                    <label for="q54_3" class="italic">@lang('questionnaire-campaign.hais.neutral')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q54_4"
                                        name="q54" value="4"
                                        {{ isset($answers['q54']) && $answers['q54'] == 4 ? 'checked' : '' }}>
                                    <label for="q54_4" class="italic">@lang('questionnaire-campaign.hais.disagree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q54_5"
                                        name="q54" value="5"
                                        {{ isset($answers['q54']) && $answers['q54'] == 5 ? 'checked' : '' }}>
                                    <label for="q54_5" class="italic">@lang('questionnaire-campaign.hais.stronglyDisagree')</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Focus area: Incident reporting -->
                    <div class="tab hidden">

                        <p class="italic font-semibold text-center pt-6">Focus area: Incident reporting
                        </p>

                        <p class="font-semibold text-center pt-4">Reporting suspecious behavior</p>

                        <!-- Q55 -->
                        <div class="py-3 flex flex-col border-b-2">
                            <p class="text-center font-medium py-3">If I see someone acting suspiciously in my
                                workplace,
                                I should report it.</p>
                            <div
                                class="flex flex-col md:flex-row items-top md:items-center w-full md:justify-around">
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q55_1"
                                        name="q55" value="1"
                                        {{ isset($answers['q55']) && $answers['q55'] == 1 ? 'checked' : '' }}>
                                    <label for="q55_1" class="italic">@lang('questionnaire-campaign.hais.stronglyDisagree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q55_2"
                                        name="q55" value="2"
                                        {{ isset($answers['q55']) && $answers['q55'] == 2 ? 'checked' : '' }}>
                                    <label for="q55_2" class="italic">@lang('questionnaire-campaign.hais.disagree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q55_3"
                                        name="q55" value="3"
                                        {{ isset($answers['q55']) && $answers['q55'] == 3 ? 'checked' : '' }}>
                                    <label for="q55_3" class="italic">@lang('questionnaire-campaign.hais.neutral')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q55_4"
                                        name="q55" value="4"
                                        {{ isset($answers['q55']) && $answers['q55'] == 4 ? 'checked' : '' }}>
                                    <label for="q55_4" class="italic">@lang('questionnaire-campaign.hais.agree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q55_5"
                                        name="q55" value="5"
                                        {{ isset($answers['q55']) && $answers['q55'] == 5 ? 'checked' : '' }}>
                                    <label for="q55_5" class="italic">@lang('questionnaire-campaign.hais.stronglyAgree')</label>
                                </div>
                            </div>
                        </div>

                        <!-- Q56 -->
                        <div class="py-3 flex flex-col border-b-2">
                            <p class="text-center font-medium py-3">If I ignore someone acting suspiciously in my
                                workplace, nothing bad can happen.</p>
                            <div
                                class="flex flex-col md:flex-row items-top md:items-center w-full md:justify-around">
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q56_1"
                                        name="q56" value="1"
                                        {{ isset($answers['q56']) && $answers['q56'] == 1 ? 'checked' : '' }}>
                                    <label for="q56_1" class="italic">@lang('questionnaire-campaign.hais.stronglyAgree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q56_2"
                                        name="q56" value="2"
                                        {{ isset($answers['q56']) && $answers['q56'] == 2 ? 'checked' : '' }}>
                                    <label for="q56_2" class="italic">@lang('questionnaire-campaign.hais.agree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q56_3"
                                        name="q56" value="3"
                                        {{ isset($answers['q56']) && $answers['q56'] == 3 ? 'checked' : '' }}>
                                    <label for="q56_3" class="italic">@lang('questionnaire-campaign.hais.neutral')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q56_4"
                                        name="q56" value="4"
                                        {{ isset($answers['q56']) && $answers['q56'] == 4 ? 'checked' : '' }}>
                                    <label for="q56_4" class="italic">@lang('questionnaire-campaign.hais.disagree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q56_5"
                                        name="q56" value="5"
                                        {{ isset($answers['q56']) && $answers['q56'] == 5 ? 'checked' : '' }}>
                                    <label for="q56_5" class="italic">@lang('questionnaire-campaign.hais.stronglyDisagree')</label>
                                </div>
                            </div>
                        </div>

                        <!-- Q57 -->
                        <div class="py-3 flex flex-col border-b-2">
                            <p class="text-center font-medium py-3">If I saw someone acting suspiciously in my
                                workplace,
                                I would do something about it.</p>
                            <div
                                class="flex flex-col md:flex-row items-top md:items-center w-full md:justify-around">
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q57_1"
                                        name="q57" value="1"
                                        {{ isset($answers['q57']) && $answers['q57'] == 1 ? 'checked' : '' }}>
                                    <label for="q57_1" class="italic">@lang('questionnaire-campaign.hais.stronglyDisagree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q57_2"
                                        name="q57" value="2"
                                        {{ isset($answers['q57']) && $answers['q57'] == 2 ? 'checked' : '' }}>
                                    <label for="q57_2" class="italic">@lang('questionnaire-campaign.hais.disagree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q57_3"
                                        name="q57" value="3"
                                        {{ isset($answers['q57']) && $answers['q57'] == 3 ? 'checked' : '' }}>
                                    <label for="q57_3" class="italic">@lang('questionnaire-campaign.hais.neutral')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q57_4"
                                        name="q57" value="4"
                                        {{ isset($answers['q57']) && $answers['q57'] == 4 ? 'checked' : '' }}>
                                    <label for="q57_4" class="italic">@lang('questionnaire-campaign.hais.agree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q57_5"
                                        name="q57" value="5"
                                        {{ isset($answers['q57']) && $answers['q57'] == 5 ? 'checked' : '' }}>
                                    <label for="q57_5" class="italic">@lang('questionnaire-campaign.hais.stronglyAgree')</label>
                                </div>
                            </div>
                        </div>

                        <p class="font-semibold text-center pt-4">Ignoring poor security behavior by
                            colleagues</p>

                        <!-- Q58 -->
                        <div class="py-3 flex flex-col border-b-2">
                            <p class="text-center font-medium py-3">I must not ignore poor security behaviour by my
                                colleagues.</p>
                            <div
                                class="flex flex-col md:flex-row items-top md:items-center w-full md:justify-around">
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q58_1"
                                        name="q58" value="1"
                                        {{ isset($answers['q58']) && $answers['q58'] == 1 ? 'checked' : '' }}>
                                    <label for="q58_1" class="italic">@lang('questionnaire-campaign.hais.stronglyDisagree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q58_2"
                                        name="q58" value="2"
                                        {{ isset($answers['q58']) && $answers['q58'] == 2 ? 'checked' : '' }}>
                                    <label for="q58_2" class="italic">@lang('questionnaire-campaign.hais.disagree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q58_3"
                                        name="q58" value="3"
                                        {{ isset($answers['q58']) && $answers['q58'] == 3 ? 'checked' : '' }}>
                                    <label for="q58_3" class="italic">@lang('questionnaire-campaign.hais.neutral')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q58_4"
                                        name="q58" value="4"
                                        {{ isset($answers['q58']) && $answers['q58'] == 4 ? 'checked' : '' }}>
                                    <label for="q58_4" class="italic">@lang('questionnaire-campaign.hais.agree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q58_5"
                                        name="q58" value="5"
                                        {{ isset($answers['q58']) && $answers['q58'] == 5 ? 'checked' : '' }}>
                                    <label for="q58_5" class="italic">@lang('questionnaire-campaign.hais.stronglyAgree')</label>
                                </div>
                            </div>
                        </div>

                        <!-- Q59 -->
                        <div class="py-3 flex flex-col border-b-2">
                            <p class="text-center font-medium py-3">Nothing bad can happen if I ignore poor security
                                behaviour by a colleague.</p>
                            <div
                                class="flex flex-col md:flex-row items-top md:items-center w-full md:justify-around">
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q59_1"
                                        name="q59" value="1"
                                        {{ isset($answers['q59']) && $answers['q59'] == 1 ? 'checked' : '' }}>
                                    <label for="q59_1" class="italic">@lang('questionnaire-campaign.hais.stronglyAgree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q59_2"
                                        name="q59" value="2"
                                        {{ isset($answers['q59']) && $answers['q59'] == 2 ? 'checked' : '' }}>
                                    <label for="q59_2" class="italic">@lang('questionnaire-campaign.hais.agree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q59_3"
                                        name="q59" value="3"
                                        {{ isset($answers['q59']) && $answers['q59'] == 3 ? 'checked' : '' }}>
                                    <label for="q59_3" class="italic">@lang('questionnaire-campaign.hais.neutral')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q59_4"
                                        name="q59" value="4"
                                        {{ isset($answers['q59']) && $answers['q59'] == 4 ? 'checked' : '' }}>
                                    <label for="q59_4" class="italic">@lang('questionnaire-campaign.hais.disagree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q59_5"
                                        name="q59" value="5"
                                        {{ isset($answers['q59']) && $answers['q59'] == 5 ? 'checked' : '' }}>
                                    <label for="q59_5" class="italic">@lang('questionnaire-campaign.hais.stronglyDisagree')</label>
                                </div>
                            </div>
                        </div>

                        <!-- Q60 -->
                        <div class="py-3 flex flex-col border-b-2">
                            <p class="text-center font-medium py-3">If I noticed my colleague ignoring security rules,
                                I
                                wouldn't take any action.</p>
                            <div
                                class="flex flex-col md:flex-row items-top md:items-center w-full md:justify-around">
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q60_1"
                                        name="q60" value="1"
                                        {{ isset($answers['q60']) && $answers['q60'] == 1 ? 'checked' : '' }}>
                                    <label for="q60_1" class="italic">@lang('questionnaire-campaign.hais.stronglyAgree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q60_2"
                                        name="q60" value="2"
                                        {{ isset($answers['q60']) && $answers['q60'] == 2 ? 'checked' : '' }}>
                                    <label for="q60_2" class="italic">@lang('questionnaire-campaign.hais.agree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q60_3"
                                        name="q60" value="3"
                                        {{ isset($answers['q60']) && $answers['q60'] == 3 ? 'checked' : '' }}>
                                    <label for="q60_3" class="italic">@lang('questionnaire-campaign.hais.neutral')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q60_4"
                                        name="q60" value="4"
                                        {{ isset($answers['q60']) && $answers['q60'] == 4 ? 'checked' : '' }}>
                                    <label for="q60_4" class="italic">@lang('questionnaire-campaign.hais.disagree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q60_5"
                                        name="q60" value="5"
                                        {{ isset($answers['q60']) && $answers['q60'] == 5 ? 'checked' : '' }}>
                                    <label for="q60_5" class="italic">@lang('questionnaire-campaign.hais.stronglyDisagree')</label>
                                </div>
                            </div>
                        </div>

                        <p class="font-semibold text-center pt-4">Reporting all incidents</p>

                        <!-- Q61 -->
                        <div class="py-3 flex flex-col border-b-2">
                            <p class="text-center font-medium py-3">It's optional to report security incidents.</p>
                            <div
                                class="flex flex-col md:flex-row items-top md:items-center w-full md:justify-around">
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q61_1"
                                        name="q61" value="1"
                                        {{ isset($answers['q61']) && $answers['q61'] == 1 ? 'checked' : '' }}>
                                    <label for="q61_1" class="italic">@lang('questionnaire-campaign.hais.stronglyAgree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q61_2"
                                        name="q61" value="2"
                                        {{ isset($answers['q61']) && $answers['q61'] == 2 ? 'checked' : '' }}>
                                    <label for="q61_2" class="italic">@lang('questionnaire-campaign.hais.agree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q61_3"
                                        name="q61" value="3"
                                        {{ isset($answers['q61']) && $answers['q61'] == 3 ? 'checked' : '' }}>
                                    <label for="q61_3" class="italic">@lang('questionnaire-campaign.hais.neutral')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q61_4"
                                        name="q61" value="4"
                                        {{ isset($answers['q61']) && $answers['q61'] == 4 ? 'checked' : '' }}>
                                    <label for="q61_4" class="italic">@lang('questionnaire-campaign.hais.disagree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q61_5"
                                        name="q61" value="5"
                                        {{ isset($answers['q61']) && $answers['q61'] == 5 ? 'checked' : '' }}>
                                    <label for="q61_5" class="italic">@lang('questionnaire-campaign.hais.stronglyDisagree')</label>
                                </div>
                            </div>
                        </div>

                        <!-- Q62 -->
                        <div class="py-3 flex flex-col border-b-2">
                            <p class="text-center font-medium py-3">It's risky to ignore security incidents, even if I
                                think they're not significant.</p>
                            <div
                                class="flex flex-col md:flex-row items-top md:items-center w-full md:justify-around">
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q62_1"
                                        name="q62" value="1"
                                        {{ isset($answers['q62']) && $answers['q62'] == 1 ? 'checked' : '' }}>
                                    <label for="q62_1" class="italic">@lang('questionnaire-campaign.hais.stronglyDisagree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q62_2"
                                        name="q62" value="2"
                                        {{ isset($answers['q62']) && $answers['q62'] == 2 ? 'checked' : '' }}>
                                    <label for="q62_2" class="italic">@lang('questionnaire-campaign.hais.disagree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q62_3"
                                        name="q62" value="3"
                                        {{ isset($answers['q62']) && $answers['q62'] == 3 ? 'checked' : '' }}>
                                    <label for="q62_3" class="italic">@lang('questionnaire-campaign.hais.neutral')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q62_4"
                                        name="q62" value="4"
                                        {{ isset($answers['q62']) && $answers['q62'] == 4 ? 'checked' : '' }}>
                                    <label for="q62_4" class="italic">@lang('questionnaire-campaign.hais.agree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q62_5"
                                        name="q62" value="5"
                                        {{ isset($answers['q62']) && $answers['q62'] == 5 ? 'checked' : '' }}>
                                    <label for="q62_5" class="italic">@lang('questionnaire-campaign.hais.stronglyAgree')</label>
                                </div>
                            </div>
                        </div>

                        <!-- Q63 -->
                        <div class="py-3 flex flex-col border-b-2">
                            <p class="text-center font-medium py-3">If I noticed a security incident, I would report
                                it.
                            </p>
                            <div
                                class="flex flex-col md:flex-row items-top md:items-center w-full md:justify-around">
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q63_1"
                                        name="q63" value="1"
                                        {{ isset($answers['q63']) && $answers['q63'] == 1 ? 'checked' : '' }}>
                                    <label for="q63_1" class="italic">@lang('questionnaire-campaign.hais.stronglyDisagree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q63_2"
                                        name="q63" value="2"
                                        {{ isset($answers['q63']) && $answers['q63'] == 2 ? 'checked' : '' }}>
                                    <label for="q63_2" class="italic">@lang('questionnaire-campaign.hais.disagree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q63_3"
                                        name="q63" value="3"
                                        {{ isset($answers['q63']) && $answers['q63'] == 3 ? 'checked' : '' }}>
                                    <label for="q63_3" class="italic">@lang('questionnaire-campaign.hais.neutral')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q63_4"
                                        name="q63" value="4"
                                        {{ isset($answers['q63']) && $answers['q63'] == 4 ? 'checked' : '' }}>
                                    <label for="q63_4" class="italic">@lang('questionnaire-campaign.hais.agree')</label>
                                </div>
                                <div class="flex flex-row md:flex-col items-center">
                                    <input disabled class="checked:bg-sky-800" type="radio" id="q63_5"
                                        name="q63" value="5"
                                        {{ isset($answers['q63']) && $answers['q63'] == 5 ? 'checked' : '' }}>
                                    <label for="q63_5" class="italic">@lang('questionnaire-campaign.hais.stronglyAgree')</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex w-full items-center pb-4">
                    <div class="flex w-1/3 justify-center">
                        <x-primary-button type="button" id="prevBtn"
                            onclick="nextPrev(-1)">Previous</x-primary-button>
                    </div>

                    <!-- Circles which indicates the steps of the form: -->
                    <div class="flex w-1/3 justify-center flex-row">
                        <span class="step"></span>
                        <span class="step"></span>
                        <span class="step"></span>
                        <span class="step"></span>
                        <span class="step"></span>
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
