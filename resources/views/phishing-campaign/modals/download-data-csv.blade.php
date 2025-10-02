<section class="text-sky-800">
    <!-- Download data csv -->
    <p class="text-xl font-semibold text-center">
        @lang('phishing-campaign.analyseCampaign.downloadModalMessage')
    </p>
    <div class="pt-4">
        <form id="downloadForm" data-id=""
            action="{{ route('phishing-campaign.download-data-csv', ['phishingCampaign' => 'id']) }}" method="GET">
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
                const downloadForm = document.getElementById('downloadForm');
                const actionUrl =
                    "{{ route('phishing-campaign.download-data-csv', ['phishingCampaign' => 'id']) }}";

                downloadForm.setAttribute('data-id', id);
                downloadForm.action = actionUrl.replace('id', id);
            });
        });

        document.getElementById('downloadForm').addEventListener('submit', function(event) {
            const closeModalEvent = new CustomEvent('close-modal', {
                detail: 'download-data-csv-modal'
            });
            window.dispatchEvent(closeModalEvent);

            document.getElementById('loadingOverlay').classList.add('flex');
            document.getElementById('loadingOverlay').classList.remove('hidden');

            setTimeout(function() {
                loadingOverlay.classList.add('hidden');
                loadingOverlay.classList.remove('flex');
            }, 2000);
        });
    });
</script>
