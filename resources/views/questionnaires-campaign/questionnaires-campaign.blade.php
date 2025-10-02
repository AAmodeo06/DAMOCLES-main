@php
    use Carbon\Carbon;
@endphp

<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row item-center gap-3">
            <!-- Breadcrumb -->
            <ul class="flex flex-row gap-1 flex-wrap break-words text-sky-800">
                <li><a href="{{ route('questionnaires-campaign.index') }}">@lang('questionnaire-campaign.questionnaires')</a></li>
            </ul>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-8 text-sky-900">

                <div
                    class="flex flex-col md:flex-row w-full space-y-2 md:space-y-0 sm:justify-between items-center mb-6">
                    <p class="font-semibold text-xl">@lang('questionnaire-campaign.questionnaireCampaign')</p>
                    <div>
                        @if ($questionnairesCampaigns->count() > 0)
                            <!-- Filter -->
                            <div class="flex flex-row w-80 gap-3 justify-end items-center relative">
                                <label for="filter"
                                    class="block text-sm font-bold text-sky-700">@lang('questionnaire-campaign.search')</label>
                                <input type="text" id="filter" name="filter"
                                    class="p-2 border border-sky-700 focus:border-sky-800 focus:ring-sky-800 rounded-md shadow-sm w-full placeholder:text-sky-700"
                                    placeholder="@lang('questionnaire-campaign.placeholderFilter')">
                                <button id="clear-filter"
                                    class="hidden absolute right-2 top-1/2 transform -translate-y-1/2 focus:outline-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-sky-600"
                                        viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M10 0a10 10 0 0 1 7.071 2.929A10 10 0 0 1 20 10a10 10 0 0 1-2.929 7.071A10 10 0 0 1 10 20a10 10 0 0 1-7.071-2.929A10 10 0 0 1 0 10a10 10 0 0 1 2.929-7.071A10 10 0 0 1 10 0zm3.536 5.05a.5.5 0 0 1 .708.708L10.707 10l3.536 3.536a.5.5 0 0 1-.708.708L10 10.707l-3.536 3.536a.5.5 0 1 1-.708-.708L9.293 10 5.757 6.464a.5.5 0 0 1 .708-.708L10 9.293l3.536-3.536z" />
                                    </svg>
                                </button>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row w-full items-center justify-between mb-4">
                    <div class="mb-4 sm:mb-0">
                        <p class="font-semibold">@lang('questionnaire-campaign.questionnaireCampaignAvailable')</p>
                    </div>
                    <div>
                        @if (auth()->user()->role === 'Evaluator')
                            <a href="{{ route('questionnaires-campaign.new') }}" class="cursor-pointer">
                                <x-primary-button>
                                    @lang('questionnaire-campaign.new')
                                </x-primary-button>
                            </a>
                        @endif
                    </div>
                </div>

                <!-- Content -->
                @if ($questionnairesCampaigns->count() > 0)

                    <table id="questionnaires-campaign-table" class="min-w-full text-center border-collapse">
                        <thead class="bg-gray-100">
                            <tr class="border-b-2 border-gray-300">
                                <th class="py-2 px-4">@lang('questionnaire-campaign.state')</th>
                                <th class="py-2 px-4">@lang('questionnaire-campaign.title')</th>
                                <th class="py-2 px-4">@lang('questionnaire-campaign.description')</th>
                                <th class="py-2 px-4">@lang('questionnaire-campaign.expirationDate')</th>
                                <th class="py-2 px-4"></th>
                            </tr>
                        </thead>
                        <tbody class="bg-white">
                            @foreach ($questionnairesCampaigns as $questionnaireCampaign)
                                <tr class="hover:bg-gray-100 border-b border-gray-200 cursor-pointer"
                                    onclick="handleRowClick(event, 
                                            '{{ auth()->user()->role === 'User'
                                                ? route('questionnaires-campaign.questionnaire-campaign-join', [
                                                    'questionnaireCampaign' => $questionnaireCampaign->id,
                                                ])
                                                : ($questionnaireCampaign->state == 'Draft' || $questionnaireCampaign->state == 'Ready'
                                                    ? route('questionnaire-campaign.details', ['questionnaireCampaign' => $questionnaireCampaign->id])
                                                    : route('questionnaire-campaign.analyse', ['questionnaireCampaign' => $questionnaireCampaign->id])) }}'
                                            )">
                                    <td
                                        class="w-12 py-2 px-4 font-semibold
                                @if ($questionnaireCampaign->state == 'Draft') text-gray-500 
                                @elseif ($questionnaireCampaign->state == 'Ready') text-green-500 
                                @elseif ($questionnaireCampaign->state == 'Ongoing') text-orange-500 
                                @elseif ($questionnaireCampaign->state == 'Finished') text-red-500 @endif">
                                        {{ $questionnaireCampaign->state }}
                                    </td>
                                    <td class="py-2 px-4">{{ $questionnaireCampaign->title }}</td>
                                    <td class="py-2 px-4">{{ $questionnaireCampaign->description }}</td>
                                    <td class="py-2 px-4">
                                        {{ \Carbon\Carbon::parse($questionnaireCampaign->expirationDate)->format('d/m/Y') }}
                                    </td>
                                    <td class="py-2 px-4">
                                        @if (auth()->user()->role === 'User')
                                            @php
                                                $expirationDate = Carbon::parse($questionnaireCampaign->expirationDate);
                                                $currentDate = Carbon::now();
                                            @endphp

                                            @if ($expirationDate->isPast())
                                                <p>@lang('questionnaire-campaign.expired')</p>
                                            @elseif ($questionnaireCampaign->user_done)
                                                <a href="{{ route('questionnaires-campaign.questionnaire-campaign-join', ['questionnaireCampaign' => $questionnaireCampaign->id]) }}"
                                                    class="inner-element">
                                                    <x-primary-button>
                                                        @lang('questionnaire-campaign.showAnser')
                                                    </x-primary-button>
                                                </a>
                                            @elseif ($questionnaireCampaign->state == 'Finished')
                                                <a href="{{ route('questionnaires-campaign.questionnaire-campaign-join', ['questionnaireCampaign' => $questionnaireCampaign->id]) }}"
                                                    class="inner-element">
                                                    <x-primary-button>
                                                        @lang('questionnaire-campaign.showQuestionnaires')
                                                    </x-primary-button>
                                                </a>
                                            @else
                                                <a href="{{ route('questionnaires-campaign.questionnaire-campaign-join', ['questionnaireCampaign' => $questionnaireCampaign->id]) }}"
                                                    class="inner-element">
                                                    <x-primary-button>
                                                        @lang('questionnaire-campaign.start')
                                                    </x-primary-button>
                                                </a>
                                            @endif
                                        @endif

                                        @if (auth()->user()->role === 'Evaluator')
                                            <x-dropdown align="right" width="48">
                                                <x-slot name="trigger">
                                                    <button
                                                        class="inline-flex items-center font-semibold inner-element">
                                                        <p class="classic">
                                                            @lang('questionnaire-campaign.options')
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
                                                        @if ($questionnaireCampaign->state === 'Ready')
                                                            <button class="hover:bg-gray-100 inner-element"
                                                                data-id="{{ $questionnaireCampaign->id }}"
                                                                x-data=""
                                                                @click="$dispatch('open-modal', 'start-modal', { id: {{ $questionnaireCampaign->id }} })">@lang('questionnaire-campaign.start')</button>
                                                        @endif

                                                        @if ($questionnaireCampaign->state === 'Ongoing')
                                                            <button class="hover:bg-gray-100 inner-element"
                                                                data-id="{{ $questionnaireCampaign->id }}"
                                                                x-data=""
                                                                @click="$dispatch('open-modal', 'stop-modal', { id: {{ $questionnaireCampaign->id }} })">@lang('questionnaire-campaign.stop')</button>

                                                            <a href="{{ route('questionnaire-campaign.analyse', ['questionnaireCampaign' => $questionnaireCampaign->id]) }}"
                                                                class="hover:bg-gray-100 inner-element">
                                                                <button
                                                                    class="hover:bg-gray-100">@lang('questionnaire-campaign.analyse')</button>
                                                            </a>
                                                        @endif

                                                        @if ($questionnaireCampaign->state === 'Finished')
                                                            <a href="{{ route('questionnaire-campaign.analyse', ['questionnaireCampaign' => $questionnaireCampaign->id]) }}"
                                                                class="hover:bg-gray-100 inner-element">
                                                                <button
                                                                    class="hover:bg-gray-100">@lang('questionnaire-campaign.analyse')</button>
                                                            </a>
                                                        @endif

                                                        <a href="{{ route('questionnaire-campaign.details', ['questionnaireCampaign' => $questionnaireCampaign->id]) }}"
                                                            class="hover:bg-gray-100 inner-element">
                                                            <button class="hover:bg-gray-100">
                                                                {{ $questionnaireCampaign->state != 'Draft' ? __('questionnaire-campaign.details') : __('questionnaire-campaign.continue') }}
                                                            </button>
                                                        </a>

                                                        <button class="hover:bg-gray-100 inner-element"
                                                            data-id="{{ $questionnaireCampaign->id }}"
                                                            x-data=""
                                                            @click="$dispatch('open-modal', 'duplicate-modal', { id: {{ $questionnaireCampaign->id }} })">@lang('questionnaire-campaign.duplicate')</button>

                                                        <button class="hover:bg-gray-100 text-red-500 inner-element"
                                                            data-id="{{ $questionnaireCampaign->id }}"
                                                            x-data=""
                                                            @click="$dispatch('open-modal', 'delete-modal', { id: {{ $questionnaireCampaign->id }} })">@lang('questionnaire-campaign.delete')</button>
                                                    </div>
                                                </x-slot>
                                            </x-dropdown>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <!-- Paginator controls -->
                    <div id="pagination-controls" class="flex justify-around items-center mt-4">
                        <div class="flex justify-center w-1/3">
                            <x-primary-button id="prevPage">@lang('questionnaire-campaign.previous')</x-primary-button>
                        </div>
                        <div class="flex flex-row justify-center items-center w-1/3 gap-4">
                            <span id="pageIndicator" class="text-gray-700"></span>
                            <span id="totalCampaigns" class="text-gray-500 text-sm"></span>
                            <select id="rowsPerPage" class="border border-gray-300 rounded-md shadow-sm">
                                <option value="10" selected>10</option>
                                <option value="20">20</option>
                                <option value="50">50</option>
                            </select>
                        </div>
                        <div class="flex justify-center w-1/3">
                            <x-primary-button id="nextPage">@lang('questionnaire-campaign.next')</x-primary-button>
                        </div>
                    </div>
                @else
                    @if (auth()->user()->role === 'User')
                        <p class="pt-4 text-center text-lg text-sky-700">
                            @lang('questionnaire-campaign.noQuestionnairesCampaign')</p>
                    @else
                        <p class="pt-4 text-center text-lg text-sky-700">
                            @lang('questionnaire-campaign.noQuestionnairesCampaign')</p>
                    @endif
                @endif
            </div>
        </div>
    </div>

    <!-- Loading screen -->
    <div id="loadingOverlay"
        class="fixed top-0 left-0 w-full h-full bg-gray-900 bg-opacity-50 items-center justify-center z-50 hidden">
        <div class="loader ease-linear rounded-full border-8 border-t-8 h-32 w-32"></div>
    </div>

