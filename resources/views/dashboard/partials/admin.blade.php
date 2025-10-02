<section>
    <div class="flex flex-wrap justify-center gap-x-24">

        <div class="flex flex-col justify-center items-center pt-2 pb-6">
            <p class="font-semibold text-lg text-center">@lang('dashboard.admin.admins')</p>
            <a href="{{ route('users', ['role' => 'admin']) }}">
                <p class="font-semibold gap-x-6">
                    <span class="material-symbols-outlined text-5xl align-middle">person_check</span>
                    <span>{{ $adminsCount }}</span>
                </p>
            </a>
        </div>

        <div class="flex flex-col justify-center items-center pt-2 pb-6">
            <p class="font-semibold text-lg text-center">@lang('dashboard.admin.evaluators')</p>
            <a href="{{ route('users', ['role' => 'evaluator']) }}">
                <p class="font-semibold gap-x-6">
                    <span class="material-symbols-outlined text-5xl align-middle">deployed_code_account</span>
                    <span>{{ $evaluatorsCount }}</span>
                </p>
            </a>
        </div>

        <div class="flex flex-col justify-center items-center pt-2 pb-6">
            <p class="font-semibold text-lg text-center">@lang('dashboard.admin.users')</p>
            <a href="{{ route('users', ['role' => 'user']) }}">
                <p class="font-semibold gap-x-6">
                    <span class="material-symbols-outlined text-5xl align-middle">group</span>
                    <span>{{ $usersCount }}</span>
                </p>
            </a>
        </div>

        <div class="flex flex-col justify-center items-center pt-2 pb-6">
            <p class="font-semibold text-lg text-center">@lang('dashboard.admin.llms')</p>
            <a href="{{ route('llms.index') }}">
                <p class="font-semibold gap-x-6">
                    <span class="material-symbols-outlined text-5xl align-middle">share_reviews</span>
                    <span>{{ $llmsCount }}</span>
                </p>
            </a>
        </div>
    </div>

    @include('dashboard.partials.charts')
</section>
