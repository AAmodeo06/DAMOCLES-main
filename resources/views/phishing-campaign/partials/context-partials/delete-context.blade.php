<section>
    <!-- Delete context -->
    <div class="text-sky-800">
        <p class="text-lg font-medium">
            @lang('phishing-campaign.partials.context.delete'):
        </p>
        @if ($contexts->isEmpty())
            <p class="text-center">@lang('phishing-campaign.partials.context.noContextsDelete')</p>
        @else
            <form id="deleteContextForm" action="{{ route('context.destroy', ['context' => 'context']) }}" method="POST">
                @csrf
                @method('delete')

                <div class="mb-4">
                    <x-input-label for="deleteContextSelect" class="text-md block font-medium text-sky-700"
                        :value="__('phishing-campaign.partials.context.valueDelete')" />
                    <select id="deleteContextSelect" name="context"
                        class="mt-1 block w-full py-2 px-3 border border-sky-800 bg-white rounded-md shadow-sm focus:outline-none focus:ring-sky-800 focus:border-sky-800 sm:text-sm">
                        @foreach ($contexts as $context)
                            <option value="{{ $context->id }}">{{ $context->description }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex justify-end">
                    <x-primary-button type="submit">@lang('phishing-campaign.partials.context.deleteButton')</x-primary-button>
                </div>
            </form>
        @endif

    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const deleteForm = document.getElementById('deleteContextForm');
        const select = document.getElementById('deleteContextSelect');

        select.addEventListener('change', function() {
            const selectedContextId = select.value;
            const actionUrl = "{{ route('context.destroy', ['context' => 'id']) }}";
            deleteForm.action = actionUrl.replace('id', selectedContextId);
        });

        document.getElementById('deleteContextForm').addEventListener('submit', function(event) {
            document.getElementById('loadingOverlay').classList.add('flex');
            document.getElementById('loadingOverlay').classList.remove('hidden');
        });
    });
</script>
