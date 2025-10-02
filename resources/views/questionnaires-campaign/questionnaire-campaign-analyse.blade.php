<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row item-center gap-3">
            <!-- Back to questionnaire campaign details -->
            <a href="{{ route('questionnaires-campaign.index') }}" class="cursor-pointer">
                <x-primary-button>
                    @lang('questionnaire-campaign.analyseCampaign.back')
                </x-primary-button>
            </a>
            <!-- Breadcrumb -->
            <ul class="flex flex-row gap-1 flex-wrap break-words text-sky-800">
                <li><a href="{{ route('questionnaires-campaign.index') }}">@lang('questionnaire-campaign.analyseCampaign.questionnaireCampaign')</a></li>
                <li>/</li>
                <li>@lang('questionnaire-campaign.analyseCampaign.analyse')</li>
            </ul>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-8 text-sky-900">
                    <div class="flex flex-col w-full">
                        <p class="font-semibold text-xl">@lang('questionnaire-campaign.analyseCampaign.analyses')</p>

                        <!-- Charts -->
                        <div
                            class="flex flex-col py-2 space-y-4 md:space-y-0 md:flex-row md:justify-around w-full items-center">
                            @foreach ($questionnaires as $questionnaire)
                                <div class="flex flex-col items-center w-60 md:w-64">
                                    <canvas id="chart-{{ $questionnaire->id }}"></canvas>
                                </div>
                            @endforeach
                        </div>

                        <!-- Filter -->
                        @if ($users->count() > 1)
                            <div class="flex w-full justify-center md:justify-end sm:items-center">
                                <div class="flex flex-row w-80 gap-3 justify-end items-center relative">
                                    <label for="filter"
                                        class="block text-sm font-bold text-sky-700">@lang('questionnaire-campaign.analyseCampaign.search')</label>
                                    <input type="text" id="filter" name="filter"
                                        class="p-2 border border-sky-700 focus:border-sky-800 focus:ring-sky-800 rounded-md shadow-sm w-full placeholder:text-sky-700"
                                        placeholder="@lang('questionnaire-campaign.analyseCampaign.placeholderFilter')">
                                    <button id="clear-filter"
                                        class="hidden absolute right-2 top-1/2 transform -translate-y-1/2 focus:outline-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-sky-600"
                                            viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M10 0a10 10 0 0 1 7.071 2.929A10 10 0 0 1 20 10a10 10 0 0 1-2.929 7.071A10 10 0 0 1 10 20a10 10 0 0 1-7.071-2.929A10 10 0 0 1 0 10a10 10 0 0 1 2.929-7.071A10 10 0 0 1 10 0zm3.536 5.05a.5.5 0 0 1 .708.708L10.707 10l3.536 3.536a.5.5 0 0 1-.708.708L10 10.707l-3.536 3.536a.5.5 0 1 1-.708-.708L9.293 10 5.757 6.464a.5.5 0 0 1 .708-.708L10 9.293l3.536-3.536z" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        @endif

                        <!-- User and Questionnaires Display -->
                        <div id="no-results" class="font-bold py-4 text-center hidden">
                            @lang('questionnaire-campaign.analyseCampaign.noResult')
                        </div>

                        @foreach ($users as $index => $user)
                            <div class="py-4 user-entry" id="user-{{ $user->id }}"
                                style="{{ $index > 0 ? 'display: none;' : '' }}">
                                <div class="flex flex-col">
                                    <p class="font-bold user-name">@lang('questionnaire-campaign.analyseCampaign.user'): {{ $user->name }}
                                        {{ $user->surname }}</p>
                                    <p class="font-bold user-email">@lang('questionnaire-campaign.analyseCampaign.email'): {{ $user->email }}</p>
                                </div>
                                <div class="w-full text-center mb-4">
                                    <table id="email-table-{{ $user->id }}" class="w-full text-center mb-4">
                                        <thead class="bg-gray-100">
                                            <tr class="border-b-2 border-gray-300">
                                                <th class="py-2 px-4">@lang('questionnaire-campaign.analyseCampaign.questionnaire')</th>
                                                <th class="py-2 px-4">@lang('questionnaire-campaign.analyseCampaign.answered')</th>
                                                <th class="py-2 px-4"></th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white">
                                            @foreach ($questionnaires as $questionnaire)
                                                <tr class="border-b border-gray-200">
                                                    <td class="py-2 px-4">{{ $questionnaire->name }}</td>
                                                    <td
                                                        class="py-2 px-4 {{ isset($userAnswers[$user->id][$questionnaire->id]) ? 'text-green-500' : 'text-red-500' }}">
                                                        {{ isset($userAnswers[$user->id][$questionnaire->id]) ? 'Yes' : 'No' }}
                                                    </td>
                                                    @if (isset($userAnswers[$user->id][$questionnaire->id]))
                                                        <td class="py-2 px-4">
                                                            <x-dropdown align="right" width="48">
                                                                <x-slot name="trigger">
                                                                    <button
                                                                        class="inline-flex items-center font-semibold">
                                                                        <p class="classic">
                                                                            @lang('questionnaire-campaign.analyseCampaign.options')
                                                                            <span>
                                                                                <svg class="fill-current h-4 w-4"
                                                                                    xmlns="http://www.w3.org/2000/svg"
                                                                                    viewBox="0 0 20 20">
                                                                                    <path fill-rule="evenodd"
                                                                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                                                        clip-rule="evenodd" />
                                                                                </svg>
                                                                            </span>
                                                                        </p>
                                                                    </button>
                                                                </x-slot>
                                                                <x-slot name="content">
                                                                    <div class="flex flex-col gap-2">
                                                                        @foreach ($userAnswers[$user->id][$questionnaire->id] as $userAnswer)
                                                                            <a href="{{ route(strtolower($questionnaire->name) . '.result', [strtolower($questionnaire->name) => $userAnswer->answer_id]) }}"
                                                                                class="hover:bg-gray-100">
                                                                                <button
                                                                                    class="hover:bg-gray-100">@lang('questionnaire-campaign.analyseCampaign.result')</button>
                                                                            </a>
                                                                            @if ($questionnaireCampaign->state === 'Ongoing')
                                                                                <button class="hover:bg-gray-100"
                                                                                    data-answer-id="{{ $userAnswer->id }}"
                                                                                    x-data=""
                                                                                    @click="$dispatch('open-modal', 'delete-modal', { id: {{ $userAnswer->id }} })">@lang('questionnaire-campaign.analyseCampaign.delete')</button>
                                                                            @endif
                                                                        @endforeach
                                                                    </div>
                                                                </x-slot>
                                                            </x-dropdown>
                                                        </td>
                                                    @endif
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endforeach

                        <!-- Paginator controls -->
                        <div id="pagination-controls" class="flex justify-around items-center">
                            <div class="flex justify-center w-1/3">
                                <x-primary-button id="prevUser">@lang('questionnaire-campaign.analyseCampaign.previous')</x-primary-button>
                            </div>
                            <div class="flex justify-center w-1/3">
                                <span id="userIndicator" class="text-gray-700"></span>
                            </div>
                            <div class="flex justify-center w-1/3">
                                <x-primary-button id="nextUser">@lang('questionnaire-campaign.analyseCampaign.next')</x-primary-button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<!-- Delete modal -->
