<section>
    <header>
        <p class="text-lg font-medium text-sky-900">
            @lang('profile.partials.updatePassword.password')
        </p>

        <p class="mt-1 text-sm text-sky-600">
            @lang('profile.partials.updatePassword.passwordMessage')
        </p>
    </header>

    <form id="updatePasswordForm" method="post" action="{{ route('password.update') }}"
        class="mt-6 space-y-6 text-sky-900">
        @csrf
        @method('put')

        <div class="relative">
            <x-input-label for="update_password_current_password" :value="__('profile.partials.updatePassword.currentPassword')" />
            <x-text-input id="update_password_current_password" name="current_password" type="password"
                class="mt-1 block w-full pr-10" autocomplete="current-password" />
            <span class="absolute top-9 right-0 pr-3 flex items-center cursor-pointer text-sky-900">
                <i id="toggleOldPassword" class="fa fa-eye"></i>
            </span>
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <div class="relative">
            <x-input-label for="update_password_password" :value="__('profile.partials.updatePassword.newPassword')" />
            <x-text-input id="update_password_password" name="password" type="password" class="mt-1 block w-full pr-10"
                autocomplete="new-password" />
            <span class="absolute top-9 right-0 pr-3 flex items-center cursor-pointer text-sky-900">
                <i id="toggleNewPassword" class="fa fa-eye"></i>
            </span>
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <div class="relative">
            <x-input-label for="update_password_password_confirmation" :value="__('profile.partials.updatePassword.confirmPassword')" />
            <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password"
                class="mt-1 block w-full pr-10" autocomplete="new-password" />
            <span class="absolute top-9 right-0 pr-3 flex items-center cursor-pointer text-sky-900">
                <i id="toggleNewPasswordConfirmation" class="fa fa-eye"></i>
            </span>
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>@lang('profile.partials.updatePassword.save')</x-primary-button>

            @if (session('status') === 'password-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-sky-600">@lang('profile.partials.updatePassword.saved')</p>
            @endif
        </div>
    </form>
</section>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<script>
    document.addEventListener('DOMContentLoaded', (event) => {
        const toggleOldPassword = document.querySelector('#toggleOldPassword');
        const toggleNewPassword = document.querySelector('#toggleNewPassword');
        const toggleNewPasswordConfirmation = document.querySelector('#toggleNewPasswordConfirmation');
        const currentPassword = document.querySelector('#update_password_current_password');
        const newPassword = document.querySelector('#update_password_password');
        const newPasswordConfirmation = document.querySelector('#update_password_password_confirmation');

        function togglePasswordVisibility(toggleElement, passwordField) {
            toggleElement.addEventListener('click', function() {
                const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordField.setAttribute('type', type);
                this.classList.toggle('fa-eye');
                this.classList.toggle('fa-eye-slash');
            });
        }

        togglePasswordVisibility(toggleOldPassword, currentPassword);
        togglePasswordVisibility(toggleNewPassword, newPassword);
        togglePasswordVisibility(toggleNewPasswordConfirmation, newPasswordConfirmation);
    });

    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('updatePasswordForm').addEventListener('submit', function(event) {
            document.getElementById('loadingOverlay').classList.add('flex');
            document.getElementById('loadingOverlay').classList.remove('hidden');
        });
    });
</script>
