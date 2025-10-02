<section class="text-sky-800">
    <!-- Delete result -->
    <p class="text-lg font-medium">
        @lang('questionnaire-campaign.hais.partials.delete.delete')
    </p>
    <div class="pt-4">
        <form id="deleteForm" data-id="" action="{{ route('result.destroy', ['answer' => 'id']) }}" method="POST">
            @csrf
            @method('delete')

            <p class="pb-4">@lang('questionnaire-campaign.hais.partials.delete.deleteMessage')</p>

            <input type="hidden" name="answerId" id="answerId" value="">

            <div class="flex justify-end gap-3">
                <x-secondary-button x-on:click="$dispatch('close')">@lang('questionnaire-campaign.hais.partials.delete.cancel')</x-secondary-button>
                <x-danger-button type="submit">@lang('questionnaire-campaign.hais.partials.delete.confirm')</x-danger-button>
            </div>
        </form>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const deleteButtons = document.querySelectorAll('[data-answer-id]');

        deleteButtons.forEach(button => {
            button.addEventListener('click', function() {
                const id = button.getAttribute('data-answer-id');
                const deleteForm = document.getElementById('deleteForm');
                const actionUrl = "{{ route('result.destroy', ['answer' => 'id']) }}";

                deleteForm.setAttribute('data-id', id);
                deleteForm.action = actionUrl.replace('id', id);

                document.getElementById('answerId').value = id;
            });
        });

        document.getElementById('deleteForm').addEventListener('submit', function(event) {
            document.getElementById('loadingOverlay').classList.add('flex');
            document.getElementById('loadingOverlay').classList.remove('hidden');
        });
    });
</script>