<x-modal name="delete-modal" id="delete-modal" title="Delete answer" :show="false">
    <div class="p-4 rounded-lg relative">
        @include('questionnaires-campaign.hais.partials.delete-result')
    </div>
</x-modal>

<script>
    // Charts
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize the charts for each questionnaire
        const questionnaires = @json($questionnaires);
        const totalAnswersPerQuestionnaire = @json($totalAnswersPerQuestionnaire);

        questionnaires.forEach(questionnaire => {
            const ctx = document.getElementById(`chart-${questionnaire.id}`).getContext('2d');
            const totalAnswers = @json($users->count());
            const totalAnswersGiven = totalAnswersPerQuestionnaire[questionnaire.id] || 0;
            const unanswered = totalAnswers - totalAnswersGiven;

            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Answered', 'Unanswered'],
                    datasets: [{
                        data: [totalAnswersGiven, unanswered],
                        backgroundColor: ['#4CAF50', '#F44336']
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        title: {
                            display: true,
                            text: `Answers for ${questionnaire.name}`
                        }
                    }
                }
            });
        });
    });

    // Tabulation
    document.addEventListener('DOMContentLoaded', function() {
        const users = @json($users);
        let currentUserIndex = 0;
        const userContainers = document.querySelectorAll(".user-entry");
        const prevUserButton = document.getElementById('prevUser');
        const nextUserButton = document.getElementById('nextUser');
        const userIndicator = document.getElementById('userIndicator');
        const paginationControls = document.getElementById('pagination-controls');

        function toggleNavigationButtons() {
            if (users.length <= 1) {
                prevUserButton.style.display = 'none';
                nextUserButton.style.display = 'none';
            } else {
                prevUserButton.style.display = currentUserIndex > 0 ? 'block' : 'none';
                nextUserButton.style.display = currentUserIndex < users.length - 1 ? 'block' : 'none';
            }
        }

        function showUser(index) {
            userContainers.forEach(function(container, idx) {
                container.style.display = idx === index ? 'block' : 'none';
            });
            userIndicator.textContent = `User: ${index + 1} / ${users.length}`;
            toggleNavigationButtons();
        }

        function resetSearch() {
            filterInput.value = "";
            clearFilterButton.style.display = "none";
            userContainers.forEach(function(container, index) {
                container.style.display = index === 0 ? 'block' : 'none';
            });
            currentUserIndex = 0;
            showUser(currentUserIndex);
            paginationControls.style.display = 'flex';
            noResultsMessage.style.display = 'none';
        }

        prevUserButton.addEventListener('click', function() {
            if (currentUserIndex > 0) {
                currentUserIndex--;
                showUser(currentUserIndex);
            }
        });

        nextUserButton.addEventListener('click', function() {
            if (currentUserIndex < users.length - 1) {
                currentUserIndex++;
                showUser(currentUserIndex);
            }
        });

        // Initialize: show the first user and manage navigation buttons
        showUser(currentUserIndex);

        // Filter handling
        const filterInput = document.getElementById("filter");
        const clearFilterButton = document.getElementById("clear-filter");
        const noResultsMessage = document.getElementById('no-results');

        if (filterInput && clearFilterButton) {
            filterInput.addEventListener("input", function() {
                const filterValue = this.value.toLowerCase().trim();

                clearFilterButton.style.display = this.value.trim() !== "" ? "block" : "none";

                let resultsFound = false;

                userContainers.forEach(function(container, index) {
                    const name = container.querySelector('.user-name').textContent
                        .toLowerCase();
                    const email = container.querySelector('.user-email').textContent
                        .toLowerCase();

                    if (name.includes(filterValue) || email.includes(filterValue)) {
                        container.style.display = 'block';
                        if (index === 0) {
                            showUser(index);
                        }
                        resultsFound = true;
                    } else {
                        container.style.display = 'none';
                    }
                });

                // Show no results
                noResultsMessage.style.display = resultsFound ? 'none' : 'block';

                // Show pagination controls only if there's no active filter
                paginationControls.style.display = filterValue !== "" ? 'none' : 'flex';

                // Reset pagination and show first user if filter is cleared manually
                if (filterValue === "") {
                    resetSearch();
                }
            });

            clearFilterButton.addEventListener("click", function() {
                resetSearch();
            });
        }
    });
</script>
