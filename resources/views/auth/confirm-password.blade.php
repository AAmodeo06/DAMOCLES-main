<x-guest-layout>
    <div class="mb-4 text-sm text-sky-600">
        @lang('auth.confirmPassword.message')
    </div>

    <form id="confirmPasswordForm" method="POST" action="{{ route('password.confirm') }}">
        @csrf

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('auth.confirmPassword.password')" />

            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                autocomplete="current-password" />
            <span class="absolute top-9 right-0 pr-3 flex items-center cursor-pointer">
                <i id="togglePassword" class="fa fa-eye"></i>
            </span>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex justify-end mt-4">
            <x-primary-button>
                @lang('auth.confirmPassword.confirm')
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<script>
    document.addEventListener('DOMContentLoaded', (event) => {
        const togglePassword = document.querySelector('#togglePassword');
        const togglePasswordConfirmation = document.querySelector('#togglePasswordConfirmation');
        const password = document.querySelector('#password');
        const passwordConfirmation = document.querySelector('#password_confirmation');

        togglePassword.addEventListener('click', function(e) {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });

        togglePasswordConfirmation.addEventListener('click', function(e) {
            const type = passwordConfirmation.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordConfirmation.setAttribute('type', type);
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });

        togglePasswordConfirmation.addEventListener('click', function(e) {
            const type = passwordConfirmation.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordConfirmation.setAttribute('type', type);
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('updatePasswordForm').addEventListener('submit', function(event) {
            document.getElementById('loadingOverlay').classList.add('flex');
            document.getElementById('loadingOverlay').classList.remove('hidden');
        });
    });
</script>
