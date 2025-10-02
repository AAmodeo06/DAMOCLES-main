<section>
    <header>
        <p class="text-lg font-medium text-sky-900">
            @lang('phishing-campaign.partials.context.context')
        </p>
    </header>

    @if ($contexts->isEmpty())
        <p class="text-center">@lang('phishing-campaign.partials.context.noContexts')</p>
    @else
        <x-input-label for="contextIdSelect" class="text-md block font-medium text-sky-700" :value="__('phishing-campaign.partials.context.value')" />
        <select id="contextIdSelect" name="contextId"
            class="mt-1 block w-full sm:w-1/2 py-2 px-3 border border-sky-800 bg-white rounded-md shadow-sm focus:outline-none focus:ring-sky-800 focus:border-sky-800 sm:text-sm">
            @foreach ($contexts as $context)
                <option value="{{ $context->id }}" data-context="{{ $context->description }}">{{ $context->description }}
                </option>
            @endforeach
        </select>
    @endif

</section>
