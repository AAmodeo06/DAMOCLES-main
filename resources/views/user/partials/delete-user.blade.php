<section class="text-sky-800">
    <!-- Delete User -->
    <p class="text-xl font-semibold text-center">@lang('user.partials.delete.delete')</p>
    <div class="pt-4">
        <form id="deleteForm" data-id="" action="{{ route('profile.destroyFromAdmin', ['id' => 'id']) }}"
            method="POST">
            @csrf
            @method('delete')
            <p class="pb-4">@lang('user.partials.delete.deleteMessage')</p>
            <div class="flex justify-end gap-3">
                <x-secondary-button x-on:click="$dispatch('close')">@lang('user.partials.delete.cancel')</x-secondary-button>
                <x-danger-button type="submit">@lang('user.partials.delete.confirm')</x-danger-button>
            </div>
        </form>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const deleteButtons = document.querySelectorAll('[data-id]');

        deleteButtons.forEach(button => {
            button.addEventListener('click', function() {
                const id = button.getAttribute('data-id');
                const deleteForm = document.getElementById('deleteForm');
                const actionUrl = "{{ route('profile.destroyFromAdmin', ['id' => 'id']) }}";

                deleteForm.setAttribute('data-id', id);
                deleteForm.action = actionUrl.replace('id', id);
            });
        });

        document.getElementById('deleteForm').addEventListener('submit', function(event) {
            document.getElementById('loadingOverlay').classList.add('flex');
            document.getElementById('loadingOverlay').classList.remove('hidden');
        });
    });
</script>