</x-app-layout>

<!-- Start modal -->
<x-modal name="start-modal" id="start-modal" title="Start Questionnaire Campaign" :show="false">
    <div class="p-4 rounded-lg relative">
        @include('questionnaires-campaign.modals.start-questionnaire-campaign')
    </div>
</x-modal>

<!-- Start successfully message -->
<x-modal name="start-successfully-modal" id="start-successfully-modal" title="Start successfully modal"
    :show="false">
    <div class="p-4 rounded-lg relative text-center text-sky-800">
        <p class="text-xl font-semibold pb-8">
            @lang('questionnaire-campaign.startSucc')
        </p>

        <div class="flex justify-end">
            <x-secondary-button x-on:click="$dispatch('close')">@lang('questionnaire-campaign.close')</x-secondary-button>
        </div>
    </div>
</x-modal>

<!-- Stop modal -->
<x-modal name="stop-modal" id="stop-modal" title="Stop Questionnaire Campaign" :show="false">
    <div class="p-4 rounded-lg relative">
        @include('questionnaires-campaign.modals.stop-questionnaire-campaign')
    </div>
</x-modal>

<!-- Stop successfully message -->
<x-modal name="stop-successfully-modal" id="stop-successfully-modal" title="Stop successfully modal"
    :show="false">
    <div class="p-4 rounded-lg relative text-center text-sky-800">
        <p class="text-xl font-semibold pb-8">
            @lang('questionnaire-campaign.stopSucc')
        </p>

        <div class="flex justify-end">
            <x-secondary-button x-on:click="$dispatch('close')">@lang('questionnaire-campaign.close')</x-secondary-button>
        </div>
    </div>
