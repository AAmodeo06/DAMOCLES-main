<section class="text-sky-800">
    <!-- Stop phishing campaign -->
    <p class="text-xl font-semibold text-center">
        @lang('phishing-campaign.modals.stop')
    </p>
    <div class="pt-4">
        <form id="stopForm" data-id=""
            action="{{ route('phishing-campaign.change-state', ['phishingCampaign' => 'id', 'state' => 'Finished']) }}"
            method="POST">
            @csrf
            @method('post')
            <p class="pb-4">@lang('phishing-campaign.modals.stopMessage')</p>
            <div class="flex justify-end gap-3">
                <x-secondary-button x-on:click="$dispatch('close')">@lang('phishing-campaign.modals.cancel')</x-secondary-button>
                <x-primary-button type="submit">@lang('phishing-campaign.modals.confirm')</x-primary-button>
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
                    "{{ route('phishing-campaign.change-state', ['phishingCampaign' => 'id', 'state' => 'Finished']) }}";

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
