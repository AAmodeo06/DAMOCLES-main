<section>
    <!-- Add new emotional trigger -->
    <div class="text-sky-800">
        <p class="text-lg font-medium">
            @lang('phishing-campaign.partials.emotionalTrigger.new')
        </p>
        <form id="addEmotionalTriggerForm" action="{{ route('emotional-trigger.create') }}" method="POST">
            @csrf
            @method('post')

            <div class="mb-4 space-y-2">
                <x-input-label for="description" class="text-md block font-medium text-sky-700" :value="__('phishing-campaign.partials.emotionalTrigger.valueName')" />
                <input required type="text" id="description" name="description"
                    class="p-2 border border-sky-800 focus:border-sky-800 focus:ring-sky-800 rounded-md shadow-sm w-full placeholder:text-sky-700"
                    placeholder="@lang('phishing-campaign.partials.emotionalTrigger.placeholderName')">

                <x-input-label for="tooltip" class="mt-2 text-md block font-medium text-sky-700" :value="__('phishing-campaign.partials.emotionalTrigger.valueTooltip')" />
                <input required type="text" id="tooltip" name="tooltip"
                    class="p-2 border border-sky-800 focus:border-sky-800 focus:ring-sky-800 rounded-md shadow-sm w-full placeholder:text-sky-700"
                    placeholder="@lang('phishing-campaign.partials.emotionalTrigger.placeholderTooltip')">
            </div>
            <div class="flex justify-end">
                <x-primary-button type="submit">@lang('phishing-campaign.partials.emotionalTrigger.add')</x-primary-button>
            </div>
        </form>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('addEmotionalTriggerForm').addEventListener('submit', function(event) {
            document.getElementById('loadingOverlay').classList.add('flex');
            document.getElementById('loadingOverlay').classList.remove('hidden');
        });
    });
</script>
