<x-guest-layout>

    <p class="text-xl font-extrabold text-center">@lang('auth.register.register')</p>

    <form id="registrationForm" method="POST" action="{{ route('register') }}">
        @csrf

        <div class="flex flex-col">
            <!-- Name -->
            <div class="mt-4">
                <x-input-label for="name" :value="__('auth.register.name')" />
                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')"
                    required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Surname -->
            <div class="mt-4">
                <x-input-label for="surname" :value="__('auth.register.surname')" />
                <x-text-input id="surname" class="block mt-1 w-full" type="text" name="surname" :value="old('surname')"
                    required autofocus autocomplete="surname" />
                <x-input-error :messages="$errors->get('surname')" class="mt-2" />
            </div>

            <!-- Gender -->
            <div class="mt-4">
                <x-input-label for="gender" :value="__('auth.register.gender')" />
                <select id="gender" name="gender"
                    class="mt-1 block border-sky-800 focus:border-sky-900 focus:ring-sky-800 rounded-md shadow-sm w-full"
                    required autofocus autocomplete="gender">
                    <option value="Male">@lang('auth.register.male')</option>
                    <option value="Female">@lang('auth.register.female')</option>
                    <option value="Other">@lang('auth.register.other')</option>
                </select>
                <x-input-error :messages="$errors->get('gender')" class="mt-2" />
            </div>

            <!-- Date of Birth -->
            <div class="mt-4">
                <x-input-label for="dob" :value="__('auth.register.dob')" />
                <x-text-input id="dob" class="block mt-1 w-full" type="text" name="dob" :value="old('dob')"
                    required autofocus autocomplete="dob" placeholder="DD/MM/YYYY" />
                <x-input-error :messages="$errors->get('dob')" class="mt-2" />
            </div>

            <!-- Role -->
            <div class="hidden mt-4">
                <x-input-label for="role" :value="__('auth.register.role')" />
                <x-text-input id="role" class="block mt-1 w-full" type="text" name="role" :value="'User'"
                    required autocomplete="role" />
                <x-input-error :messages="$errors->get('role')" class="mt-2" />
            </div>

            <!-- Company Role -->
            <div class="mt-4">
                <x-input-label for="company_role" :value="__('auth.register.companyRole')" />
                <x-text-input id="company_role" class="block mt-1 w-full" type="text" name="company_role" :value="old('company_role')"
                    required autocomplete="company_role" />
                <x-input-error :messages="$errors->get('company_role')" class="mt-2" />
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <x-input-label for="email" :value="__('auth.register.email')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                    required autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mt-4 relative">
                <x-input-label for="password" :value="__('auth.register.password')" />
                <x-text-input id="password" class="block mt-1 w-full pr-10" type="password" name="password" required
                    autocomplete="new-password" />
                <span class="absolute top-9 right-0 pr-3 flex items-center cursor-pointer">
                    <i id="togglePassword" class="fa fa-eye"></i>
                </span>
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4 relative">
                <x-input-label for="password_confirmation" :value="__('auth.register.confirmPassword')" />
                <x-text-input id="password_confirmation" class="block mt-1 w-full pr-10" type="password"
                    name="password_confirmation" required autocomplete="new-password" />
                <span class="absolute top-9 right-0 pr-3 flex items-center cursor-pointer">
                    <i id="togglePasswordConfirmation" class="fa fa-eye"></i>
                </span>
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>
        </div>
        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-sky-600 hover:text-sky-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-500"
                href="{{ route('login') }}">
                @lang('auth.register.alreadyRegistered')
            </a>

            <x-primary-button class="ms-4">
                @lang('auth.register.register')
            </x-primary-button>
        </div>
    </form>

    <!-- Loading screen -->
    <div id="loadingOverlay"
        class="fixed top-0 left-0 w-full h-full bg-gray-900 bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="loader ease-linear rounded-full border-8 border-t-8 h-32 w-32"></div>
    </div>

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
    });

    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('registrationForm').addEventListener('submit', function(event) {
            document.getElementById('loadingOverlay').classList.add('flex');
            document.getElementById('loadingOverlay').classList.remove('hidden');
        });
    });
</script>
