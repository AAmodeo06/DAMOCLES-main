<section>

    <div class="flex flex-wrap justify-center gap-x-24">

        <div class="flex flex-col justify-center items-center pt-2 pb-6">
            <p class="font-semibold text-lg text-center">@lang('dashboard.evaluator.users')</p>
            <p class="font-semibold gap-x-6">
                <span class="material-symbols-outlined text-5xl align-middle">group</span>
                <span>{{ $usersCount }}</span>
            </p>
        </div>

        <div class="flex flex-col justify-center items-center pt-2 pb-6">
            <p class="font-semibold text-lg text-center">@lang('dashboard.evaluator.phishingCampaign')</p>
            <a href="{{ route('phishing-campaign.index') }}">
                <p class="font-semibold gap-x-6">
                    <span class="material-symbols-outlined text-5xl align-middle">stacked_email</span>
                    <span>{{ $totalPhishingCampaigns }}</span>
                </p>
            </a>
        </div>

        <div class="flex flex-col justify-center items-center pt-2 pb-6">
            <p class="font-semibold text-lg text-center">@lang('dashboard.evaluator.questionnairesCampaign')</p>
            <a href="{{ route('questionnaires-campaign.index') }}">
                <p class="font-semibold gap-x-6">
                    <span class="material-symbols-outlined text-5xl align-middle">dynamic_form</span>
                    <span>{{ $totalQuestionnaireCampaigns }}</span>
                </p>
            </a>
        </div>

        <div class="flex flex-col justify-center items-center pt-2 pb-6">
            <p class="font-semibold text-lg text-center">@lang('dashboard.evaluator.questionnaires')</p>
            <a href="{{ route('questionnaires') }}">
                <p class="font-semibold gap-x-6">
                    <span class="material-symbols-outlined text-5xl align-middle">quiz</span>
                    <span>{{ $questionnairesCount }}</span>
                </p>
            </a>
        </div>

    </div>

    @include('dashboard.partials.charts')
</section>
