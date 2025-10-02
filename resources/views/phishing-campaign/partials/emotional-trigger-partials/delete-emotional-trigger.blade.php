<section>
    <!-- Delete emotional trigger -->
    <div class="text-sky-800">
        <p class="text-lg font-medium">
            @lang('phishing-campaign.partials.emotionalTrigger.delete'):
        </p>
        @if ($emotionalTriggers->isEmpty())
            <p class="text-center">@lang('phishing-campaign.partials.emotionalTrigger.noEmotionalTriggersDelete')</p>
        @else
            <form id="deleteEmotionalTriggerForm"
                action="{{ route('emotional-trigger.destroy', ['emotionalTrigger' => 'emotionalTrigger']) }}" method="POST">
                @csrf
                @method('delete')

                <div class="mb-4">
                    <x-input-label for="deleteEmotionalTriggerSelect" class="text-md block font-medium text-sky-700"
                        :value="__('phishing-campaign.partials.emotionalTrigger.valueDelete')" />
                    <select id="deleteEmotionalTriggerSelect" name="emotionalTrigger"
                        class="mt-1 block w-full py-2 px-3 border border-sky-800 bg-white rounded-md shadow-sm focus:outline-none focus:ring-sky-800 focus:border-sky-800 sm:text-sm">
                        @foreach ($emotionalTriggers as $emotionalTrigger)
                            <option value="{{ $emotionalTrigger->id }}">{{ $emotionalTrigger->description }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex justify-end">
                    <x-primary-button type="submit">@lang('phishing-campaign.partials.emotionalTrigger.deleteButton')</x-primary-button>
                </div>
            </form>
        @endif

    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const deleteForm = document.getElementById('deleteEmotionalTriggerForm');
        const select = document.getElementById('deleteEmotionalTriggerSelect');

        select.addEventListener('change', function() {
            const selectedEmotionalTriggerId = select.value;
            const actionUrl = "{{ route('emotional-trigger.destroy', ['emotionalTrigger' => 'id']) }}";
            deleteForm.action = actionUrl.replace('id', selectedEmotionalTriggerId);
        });

        document.getElementById('deleteEmotionalTriggerForm').addEventListener('submit', function(event) {
            document.getElementById('loadingOverlay').classList.add('flex');
            document.getElementById('loadingOverlay').classList.remove('hidden');
        });
    });
</script>
