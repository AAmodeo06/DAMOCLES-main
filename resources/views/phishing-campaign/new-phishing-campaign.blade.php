<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row item-center gap-3">
            <!-- Back to phishing campaign -->
            <a href="{{ route('phishing-campaign.index') }}" class="cursor-pointer">
                <x-primary-button>
                    @lang('phishing-campaign.newPhishingCampaign.back')
                </x-primary-button>
            </a>
            <!-- Breadcrumb -->
            <ul class="flex flex-row gap-1 flex-wrap break-words text-sky-800">
                <li><a href="{{ route('phishing-campaign.index') }}">@lang('phishing-campaign.newPhishingCampaign.phishingCampaign')</a></li>
                <li>/</li>
                <li><a href="{{ route('phishing-campaign.new') }}">@lang('phishing-campaign.newPhishingCampaign.new')</a></li>
            </ul>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white sm:overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-8 text-sky-900">

                    <div class="space-y-4">
                        <p class="font-semibold text-xl">@lang('phishing-campaign.newPhishingCampaign.new')</p>
                        <p class="font-semibold text-sm">@lang('phishing-campaign.newPhishingCampaign.mandatoryField')</p>
                        <div>
                            <p class="text-lg font-medium text-sky-900">
                                *@lang('phishing-campaign.newPhishingCampaign.title'):
                            </p>
                            <x-input-label for="title" class="text-md block font-medium text-sky-700 pb-2"
                                :value="__('phishing-campaign.newPhishingCampaign.value.title')" />
                            <input type="text" id="title" name="title"
                                class="border border-sky-700 focus:border-sky-800 focus:ring-sky-800 rounded-md w-full sm:w-2/3"
                                required>
                        </div>

                        <div>
                            <p class="text-lg font-medium text-sky-900">
                                *@lang('phishing-campaign.newPhishingCampaign.description'):
                            </p>
                            <x-input-label for="description" class="text-md block font-medium text-sky-700 pb-2"
                                :value="__('phishing-campaign.newPhishingCampaign.value.description')" />
                            <input type="text" id="description" name="description"
                                class="border border-sky-700 focus:border-sky-800 focus:ring-sky-800 rounded-md w-full"
                                required>
                        </div>

                        <div>
                            <p class="text-lg font-medium text-sky-900">
                                *@lang('phishing-campaign.newPhishingCampaign.expirationDate'):
                            </p>
                            <x-input-label for="expiration-date" class="text-md block font-medium text-sky-700 pb-2"
                                :value="__('phishing-campaign.newPhishingCampaign.value.expirationDate')" />
                            <input type="date" id="expirationDate" name="expirationDate"
                                class="border border-sky-700 focus:border-sky-800 focus:ring-sky-800 rounded-md cursor-pointer"
                                required>
                        </div>

                        <div id="emailsDiv">
                            <p class="text-lg font-medium text-sky-900">
                                @lang('phishing-campaign.newPhishingCampaign.numbersEmail')
                            </p>
                            <input type="number" id="numberEmails" name="numberEmails" min="1" max="10"
                                step="1" value="1"
                                class="border border-sky-700 focus:border-sky-800 focus:ring-sky-800 rounded-md"
                                required>
                        </div>

                        <div id="timingDiv" class="hidden">
                            <p class="text-lg font-medium text-sky-900">
                                @lang('phishing-campaign.newPhishingCampaign.timing')
                            </p>

                            <input type="number" id="timingEmail" name="timingEmail" min="1" max="180"
                                step="1" value="1"
                                class="border border-sky-700 focus:border-sky-800 focus:ring-sky-800 rounded-md"
                                required>
                            <span id="timingUnit">day</span>
                        </div>

                        <div>
                            @include('phishing-campaign.partials.context-partials.phishing-context')
                        </div>

                        <div>
                            @include('phishing-campaign.partials.persuasion-partials.phishing-persuasion')
                        </div>

                        <div>
                            @include('phishing-campaign.partials.emotional-trigger-partials.phishing-emotional-trigger')
                        </div>

                        <div>
                            @include('phishing-campaign.partials.phishing-llm')
                        </div>

                        <div>
                            <!-- LLM prompt -->
                            <label for="llmPrompt"
                                class="block text-sm font-bold text-sky-700">@lang('phishing-campaign.newPhishingCampaign.prompt'):</label>
                            <textarea id="llmPrompt" name="llmPrompt"
                                class="w-full p-2 border border-sky-700 focus:border-sky-800 focus:ring-sky-800 rounded-md shadow-sm"
                                rows="10"></textarea>
                        </div>
                    </div>

                    <form id="generateCampaignForm" data-id="" action="{{ route('phishing-campaign.create') }}"
                        method="POST">
                        @csrf
                        @method('post')

                        <input type="hidden" name="title" id="titleInput">
                        <input type="hidden" name="description" id="descriptionInput">
                        <input type="hidden" name="numberEmails" id="numberEmailsInput">
                        <input type="hidden" name="contextId" id="contextIdInput">
                        <input type="hidden" name="emotionalTriggers" id="emotionalTriggersInput">
                        <input type="hidden" name="persuasions" id="persuasionsInput">
                        <input type="hidden" name="llmId" id="llmIdInput">
                        <input type="hidden" name="prompt" id="promptInput">
                        <input type="hidden" name="evaluatorId" id="evaluatorIdInput" value="{{ auth()->user()->id }}">
                        <input type="hidden" name="state" id="stateInput" value="Draft">
                        <input type="hidden" name="expirationDate" id="expirationDateInput">
                        <input type="hidden" name="timingEmail" id="timingEmailInput">

                        <div class="flex flex-row justify-around items-center pt-6">
                            <div class="flex w-1/3">
                            </div>
                            <!-- Circles which indicates the steps of the creation -->
                            <div class="flex flex-row w-1/3 justify-center items-center">
                                <span class="status active"></span>
                                <span class="status"></span>
                                <span class="status"></span>
                            </div>
                            <div class="flex w-1/3 justify-center">
                                <x-primary-button id="generateEmail"
                                    type="submit">@lang('phishing-campaign.generate')</x-primary-button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>

        <!-- Loading screen -->
        <div id="loadingOverlay"
            class="fixed top-0 left-0 w-full h-full bg-gray-900 bg-opacity-50 items-center justify-center z-50 hidden">
            <div class="loader ease-linear rounded-full border-8 border-t-8 h-32 w-32"></div>
        </div>
    </div>
