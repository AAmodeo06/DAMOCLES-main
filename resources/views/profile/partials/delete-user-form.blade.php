<section class="space-y-6">
    <header>
        <p class="text-lg font-medium text-sky-900">
            @lang('profile.partials.delete.delete')
        </p>

        <p class="mt-1 text-sm text-sky-600">
            @lang('profile.partials.delete.deleteAccount')
        </p>
    </header>

    <x-danger-button x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')">@lang('profile.partials.delete.delete')</x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form id="deleteUserForm" method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <p class="text-lg font-medium text-sky-900">
                @lang('profile.partials.delete.sureDelete')
            </p>

            <p class="mt-1 text-sm text-sky-600">
                @lang('profile.partials.delete.alert')
            </p>

            <div class="mt-6">
                <x-input-label for="password" value="__('profile.partials.delete.password')" class="sr-only" />

                <x-text-input id="password" name="password" type="password" class="mt-1 block w-3/4"
                    placeholder="Password" />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    @lang('profile.partials.delete.candel')
                </x-secondary-button>

                <x-danger-button class="ms-3">
                    @lang('profile.partials.delete.delete')
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('deleteUserForm').addEventListener('submit', function(event) {
            document.getElementById('loadingOverlay').classList.add('flex');
            document.getElementById('loadingOverlay').classList.remove('hidden');
        });
    });
</script>