</x-modal>

<!-- Duplicate modal -->
<x-modal name="duplicate-modal" id="duplicate-modal" title="Duplicate Questionnaire Campaign" :show="false">
    <div class="p-4 rounded-lg relative">
        @include('questionnaires-campaign.modals.duplicate-questionnaire-campaign')
    </div>
</x-modal>

<!-- Duplicate successfully message -->
<x-modal name="duplicate-successfully-modal" id="duplicate-successfully-modal" title="Duplicate successfully modal"
    :show="false">
    <div class="p-4 rounded-lg relative text-center text-sky-800">
        <p class="text-xl font-semibold pb-8">
            @lang('questionnaire-campaign.close')
        </p>

        <div class="flex justify-end">
            <x-secondary-button x-on:click="$dispatch('close')">@lang('questionnaire-campaign.close')</x-secondary-button>
        </div>
    </div>
</x-modal>

<!-- Delete modal -->
<x-modal name="delete-modal" id="delete-modal" title="Delete Questionnaire Campaign" :show="false">
    <div class="p-4 rounded-lg relative">
        @include('questionnaires-campaign.modals.delete-questionnaire-campaign')
    </div>
</x-modal>

<!-- Delete successfully message -->
<x-modal name="delete-successfully-modal" id="delete-successfully-modal" title="Delete successfully modal"
    :show="false">
    <div class="p-4 rounded-lg relative text-center text-sky-800">
        <p class="text-xl font-semibold pb-8">
            @lang('questionnaire-campaign.deleteSucc')
        </p>

        <div class="flex justify-end">
            <x-secondary-button x-on:click="$dispatch('close')">@lang('questionnaire-campaign.close')</x-secondary-button>
        </div>
    </div>
