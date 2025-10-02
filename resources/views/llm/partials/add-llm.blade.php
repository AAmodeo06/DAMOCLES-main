<section class="text-sky-800">
    <div class="flex flex-col md:flex-row space-y-3 sm:space-y-0 sm:justify-between">
        <!-- Add new LLM -->
        <p class="text-xl font-semibold">@lang('llm.addLLM.newLLM')</p>
        <!-- Help modal -->
        <button x-data="" @click="$dispatch('open-modal', 'help-modal')">
            @lang('llm.addLLM.llmChose')
        </button>
    </div>
    <div class="pt-4">
        <form id="addLLMForm" action="{{ route('llm.create') }}" method="POST">
            @csrf
            @method('post')

            <div class="space-y-4 mb-4">
                <div>
                    <p>@lang('llm.addLLM.addEndpoint'):</p>
                    <input required type="text" id="endpoint" name="endpoint"
                        class="p-2 border border-sky-800 focus:border-sky-800 focus:ring-sky-800 rounded-md shadow-sm w-full placeholder:text-sky-700"
                        placeholder="@lang('llm.addLLM.placeholder.enterEndpoint')">
                </div>
                <div>
                    <p>@lang('llm.addLLM.addProvider'):</p>
                    <input required type="text" id="provider" name="provider"
                        class="p-2 border border-sky-800 focus:border-sky-800 focus:ring-sky-800 rounded-md shadow-sm w-full placeholder:text-sky-700"
                        placeholder="@lang('llm.addLLM.placeholder.enterProvider')">
                </div>
                <div>
                    <p>@lang('llm.addLLM.addModel'):</p>
                    <input required type="text" id="model" name="model"
                        class="p-2 border border-sky-800 focus:border-sky-800 focus:ring-sky-800 rounded-md shadow-sm w-full placeholder:text-sky-700"
                        placeholder="@lang('llm.addLLM.placeholder.enterModel')">
                </div>
            </div>
            <div class="flex justify-end gap-3">
                <x-secondary-button x-on:click="$dispatch('close')">@lang('llm.addLLM.cancel')</x-secondary-button>
                <x-primary-button type="submit">@lang('llm.addLLM.confirm')</x-primary-button>
            </div>
        </form>
    </div>
</section>

<!-- Help modal -->
<x-modal name="help-modal" id="help-modal" title="Help" :show="false">
    <div class="p-4 rounded-lg relative space-y-6">
        @include('llm.partials.help-llm')
    </div>
</x-modal>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('addLLMForm').addEventListener('submit', function(event) {
            document.getElementById('loadingOverlay').classList.add('flex');
            document.getElementById('loadingOverlay').classList.remove('hidden');
        });
    });
</script>
