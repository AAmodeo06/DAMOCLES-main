<section>
    <!-- Add new context -->
    <div class="text-sky-800">
        <p class="text-lg font-medium">
            @lang('phishing-campaign.partials.context.new'):
        </p>
        <form id="addContextForm" action="{{ route('context.create') }}" method="POST">
            @csrf
            @method('post')

            <div class="mb-4">
                <input required type="text" id="description" name="description"
                    class="p-2 border border-sky-800 focus:border-sky-800 focus:ring-sky-800 rounded-md shadow-sm w-full placeholder:text-sky-700"
                    placeholder="@lang('phishing-campaign.partials.context.placeholder')">
            </div>
            <div class="flex justify-end">
                <x-primary-button type="submit">@lang('phishing-campaign.partials.context.add')</x-primary-button>
            </div>
        </form>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('addContextForm').addEventListener('submit', function(event) {
            document.getElementById('loadingOverlay').classList.add('flex');
            document.getElementById('loadingOverlay').classList.remove('hidden');
        });
    });
</script>
