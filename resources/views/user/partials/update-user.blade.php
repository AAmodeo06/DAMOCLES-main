<section class="text-sky-800">
    <!-- Edit User -->
    <p class="text-xl font-semibold text-center">@lang('user.partials.update.update')</p>

    @if (isset($user))
    <div class="pt-4">
        <section>
            <header>
                <p class="text-lg font-medium text-sky-900">
                    @lang('user.partials.update.profile')
                </p>
            </header>

            <form id="send-verification" method="post" action="{{ route('verification.send') }}">
                @csrf
            </form>

            <form id="updateForm" method="post" action="{{ route('profile.updateFromAdmin') }}" class="space-y-2">
                @csrf
                @method('PATCH')

                <div class="hidden">
                    <x-input-label for="id" :value="__('user.partials.update.value.id')" />
                    <x-text-input name="id" id="id" type="text" class="mt-1 block w-full" :value="old('id', $user->id)" required autofocus autocomplete="id" />
                    <x-input-error class="mt-2" :messages="$errors->get('id')" />
                </div>

                <div>
                    <x-input-label for="name" :value="__('user.partials.update.value.name')" />
                    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
                    <x-input-error class="mt-2" :messages="$errors->get('name')" />
                </div>

                <div>
                    <x-input-label for="surname" :value="__('user.partials.update.value.surname')" />
                    <x-text-input id="surname" name="surname" type="text" class="mt-1 block w-full" :value="old('surname', $user->surname)" required autofocus autocomplete="surname" />
                    <x-input-error class="mt-2" :messages="$errors->get('surname')" />
                </div>

                <div>
                    <x-input-label for="gender" :value="__('user.partials.update.value.gender')" />
                    <select id="gender" name="gender" class="mt-1 block border-sky-800 focus:border-sky-800 focus:ring-sky-800 rounded-md shadow-sm w-full" required autofocus autocomplete="gender">
                        <option value="Male" {{ $user->gender === 'Male' ? 'selected' : '' }}>
                            @lang('user.partials.update.male')
                        </option>
                        <option value="Female" {{ $user->gender === 'Female' ? 'selected' : '' }}>
                            @lang('user.partials.update.female')
                        </option>
                        <option value="Other" {{ $user->gender === 'Other' ? 'selected' : '' }}>
                            @lang('user.partials.update.other')
                        </option>
                    </select>
                    <x-input-error :messages="$errors->get('gender')" class="mt-2" />
                </div>

                <div class="mt-4">
                    <x-input-label for="role" :value="__('user.partials.update.value.role')" />
                    <select id="role" name="role" class="mt-1 block border-sky-800 focus:border-sky-800 focus:ring-sky-800 rounded-md shadow-sm w-full" required autofocus autocomplete="role">
                        <option value="Admin" {{ $user->role === 'Admin' ? 'selected' : '' }}>
                            @lang('user.partials.update.admin')
                        </option>
                        <option value="Evaluator" {{ $user->role === 'Evaluator' ? 'selected' : '' }}>
                            @lang('user.partials.update.evaluator')
                        </option>
                        <option value="User" {{ $user->role === 'User' ? 'selected' : '' }}>
                            @lang('user.partials.update.user')
                        </option>
                    </select>
                    <x-input-error :messages="$errors->get('role')" class="mt-2" />
                </div>
                
                <div>
                    <x-input-label for="company_role" :value="__('user.partials.update.value.companyRole')" />
                    <x-text-input id="company_role" name="company_role" type="text" class="mt-1 block w-full" :value="old('company_role', $user->company_role)" required autofocus autocomplete="company_role" />
                    <x-input-error class="mt-2" :messages="$errors->get('company_role')" />
                </div>

                <div>
                    <x-input-label for="dob" :value="__('user.partials.update.value.dob')" />
                    <x-text-input id="dob" name="dob" type="text" class="mt-1 block w-full" :value="old('dob', $user->dob)" required autofocus autocomplete="dob" />
                    <x-input-error class="mt-2" :messages="$errors->get('dob')" />
                </div>

                <div>
                    <x-input-label for="email" :value="__('user.partials.update.value.email')" />
                    <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
                    <x-input-error class="mt-2" :messages="$errors->get('email')" />
                </div>

                <div class="flex justify-end items-center pt-4 gap-4">
                    @if (session('status') === 'profile-updated')
                    <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-sky-600">@lang('user.partials.update.saved')</p>
                    @endif

                    <x-secondary-button x-on:click="$dispatch('close')">@lang('user.partials.update.cancel')</x-secondary-button>
                    <x-primary-button>@lang('user.partials.update.save')</x-primary-button>

                </div>
            </form>
        </section>
    </div>
    @else
    <p class="text-center text-lg text-sky-700">@lang('user.partials.update.noUsers')</p>
    @endif
</section>

<script>
    function fillUpdateModal(user) {

        const idInput = document.getElementById('id');
        const nameInput = document.getElementById('name');
        const surnameInput = document.getElementById('surname');
        const genderSelect = document.getElementById('gender');
        const dobInput = document.getElementById('dob');
        const emailInput = document.getElementById('email');
        const roleInput = document.getElementById('role');
        const companyRoleInput = document.getElementById('company_role');

        idInput.value = user.id;
        nameInput.value = user.name;
        surnameInput.value = user.surname;
        genderSelect.value = user.gender;
        dobInput.value = user.dob;
        emailInput.value = user.email;
        roleInput.value = user.role;
        companyRoleInput.value = user.company_role;
    }

    // Loading screen
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('updateForm').addEventListener('submit', function(event) {
            document.getElementById('loadingOverlay').classList.add('flex');
            document.getElementById('loadingOverlay').classList.remove('hidden');
        });
    });

</script>
