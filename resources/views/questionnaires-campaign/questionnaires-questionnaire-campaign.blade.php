<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row item-center gap-3">
            <!-- Back to questionnaires campaign -->
            <a href="{{ route('questionnaires-campaign.index') }}" class="cursor-pointer">
                <x-primary-button>
                    @lang('questionnaire-campaign.questionnairesChoose.back')
                </x-primary-button>
            </a>
            <!-- Breadcrumb -->
            <ul class="flex flex-row gap-1 flex-wrap break-words text-sky-800">
                <li><a href="{{ route('questionnaires-campaign.index') }}">@lang('questionnaire-campaign.questionnairesChoose.questionnaireCampaign')</a></li>
                <li>/</li>
                <li><a href="{{ route('questionnaires-campaign.new') }}">@lang('questionnaire-campaign.questionnairesChoose.new')</a></li>
                <li>/</li>
                <li>@lang('questionnaire-campaign.questionnairesChoose.selectQuestionnaires')</li>
            </ul>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white sm:overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-8 text-sky-900">

                    <div class="space-y-6">
                        <div>
                            <p class="text-lg font-medium text-sky-900">
                                @lang('questionnaire-campaign.questionnairesChoose.questionnaires'):
                            </p>
                            @if ($questionnaires->isEmpty())
                                <p class="text-center">@lang('questionnaire-campaign.questionnairesChoose.noQuestionnaires')</p>
                            @else
                                <x-input-label for="questionnaireSelect"
                                    class="text-md block font-medium text-sky-700 pb-2" :value="__(
                                        'questionnaire-campaign.questionnairesChoose.valueSelectQuestionnaires',
                                    )" />
                                <div id="questionnaireButtons" class="flex flex-wrap gap-2">
                                    @foreach ($questionnaires as $questionnaire)
                                        <button type="button"
                                            class="questionnaire-button py-2 px-4 border border-sky-800 bg-white rounded-md shadow-sm focus:outline-none focus:ring-sky-800 focus:border-sky-800 sm:text-sm"
                                            data-questionnaire-id="{{ $questionnaire->id }}">
                                            {{ $questionnaire->name }}
                                        </button>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>

                    <form id="questionnairesQuestionnaireCampaignForm"
                        action="{{ route('questionnaire-campaign.questionnaires-questionnaire-campaign') }}"
                        method="POST">
                        @csrf
                        @method('post')

                        <input type="hidden" name="questionnaireCampaignId" id="questionnaireCampaignIdInput"
                            value="{{ $questionnaireCampaignId }}">
                        <input type="hidden" name="questionnairesIds" id="questionnairesIdsInput">

                        <div class="flex flex-row justify-around items-center pt-6">
                            <div class="flex w-1/3">
                            </div>
                            <!-- Circles which indicates the steps of the creation -->
                            <div class="flex flex-row w-1/3 justify-center items-center">
                                <span class="status"></span>
                                <span class="status active"></span>
                                <span class="status"></span>
                            </div>
                            <div class="flex w-1/3 justify-center">
                                <x-primary-button type="submit">@lang('questionnaire-campaign.questionnairesChoose.chooseUsers')</x-primary-button>
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
<x-modal name="error-modal" id="error-modal" title="Choose a user!" :show="false">
    <div class="p-6 rounded-lg relative text-center">
        <p class="text-2xl font-semibold text-red-700 pb-8">@lang('questionnaire-campaign.questionnairesChoose.chooseQuestionnaires')</p>
        <x-secondary-button x-on:click="$dispatch('close')">@lang('questionnaire-campaign.questionnairesChoose.close')</x-secondary-button>
    </div>
</x-modal>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const questionnairesQuestionnaireCampaignForm = document.getElementById(
            'questionnairesQuestionnaireCampaignForm');
        const questionnaireButtons = document.querySelectorAll('.questionnaire-button');
        const errorModal = document.getElementById('error-modal');

        let selectedQuestionnaires = [];

        questionnaireButtons.forEach(button => {
            button.addEventListener('click', function() {
                toggleSelection(this);
            });
        });

        function toggleSelection(button) {
            const questionnaireId = button.getAttribute('data-questionnaire-id');

            if (selectedQuestionnaires.includes(questionnaireId)) {
                selectedQuestionnaires = selectedQuestionnaires.filter(id => id !== questionnaireId);
                button.classList.remove('bg-sky-800', 'text-white');
                button.classList.add('bg-white', 'text-sky-800');
            } else {
                selectedQuestionnaires.push(questionnaireId);
                button.classList.remove('bg-white', 'text-sky-800');
                button.classList.add('bg-sky-800', 'text-white');
            }
        }

        questionnairesQuestionnaireCampaignForm.addEventListener('submit', function(event) {
            event.preventDefault();

            if (selectedQuestionnaires.length === 0) {
                const modalEvent = new CustomEvent('open-modal', {
                    detail: 'error-modal'
                });
                window.dispatchEvent(modalEvent);
                return;
            }

            document.getElementById('loadingOverlay').classList.add('flex');
            document.getElementById('loadingOverlay').classList.remove('hidden');

            document.getElementById('questionnairesIdsInput').value = selectedQuestionnaires.join(',');

            this.submit();
        });

    });
</script>
