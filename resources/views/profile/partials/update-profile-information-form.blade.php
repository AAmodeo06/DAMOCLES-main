<section>
    <header>
        <p class="text-lg font-medium text-sky-900">
            @lang('profile.partials.updateProfile.profile')
        </p>

        <p class="mt-1 text-sm text-sky-600">
            @lang('profile.partials.updateProfile.profileMessage')
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form id="updateProfileForm" method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6 text-sky-900">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" :value="__('profile.partials.updateProfile.name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)"
                required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="surname" :value="__('profile.partials.updateProfile.surname')" />
            <x-text-input id="surname" name="surname" type="text" class="mt-1 block w-full" :value="old('surname', $user->surname)"
                required autofocus autocomplete="surname" />
            <x-input-error class="mt-2" :messages="$errors->get('surname')" />
        </div>

        <div class="mt-4">
            <x-input-label for="gender" :value="__('profile.partials.updateProfile.gender')" />
            <select id="gender" name="gender"
                class="mt-1 block border-sky-800 focus:border-sky-900 focus:ring-sky-800 rounded-md shadow-sm w-full"
                required autofocus autocomplete="gender">
                <option value="Male" {{ $user->gender === 'Male' ? 'selected' : '' }}>@lang('profile.partials.updateProfile.male')</option>
                <option value="Female" {{ $user->gender === 'Female' ? 'selected' : '' }}>@lang('profile.partials.updateProfile.female')</option>
                <option value="Other" {{ $user->gender === 'Other' ? 'selected' : '' }}>@lang('profile.partials.updateProfile.other')</option>
            </select>
            <x-input-error :messages="$errors->get('gender')" class="mt-2" />
        </div>

        <div class='hidden'>
            <x-input-label for="role" :value="__('profile.partials.updateProfile.role')" />
            <select disabled id="role" name="role"
                class="mt-1 block border-sky-800 focus:border-sky-900 focus:ring-sky-800 rounded-md shadow-sm w-full"
                required autofocus autocomplete="role">
                <option value="Admin" {{ $user->role === 'Admin' ? 'selected' : '' }}>@lang('profile.partials.updateProfile.admin')</option>
                <option value="Evaluator" {{ $user->role === 'Evaluator' ? 'selected' : '' }}>@lang('profile.partials.updateProfile.evaluator')</option>
                <option value="User" {{ $user->role === 'User' ? 'selected' : '' }}>@lang('profile.partials.updateProfile.user')</option>
            </select>
            <x-input-error :messages="$errors->get('gender')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="company_role" :value="__('profile.partials.updateProfile.companyRole')" />
            <x-text-input id="company_role" name="company_role" type="text" class="mt-1 block w-full"
                :value="old('company_role', $user->company_role)" required autofocus autocomplete="company_role" />
            <x-input-error class="mt-2" :messages="$errors->get('company_role')" />
        </div>

        <div>
            <x-input-label for="dob" :value="__('profile.partials.updateProfile.dob')" />
            <x-text-input id="dob" name="dob" type="text" class="mt-1 block w-full" :value="old('dob', $user->dob ? \Carbon\Carbon::parse($user->dob)->format('d/m/Y') : '')"
                required autofocus autocomplete="dob" />
            <x-input-error class="mt-2" :messages="$errors->get('dob')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('profile.partials.updateProfile.email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)"
                required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-sky-800">
                        @lang('profile.partials.updateProfile.unverifiedProfile')

                        <button form="send-verification"
                            class="underline text-sm text-sky-600 hover:text-sky-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-500">
                            @lang('profile.partials.updateProfile.resendVerification')
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            @lang('profile.partials.updateProfile.newVerification')
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>@lang('profile.partials.updateProfile.save')</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-sky-600">@lang('profile.partials.updateProfile.saved')</p>
            @endif
        </div>
    </form>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('updateProfileForm').addEventListener('submit', function(event) {
            document.getElementById('loadingOverlay').classList.add('flex');
            document.getElementById('loadingOverlay').classList.remove('hidden');
        });
    });
</script>
