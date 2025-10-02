<section class="text-sky-800">
    <!-- Delete LLM -->
    <p class="text-xl font-semibold text-center">@lang('llm.deleteLLM.deleteLLm')</p>
    <div class="pt-4">
        <form id="deleteLLMForm" data-id="" action="{{ route('llm.destroy', ['llm' => 'id']) }}" method="POST">
            @csrf
            @method('delete')
            <p class="pb-4">@lang('llm.deleteLLM.confirmDelete')</p>
            <div class="flex justify-end gap-3">
                <x-secondary-button x-on:click="$dispatch('close')">@lang('llm.deleteLLM.cancel')</x-secondary-button>
                <x-danger-button type="submit">@lang('llm.deleteLLM.confirm')</x-danger-button>
            </div>
        </form>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const deleteButtons = document.querySelectorAll('[data-id]');

        deleteButtons.forEach(button => {
            button.addEventListener('click', function() {
                const id = button.getAttribute('data-id');
                const deleteLLMForm = document.getElementById('deleteLLMForm');
                const actionUrl = "{{ route('llm.destroy', ['llm' => 'id']) }}";

                deleteLLMForm.setAttribute('data-id', id);
                deleteLLMForm.action = actionUrl.replace('id', id);
            });
        });

        document.getElementById('deleteLLMForm').addEventListener('submit', function(event) {
            document.getElementById('loadingOverlay').classList.add('flex');
            document.getElementById('loadingOverlay').classList.remove('hidden');
        });
    });
</script>
