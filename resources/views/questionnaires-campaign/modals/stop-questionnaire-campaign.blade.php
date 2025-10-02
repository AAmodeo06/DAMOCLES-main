<section class="text-sky-800">
    <!-- Stop questionnaire campaign -->
    <p class="text-xl font-semibold text-center">
        @lang('questionnaire-campaign.modals.stop')
    </p>
    <div class="pt-4">
        <form id="stopForm" data-id=""
            action="{{ route('questionnaire-campaign.change-state', ['questionnaireCampaign' => 'id', 'state' => 'Finished']) }}"
            method="POST">
            @csrf
            @method('post')
            <p class="pb-4">@lang('questionnaire-campaign.modals.stopMessage')</p>
            <div class="flex justify-end gap-3">
                <x-secondary-button x-on:click="$dispatch('close')">@lang('questionnaire-campaign.modals.cancel')</x-secondary-button>
                <x-primary-button type="submit">@lang('questionnaire-campaign.modals.confirm')</x-primary-button>
            </div>
        </form>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const stopButton = document.querySelectorAll('[data-id]');

        stopButton.forEach(button => {
            button.addEventListener('click', function() {
                const id = button.getAttribute('data-id');
                const stopForm = document.getElementById('stopForm');
                const actionUrl =
                    "{{ route('questionnaire-campaign.change-state', ['questionnaireCampaign' => 'id', 'state' => 'Finished']) }}";

                stopForm.setAttribute('data-id', id);
                stopForm.action = actionUrl.replace('id', id);
            });
        });

        document.getElementById('stopForm').addEventListener('submit', function(event) {
            document.getElementById('loadingOverlay').classList.add('flex');
            document.getElementById('loadingOverlay').classList.remove('hidden');
        });
    });
</script>
