<section class="text-sky-800">
    <!-- Help section -->
    <p class="text-xl font-semibold text-center">@lang('llm.helpLLM.help')</p>

    <div class="pt-4">

        <p>@lang('llm.helpLLM.description')</p>

        <div class="flex items-center justify-center py-4 space-x-4 w-full">
            <div>
                <a href="https://platform.openai.com/docs/overview"
                    target="_blank"><x-primary-button>OpenAI</x-primary-button></a>
            </div>
            <div>
                <a href="https://ai.google.dev/gemini-api/docs?hl=it"
                    target="_blank"><x-primary-button>Gemini</x-primary-button></a>
            </div>
            <div>
                <a href="https://docs.anthropic.com/en/docs/intro-to-claude"
                    target="_blank"><x-primary-button>Claude</x-primary-button></a>
            </div>
        </div>

        <div class="flex justify-end gap-3">
            <x-secondary-button x-on:click="$dispatch('close')">@lang('llm.helpLLM.close')</x-secondary-button>
        </div>
    </div>
</section>
