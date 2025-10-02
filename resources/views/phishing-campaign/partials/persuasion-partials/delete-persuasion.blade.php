<section>
    <!-- Delete persuasion -->
    <div class="text-sky-800">
        <p class="text-lg font-medium">
            @lang('phishing-campaign.partials.persuasion.delete')
        </p>
        @if ($persuasions->isEmpty())
            <p class="text-center">@lang('phishing-campaign.partials.persuasion.noPersuasionsDelete')</p>
        @else
            <form id="deletePersuasionForm" action="{{ route('persuasion.destroy', ['persuasion' => 'persuasion']) }}"
                method="POST">
                @csrf
                @method('delete')

                <div class="mb-4">
                    <x-input-label for="deletePersuasionSelect" class="text-md block font-medium text-sky-700"
                        :value="__('phishing-campaign.partials.persuasion.valueDelete')" />
                    <select id="deletePersuasionSelect" name="persuasion"
                        class="mt-1 block w-full py-2 px-3 border border-sky-800 bg-white rounded-md shadow-sm focus:outline-none focus:ring-sky-800 focus:border-sky-800 sm:text-sm">
                        @foreach ($persuasions as $persuasion)
                            <option value="{{ $persuasion->id }}">{{ $persuasion->description }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex justify-end">
                    <x-primary-button type="submit">@lang('phishing-campaign.partials.persuasion.deleteButton')</x-primary-button>
                </div>
            </form>
        @endif

    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const deleteForm = document.getElementById('deletePersuasionForm');
        const select = document.getElementById('deletePersuasionSelect');

        select.addEventListener('change', function() {
            const selectedPersuasionId = select.value;
            const actionUrl = "{{ route('persuasion.destroy', ['persuasion' => 'id']) }}";
            deleteForm.action = actionUrl.replace('id', selectedPersuasionId);
        });

        document.getElementById('deletePersuasionForm').addEventListener('submit', function(event) {
            document.getElementById('loadingOverlay').classList.add('flex');
            document.getElementById('loadingOverlay').classList.remove('hidden');
        });
    });
</script>