</x-modal>

<!-- Error modal -->
<x-modal name="error-modal" id="error-modal" title="Error modal" :show="false">
    <div class="p-4 rounded-lg relative text-center text-red-800">
        <p class="text-xl font-semibold pb-8">
            @lang('questionnaire-campaign.tryAgain')
        </p>

        <div class="flex justify-end">
            <x-secondary-button x-on:click="$dispatch('close')">@lang('questionnaire-campaign.close')</x-secondary-button>
        </div>
    </div>
</x-modal>

<!-- Questionnaire completed successfully message -->
<x-modal name="questionnaire-completed-successfully-modal" id="questionnaire-completed-successfully-modal"
    title="Questionnaire completed successfully modal" :show="false">
    <div class="p-4 rounded-lg relative space-y-6 text-sky-800">
        <div class="flex flex-col text-center">
            <p class="text-xl font-semibold pb-4">
                @lang('questionnaire-campaign.completed')
            </p>
            <p class="text-lg pb-4">
                @lang('questionnaire-campaign.seeAnswers')
            </p>
        </div>
        <div class="flex justify-end">
            <x-secondary-button x-on:click="$dispatch('close')">@lang('questionnaire-campaign.close')</x-secondary-button>
        </div>
    </div>
</x-modal>

<script>
    function handleRowClick(event, url) {
        if (!event.target.closest('.inner-element')) {
            location.href = url;
        }
    }

    // Modal options campaign
    document.addEventListener('DOMContentLoaded', function() {
        @if (session('success'))
            @php
                $successMessage = session('success');
            @endphp

            if ("{{ $successMessage }}" === "Campaign start successfully!") {

                const startModalEvent = new CustomEvent('open-modal', {
                    detail: 'start-successfully-modal'
                });
                window.dispatchEvent(startModalEvent);

            } else if ("{{ $successMessage }}" === "Campaign stopped successfully!") {

                const stopModalEvent = new CustomEvent('open-modal', {
                    detail: 'stop-successfully-modal'
                });
                window.dispatchEvent(stopModalEvent);

            } else if ("{{ $successMessage }}" === "Campaign duplicated successfully!") {

                const duplicateModalEvent = new CustomEvent('open-modal', {
                    detail: 'duplicate-successfully-modal'
                });
                window.dispatchEvent(duplicateModalEvent);

            } else if ("{{ $successMessage }}" === "Campaign deleted successfully!") {

                const deleteModalEvent = new CustomEvent('open-modal', {
                    detail: 'delete-successfully-modal'
                });
                window.dispatchEvent(deleteModalEvent);

            } else if ("{{ $successMessage }}" === "Questionnaire completed successfully!") {

                const questionnaireCompletedModalEvent = new CustomEvent('open-modal', {
                    detail: 'questionnaire-completed-successfully-modal'
                });
                window.dispatchEvent(questionnaireCompletedModalEvent);

            }
        @endif

        @if ($errors->any())
            const errorModalEvent = new CustomEvent('open-modal', {
                detail: 'error-modal'
            });
            window.dispatchEvent(errorModalEvent);
        @endif
    });

    // Tabulation
    document.addEventListener('DOMContentLoaded', function() {
        if (document.getElementById('pagination-controls')) {
            const rowsPerPageSelect = document.getElementById('rowsPerPage');
            const pageIndicator = document.getElementById('pageIndicator');
            const totalCampaigns = document.getElementById('totalCampaigns');

            let rowsPerPage = parseInt(rowsPerPageSelect.value);
            let currentPage = 1;
            const table = document.getElementById('questionnaires-campaign-table').getElementsByTagName(
                'tbody')[0];
            const totalRows = table.getElementsByTagName('tr').length;
            let totalPages = Math.ceil(totalRows / rowsPerPage);

            if (totalRows <= 10) {
                pageIndicator.style.display = 'none';
                rowsPerPageSelect.style.display = 'none';
            }

            function updateTable() {
                for (let i = 0; i < totalRows; i++) {
                    table.rows[i].style.display = (i >= (currentPage - 1) * rowsPerPage && i < currentPage *
                        rowsPerPage) ? '' : 'none';
                }
                totalPages = Math.ceil(totalRows / rowsPerPage);
                pageIndicator.innerText = `${currentPage} / ${totalPages}`;
                totalCampaigns.innerText = `Total campaigns: ${totalRows}`;
                document.getElementById('prevPage').classList.toggle('hidden', currentPage === 1);
                document.getElementById('nextPage').classList.toggle('hidden', currentPage === totalPages);
            }

            document.getElementById('prevPage').addEventListener('click', function() {
                if (currentPage > 1) {
                    currentPage--;
                    updateTable();
                }
            });

            document.getElementById('nextPage').addEventListener('click', function() {
                if (currentPage < totalPages) {
                    currentPage++;
                    updateTable();
                }
            });

            rowsPerPageSelect.addEventListener('change', function() {
                rowsPerPage = parseInt(this.value);
                currentPage = 1; // Reset to first page
                updateTable();
            });

            // Initialize table display
            updateTable();
        }
    });

    document.addEventListener('DOMContentLoaded', function() {
        const filterInput = document.getElementById("filter");
        const clearFilterButton = document.getElementById("clear-filter");
        const rows = document.querySelectorAll("#questionnaires-campaign-table tbody tr");

        if (filterInput && clearFilterButton) {
            filterInput.addEventListener("input", function() {
                const filterValue = this.value.toLowerCase().trim();
                clearFilterButton.style.display = this.value.trim() !== "" ? "block" : "none";

                rows.forEach(function(row) {
                    const titleCell = row.querySelector(
                        "td:nth-child({{ auth()->user()->role === 'Evaluator' ? '2' : '1' }})"
                    );
                    const descriptionCell = row.querySelector(
                        "td:nth-child({{ auth()->user()->role === 'Evaluator' ? '3' : '2' }})"
                    );

                    const titleText = titleCell.textContent.toLowerCase().trim();
                    const descriptionText = descriptionCell.textContent.toLowerCase().trim();

                    if (titleText.includes(filterValue) || descriptionText.includes(
                            filterValue)) {
                        row.style.display = "";
                    } else {
                        row.style.display = "none";
                    }
                });
            });

            clearFilterButton.addEventListener("click", function() {
                // Clear the search input
                filterInput.value = "";

                // Hide the clear button
                clearFilterButton.style.display = "none";

                rows.forEach(function(row) {
                    row.style.display = "";
                });
            });
        }
    });
</script>
