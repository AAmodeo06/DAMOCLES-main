<section class="text-sky-800">
    <!-- Start questionnaire campaign -->
    <p class="text-xl font-semibold text-center">
        @lang('questionnaire-campaign.modals.start')
    </p>
    <div class="pt-4">
        <form id="startForm" data-id=""
            action="{{ route('questionnaire-campaign.change-state', ['questionnaireCampaign' => 'id', 'state' => 'Ongoing']) }}"
            method="POST">
            @csrf
            @method('post')
            <p class="pb-4">@lang('questionnaire-campaign.modals.startMessage')</p>
            <div class="flex justify-end gap-3">
                <x-secondary-button x-on:click="$dispatch('close')">@lang('questionnaire-campaign.modals.cancel')</x-secondary-button>
                <x-primary-button type="submit">@lang('questionnaire-campaign.modals.confirm')</x-primary-button>
            </div>
        </form>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const startButton = document.querySelectorAll('[data-id]');

        startButton.forEach(button => {
            button.addEventListener('click', function() {
                const id = button.getAttribute('data-id');
                const startForm = document.getElementById('startForm');
                const actionUrl =
                    "{{ route('questionnaire-campaign.change-state', ['questionnaireCampaign' => 'id', 'state' => 'Ongoing']) }}";

                startForm.setAttribute('data-id', id);
                startForm.action = actionUrl.replace('id', id);
            });
        });

        document.getElementById('startForm').addEventListener('submit', function(event) {
            document.getElementById('loadingOverlay').classList.add('flex');
            document.getElementById('loadingOverlay').classList.remove('hidden');
        });
    });
</script>