</x-app-layout>

<!-- Error modal -->
<!-- Error data modal -->
<x-modal name="error-data-modal" id="error-data-modal" title="Error data" :show="false">
    <div class="p-6 rounded-lg relative text-center">
        <p class="text-2xl font-semibold text-red-700 pb-8">@lang('phishing-campaign.newPhishingCampaign.errorData')</p>
        <x-secondary-button x-on:click="$dispatch('close')">@lang('phishing-campaign.newPhishingCampaign.close')</x-secondary-button>
    </div>
</x-modal>

<!-- Error date modal -->
<x-modal name="error-date-modal" id="error-date-modal" title="Error date" :show="false">
    <div class="p-6 rounded-lg relative text-center">
        <p class="text-2xl font-semibold text-red-700 pb-8">@lang('phishing-campaign.newPhishingCampaign.errorDate')</p>
        <x-secondary-button x-on:click="$dispatch('close')">@lang('phishing-campaign.newPhishingCampaign.close')</x-secondary-button>
    </div>
</x-modal>

<!-- Error llm modal -->
<x-modal name="error-llm-modal" id="error-llm-modal" title="Error llm" :show="false">
    <div class="p-6 rounded-lg relative text-center">
        <p class="text-2xl font-semibold text-red-700 pb-8">@lang('phishing-campaign.newPhishingCampaign.noLLMs')</p>
        <x-secondary-button x-on:click="$dispatch('close')">@lang('phishing-campaign.newPhishingCampaign.close')</x-secondary-button>
    </div>
