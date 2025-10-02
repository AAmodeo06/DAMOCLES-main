<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row item-center gap-3">
            <!-- Back to questionnaires campaign -->
            <a href="{{ route('questionnaires-campaign.index') }}" class="cursor-pointer">
                <x-primary-button>
                    @lang('questionnaire-campaign.newQuestionnaireCampaign.back')
                </x-primary-button>
            </a>
            <!-- Breadcrumb -->
            <ul class="flex flex-row gap-1 flex-wrap break-words text-sky-800">
                <li><a href="{{ route('questionnaires-campaign.index') }}">@lang('questionnaire-campaign.newQuestionnaireCampaign.questionnaireCampaign')</a></li>
                <li>/</li>
                <li><a href="{{ route('questionnaires-campaign.new') }}">@lang('questionnaire-campaign.newQuestionnaireCampaign.new')</a></li>
            </ul>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white sm:overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-8 text-sky-900">

                    <div class="space-y-6">
                        <p class="font-semibold text-xl">@lang('questionnaire-campaign.newQuestionnaireCampaign.new')</p>
                        <p class="font-semibold text-sm">@lang('questionnaire-campaign.newQuestionnaireCampaign.mandatoryField')</p>
                        <div>
                            <p class="text-lg font-medium text-sky-900">
                                *@lang('questionnaire-campaign.newQuestionnaireCampaign.title'):
                            </p>
                            <x-input-label for="title" class="text-md block font-medium text-sky-700 pb-2"
                                :value="__('questionnaire-campaign.newQuestionnaireCampaign.value.title')" />
                            <input type="text" id="title" name="title"
                                class="border border-sky-700 focus:border-sky-800 focus:ring-sky-800 rounded-md w-full sm:w-2/3"
                                required>
                        </div>

                        <div>
                            <p class="text-lg font-medium text-sky-900">
                                *@lang('questionnaire-campaign.newQuestionnaireCampaign.description'):
                            </p>
                            <x-input-label for="description" class="text-md block font-medium text-sky-700 pb-2"
                                :value="__('questionnaire-campaign.newQuestionnaireCampaign.value.description')" />
                            <input type="text" id="description" name="description"
                                class="border border-sky-700 focus:border-sky-800 focus:ring-sky-800 rounded-md w-full"
                                required>
                        </div>

                        <div>
                            <p class="text-lg font-medium text-sky-900">
                                *@lang('questionnaire-campaign.newQuestionnaireCampaign.expirationDate'):
                            </p>
                            <x-input-label for="expiration-date"
                                class="text-md block font-medium text-sky-700 pb-2 curs" :value="__('questionnaire-campaign.newQuestionnaireCampaign.value.expirationDate')" />
                            <input type="date" id="expirationDate" name="expirationDate"
                                class="border border-sky-700 focus:border-sky-800 focus:ring-sky-800 rounded-md cursor-pointer"
                                required>
                        </div>

                    </div>

                    <form id="createCampaignForm" action="{{ route('questionnaire-campaign.create') }}" method="POST">
                        @csrf
                        @method('post')

                        <input type="hidden" name="title" id="titleInput">
                        <input type="hidden" name="description" id="descriptionInput">
                        <input type="hidden" name="evaluatorId" id="evaluatorIdInput" value="{{ auth()->user()->id }}">
                        <input type="hidden" name="state" id="stateInput" value="Draft">
                        <input type="hidden" name="expirationDate" id="expirationDateInput">

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
                                <x-primary-button type="submit">@lang('questionnaire-campaign.newQuestionnaireCampaign.chooseQuestionnaires')</x-primary-button>
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
        <p class="text-2xl font-semibold text-red-700 pb-8">@lang('questionnaire-campaign.newQuestionnaireCampaign.errorData')</p>
        <x-secondary-button x-on:click="$dispatch('close')">@lang('questionnaire-campaign.newQuestionnaireCampaign.close')</x-secondary-button>
    </div>
</x-modal>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const createCampaignForm = document.getElementById('createCampaignForm');
        const titleInput = document.getElementById('title');
        const descriptionInput = document.getElementById('description');
        const expirationDateInput = document.getElementById('expirationDate');
        const errorModal = document.getElementById('error-modal');

        const today = new Date().toISOString().split('T')[0];
        expirationDateInput.setAttribute('min', today);

        createCampaignForm.addEventListener('submit', function(event) {
            event.preventDefault();

            const title = titleInput.value.trim();
            const description = descriptionInput.value.trim();
            const expirationDate = expirationDateInput.value;

            if (title === '' || description === '' || expirationDate === '') {
                const modalEvent = new CustomEvent('open-modal', {
                    detail: 'error-modal'
                });
                window.dispatchEvent(modalEvent);
                return;
            }

            const selectedDate = new Date(expirationDate);
            const todayDate = new Date(today);

            if (selectedDate < todayDate) {
                const modalEvent = new CustomEvent('open-modal', {
                    detail: 'error-modal'
                });
                window.dispatchEvent(modalEvent);
                return;
            }

            document.getElementById('loadingOverlay').classList.add('flex');
            document.getElementById('loadingOverlay').classList.remove('hidden');

            document.getElementById('titleInput').value = title;
            document.getElementById('descriptionInput').value = description;
            document.getElementById('expirationDateInput').value = expirationDate;

            this.submit();
        });
    });
</script>
