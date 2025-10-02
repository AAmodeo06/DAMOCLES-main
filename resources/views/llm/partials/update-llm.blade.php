<section class="text-sky-800">
    <!-- Edit LLM -->
    <p class="text-xl font-semibold text-center">@lang('llm.updateLLM.update')</p>

    <div class="pt-4">
        <form id="updateLLMForm" data-id="" action="{{ route('llm.update', ['llm' => 'id']) }}" method="POST">
            @csrf
            @method('put')

            <div class="space-y-4 mb-4">
                <div>
                    <x-input-label for="endpoint" :value="__('llm.updateLLM.value.endpoint')" />
                    <x-text-input id="endpointUpdate" name="endpoint" type="text" class="mt-1 block w-full"
                        :value="old('endpoint')" required autofocus autocomplete="endpoint" />
                    <x-input-error class="mt-2" :messages="$errors->get('endpoint')" />
                </div>
                <div>
                    <x-input-label for="provider" :value="__('llm.updateLLM.value.provider')" />
                    <x-text-input id="providerUpdate" name="provider" type="text" class="mt-1 block w-full"
                        :value="old('provider')" required autofocus autocomplete="provider" />
                    <x-input-error class="mt-2" :messages="$errors->get('provider')" />
                </div>
                <div>
                    <x-input-label for="model" :value="__('llm.updateLLM.value.model')" />
                    <x-text-input id="modelUpdate" name="model" type="text" class="mt-1 block w-full"
                        :value="old('model')" required autofocus autocomplete="model" />
                    <x-input-error class="mt-2" :messages="$errors->get('model')" />
                </div>
            </div>

            <div class="flex justify-end gap-3">
                <x-secondary-button x-on:click="$dispatch('close')">@lang('llm.updateLLM.cancel')</x-secondary-button>
                <x-primary-button type="submit">@lang('llm.updateLLM.confirm')</x-primary-button>
            </div>
        </form>
    </div>
</section>

<script>
    var llms = {!! $llms->toJson() !!};

    document.addEventListener('DOMContentLoaded', function() {
        const updateButtons = document.querySelectorAll('[data-id]');

        updateButtons.forEach(button => {
            button.addEventListener('click', function() {
                const id = button.getAttribute('data-id');
                const updateLLMForm = document.getElementById('updateLLMForm');
                const actionUrl = "{{ route('llm.update', ['llm' => 'id']) }}";

                updateLLMForm.setAttribute('data-id', id);
                updateLLMForm.action = actionUrl.replace('id', id);
            });
        });

        document.getElementById('updateLLMForm').addEventListener('submit', function(event) {
            document.getElementById('loadingOverlay').classList.add('flex');
            document.getElementById('loadingOverlay').classList.remove('hidden');
        });

    });

    function fillUpdateModal(llm) {
        const endpointInput = document.getElementById('endpointUpdate');
        const providerInput = document.getElementById('providerUpdate');
        const modelInput = document.getElementById('modelUpdate');

        endpointInput.value = llm.endpoint;
        providerInput.value = llm.provider;
        modelInput.value = llm.model;
    }
</script>