</x-modal>

<script>
    // Show timingDiv
    document.addEventListener('DOMContentLoaded', function() {
        const numberEmailsInput = document.getElementById('numberEmails');
        const timingDiv = document.getElementById('timingDiv');

        numberEmailsInput.addEventListener('input', function() {
            const numberEmailsValue = parseInt(numberEmailsInput.value);

            if (numberEmailsValue > 1) {
                timingDiv.classList.remove('hidden');
                timingDiv.classList.add('block');
            } else {
                timingDiv.classList.remove('block');
                timingDiv.classList.add('hidden');
            }
        });
    });

    const timingInput = document.getElementById('timingEmail');
    const timingUnitSpan = document.getElementById('timingUnit');

    timingInput.addEventListener('input', function() {
        timingUnitSpan.textContent = timingInput.value == 1 ? 'day' : 'days';
    });

    document.addEventListener('DOMContentLoaded', function() {
        const generateCampaignForm = document.getElementById('generateCampaignForm');

        const titleInput = document.getElementById('title');
        const descriptionInput = document.getElementById('description');
        const expirationDateInput = document.getElementById('expirationDate');
        const timingEmailInput = document.getElementById('timingEmail');
        const numberEmailsInput = document.getElementById('numberEmails');
        const llmSelected = document.getElementById('llmSelect');
        const llmPromptTextarea = document.getElementById('llmPrompt');
        const generateEmailButton = document.getElementById('generateEmail');
        const errorModal = document.getElementById('error-data-modal');

        const contextIdSelect = document.getElementById('contextIdSelect');
        const persuasionButtons = document.querySelectorAll('.persuasion-button');
        const emotionalTriggerButtons = document.querySelectorAll('.emotional-trigger-button');

        let selectedPersuasions = [];
        let selectedEmotionalTriggers = [];

        const today = new Date().toISOString().split('T')[0];
        expirationDateInput.setAttribute('min', today);

        function updateTextarea() {
            const selectedContext = contextIdSelect ? contextIdSelect.options[contextIdSelect.selectedIndex]
                .getAttribute('data-context') : '';
            const selectedPersuasionsDescriptions = Array.from(document.querySelectorAll(
                '.persuasion-button.bg-sky-800')).map(
                button => button.getAttribute('data-persuasion')
            );
            const selectedEmotionalTriggersDescriptions = Array.from(document.querySelectorAll(
                '.emotional-trigger-button.bg-sky-800')).map(
                button => button.getAttribute('data-emotional-trigger')
            );

            let selectedText =
                `Please provide an example of a phishing email with a subject (${titleInput.value}) and body (${descriptionInput.value}) that focuses on ${selectedContext}`;

            if (titleInput) {
                titleInput.addEventListener('input', updateTextarea);
            }
            if (descriptionInput) {
                descriptionInput.addEventListener('input', updateTextarea);
            }

            if (selectedPersuasionsDescriptions.length > 0) {
                selectedText += `, utilizes the Cialdini's persuasion principle` + (
                        selectedPersuasionsDescriptions.length > 1 ? "s" : "") +
                    ` of ${selectedPersuasionsDescriptions.join(', ')}`;
            }

            if (selectedEmotionalTriggersDescriptions.length > 0) {
                selectedText += `, and emotional trigger` + (selectedEmotionalTriggersDescriptions.length > 1 ?
                    "s" : "") + ` of ${selectedEmotionalTriggersDescriptions.join(', ')}`;
            }

            selectedText += `.`;

            llmPromptTextarea.value = selectedText.trim();
        }

        function toggleSelection(element, dataAttribute, selectedArray) {
            const value = element.getAttribute(dataAttribute);

            if (selectedArray.includes(value)) {
                selectedArray.splice(selectedArray.indexOf(value), 1);
                element.classList.remove('bg-sky-800', 'text-white');
                element.classList.add('bg-white', 'text-sky-800');
            } else {
                selectedArray.push(value);
                element.classList.remove('bg-white', 'text-sky-800');
                element.classList.add('bg-sky-800', 'text-white');
            }

            updateTextarea();
        }

        function updateGenerateButtonText() {
            const numberEmails = numberEmailsInput.value;
            if (numberEmails > 1) {
                generateEmailButton.textContent = "{{ __('Generate emails') }}";
            } else {
                generateEmailButton.textContent = "{{ __('Generate email') }}";
            }
        }

        if (contextIdSelect) {
            contextIdSelect.addEventListener('change', updateTextarea);
        }

        if (persuasionButtons) {
            persuasionButtons.forEach(button => {
                button.addEventListener('click', function() {
                    toggleSelection(this, 'data-persuasion', selectedPersuasions);
                });
            });
        }

        if (emotionalTriggerButtons) {
            emotionalTriggerButtons.forEach(button => {
                button.addEventListener('click', function() {
                    toggleSelection(this, 'data-emotional-trigger', selectedEmotionalTriggers);
                });
            });
        }

        if (numberEmailsInput) {
            numberEmailsInput.addEventListener('change', updateGenerateButtonText);
        }

        generateCampaignForm.addEventListener('submit', function(event) {
            event.preventDefault();

            const title = titleInput.value.trim();
            const description = descriptionInput.value.trim();
            const expirationDate = expirationDateInput.value;
            const timingEmail = timingEmailInput.value;
            const numberEmails = numberEmailsInput.value;

            if (title === '' || description === '' || expirationDate === '' || timingEmail === '') {
                showErrorModal();
                return;
            }

            const selectedDate = new Date(expirationDate);
            const todayDate = new Date(today);

            if (selectedDate < todayDate) {
                showErrorDateModal();
                return;
            }

            if (!document.getElementById('llmSelect')) {
                showErrorLLMModal();
                return;
            }

            document.getElementById('loadingOverlay').classList.add('flex');
            document.getElementById('loadingOverlay').classList.remove('hidden');

            const selectedContext = contextIdSelect ? contextIdSelect.value : '';
            const selectedPersuasionIds = Array.from(document.querySelectorAll(
                '.persuasion-button.bg-sky-800')).map(button => button.value);
            const selectedEmotionalTriggerIds = Array.from(document.querySelectorAll(
                '.emotional-trigger-button.bg-sky-800')).map(button => button.value);

            document.getElementById('titleInput').value = title;
            document.getElementById('descriptionInput').value = description;
            document.getElementById('numberEmailsInput').value = numberEmails;
            document.getElementById('contextIdInput').value = selectedContext;
            document.getElementById('emotionalTriggersInput').value = selectedEmotionalTriggerIds.join(
                ',');
            document.getElementById('persuasionsInput').value = selectedPersuasionIds.join(',');
            document.getElementById('llmIdInput').value = llmSelected.value;

            document.getElementById('promptInput').value = llmPromptTextarea.value;

            document.getElementById('expirationDateInput').value = expirationDate;
            document.getElementById('timingEmailInput').value = timingEmail;

            this.submit();
        });

        function showErrorModal() {
            const errorModal = new CustomEvent('open-modal', {
                detail: 'error-data-modal'
            });
            window.dispatchEvent(errorModal);
        }

        function showErrorDateModal() {
            const errorModal = new CustomEvent('open-modal', {
                detail: 'error-date-modal'
            });
            window.dispatchEvent(errorModal);
        }

        function showErrorLLMModal() {
            const errorModal = new CustomEvent('open-modal', {
                detail: 'error-llm-modal'
            });
            window.dispatchEvent(errorModal);
        }

        updateTextarea();
        updateGenerateButtonText();
    });
</script>
