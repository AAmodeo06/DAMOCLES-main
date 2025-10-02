<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col text-sky-800 ">
            <!-- Breadcrumb -->
            <ul class="flex flex-row gap-1 flex-wrap break-words">
                <li><a href="{{ route('phishing-campaign.index') }}">@lang('phishing-campaign.phishingCampaign')</a></li>
            </ul>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-8 text-sky-900">

                    <div
                        class="flex flex-col md:flex-row w-full space-y-2 md:space-y-0 sm:justify-between items-center mb-6">
                        <p class="font-semibold text-xl">@lang('phishing-campaign.phishingCampaigns')</p>
                        <div>
                            @if ($phishingCampaigns->count() > 0)
                                <!-- Filter -->
                                <div class="flex flex-row w-80 gap-3 justify-end items-center relative">
                                    <label for="filter"
                                        class="block text-sm font-bold text-sky-700">@lang('phishing-campaign.search')</label>
                                    <input type="text" id="filter" name="filter"
                                        class="p-2 border border-sky-700 focus:border-sky-800 focus:ring-sky-800 rounded-md shadow-sm w-full placeholder:text-sky-700"
                                        placeholder="@lang('phishing-campaign.placeholderFilter')">
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

                    <div>
                        <div class="flex flex-col sm:flex-row w-full items-center justify-between mb-4">
                            <div class="mb-4 sm:mb-0">
                                <p class="font-semibold">@lang('phishing-campaign.phishingCampaignsAvailable')</p>
                            </div>
                            <div>
                                <a href="{{ route('phishing-campaign.new') }}" class="cursor-pointer">
                                    <x-primary-button>
                                        @lang('phishing-campaign.new')
                                    </x-primary-button>
                                </a>
                            </div>
                        </div>

                        <!-- Content -->
                        @if (count($phishingCampaigns) > 0)
                            <table id="phishing-campaigns-table" class="min-w-full text-center border-collapse">
                                <thead class="bg-gray-100">
                                    <tr class="border-b-2 border-gray-300">
                                        <th class="py-2 px-4">@lang('phishing-campaign.state')</th>
                                        <th class="py-2 px-4">@lang('phishing-campaign.title')</th>
                                        <th class="py-2 px-4">@lang('phishing-campaign.description')</th>
                                        <th class="py-2 px-4">@lang('phishing-campaign.updatedAt')</th>
                                        <th class="py-2 px-4"></th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white">
                                    @foreach ($phishingCampaigns as $phishingCampaign)
                                        <tr class="hover:bg-gray-100 border-b border-gray-200 cursor-pointer"
                                            onclick="handleRowClick(event, '{{ $phishingCampaign->state == 'Draft' || $phishingCampaign->state == 'Ready' ? route('phishing-campaign.details', ['phishingCampaign' => $phishingCampaign->id]) : route('phishing-campaign.analyse', ['phishingCampaign' => $phishingCampaign->id]) }}')">
                                            <td
                                                class="w-12 py-2 px-4 font-semibold
                                        @if ($phishingCampaign->state == 'Draft') text-gray-500 
                                        @elseif ($phishingCampaign->state == 'Ready') text-green-500 
                                        @elseif ($phishingCampaign->state == 'Ongoing') text-orange-500 
                                        @elseif ($phishingCampaign->state == 'Finished') text-red-500 @endif">
                                                {{ $phishingCampaign->state }}
                                            </td>
                                            <td class="w-1/3 py-2 px-4">{{ $phishingCampaign->title }}</td>
                                            <td class="w-1/2 py-2 px-4">{{ $phishingCampaign->description }}</td>
                                            <td class="w-1/2 py-2 px-4">
                                                {{ $phishingCampaign->updated_at->format('d/m/Y') }}</td>
                                            <td class="flex flex-row justify-end py-2 px-4">
                                                <x-dropdown align="right" width="48">
                                                    <x-slot name="trigger">
                                                        <button
                                                            class="inline-flex items-center font-semibold inner-element">
                                                            <p class="classic">
                                                                @lang('phishing-campaign.options')
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
                                                            @if ($phishingCampaign->state === 'Ready')
                                                                <button class="hover:bg-gray-100 inner-element"
                                                                    data-id="{{ $phishingCampaign->id }}"
                                                                    x-data=""
                                                                    @click="$dispatch('open-modal', 'start-modal', { id: {{ $phishingCampaign->id }} })">@lang('phishing-campaign.start')</button>
                                                            @endif

                                                            @if ($phishingCampaign->state === 'Ongoing')
                                                                <button class="hover:bg-gray-100 inner-element"
                                                                    data-id="{{ $phishingCampaign->id }}"
                                                                    x-data=""
                                                                    @click="$dispatch('open-modal', 'stop-modal', { id: {{ $phishingCampaign->id }} })">@lang('phishing-campaign.stop')</button>

                                                                <a href="{{ route('phishing-campaign.analyse', ['phishingCampaign' => $phishingCampaign->id]) }}"
                                                                    class="hover:bg-gray-100 inner-element">
                                                                    <button
                                                                        class="hover:bg-gray-100">@lang('phishing-campaign.analyse')</button>
                                                                </a>
                                                            @endif

                                                            @if ($phishingCampaign->state === 'Finished')
                                                                <a href="{{ route('phishing-campaign.analyse', ['phishingCampaign' => $phishingCampaign->id]) }}"
                                                                    class="hover:bg-gray-100 inner-element">
                                                                    <button
                                                                        class="hover:bg-gray-100">@lang('phishing-campaign.analyse')</button>
                                                                </a>
                                                            @endif

                                                            <a href="{{ route('phishing-campaign.details', ['phishingCampaign' => $phishingCampaign->id]) }}"
                                                                class="hover:bg-gray-100 inner-element">
                                                                <button class="hover:bg-gray-100">
                                                                    {{ $phishingCampaign->state != 'Draft' ? __('phishing-campaign.details') : __('phishing-campaign.continue') }}
                                                                </button>
                                                            </a>
                                                            <button class="hover:bg-gray-100 inner-element"
                                                                data-id="{{ $phishingCampaign->id }}"
                                                                x-data=""
                                                                @click="$dispatch('open-modal', 'duplicate-modal', { id: {{ $phishingCampaign->id }} })">@lang('phishing-campaign.duplicate')</button>

                                                            <button class="hover:bg-gray-100 text-red-500 inner-element"
                                                                data-id="{{ $phishingCampaign->id }}"
                                                                x-data=""
                                                                @click="$dispatch('open-modal', 'delete-modal', { id: {{ $phishingCampaign->id }} })">@lang('phishing-campaign.delete')</button>
                                                        </div>
                                                    </x-slot>
                                                </x-dropdown>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <!-- Paginator controls -->
                            <div id="pagination-controls" class="flex justify-around items-center mt-4">
                                <div class="flex justify-center w-1/3">
                                    <x-primary-button id="prevPage">@lang('phishing-campaign.previous')</x-primary-button>
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
                                    <x-primary-button id="nextPage">@lang('phishing-campaign.next')</x-primary-button>
                                </div>
                            </div>
                        @else
                            <p class="pt-4 text-center text-lg text-sky-700">@lang('phishing-campaign.noPhishingCampaigns')</p>
                        @endif
                    </div>
                </div>
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
<x-modal name="start-modal" id="start-modal" title="Start Phishing Campaign" :show="false">
    <div class="p-4 rounded-lg relative">
        @include('phishing-campaign.modals.start-phishing-campaign')
    </div>
</x-modal>

<!-- Start successfully message -->
<x-modal name="start-successfully-modal" id="start-successfully-modal" title="Start successfully modal"
    :show="false">
    <div class="p-6 rounded-lg relative text-center text-sky-800">
        <p class="text-xl font-semibold pb-8">
            @lang('phishing-campaign.startSucc')
        </p>

        <div class="flex justify-end">
            <x-secondary-button x-on:click="$dispatch('close')">@lang('phishing-campaign.close')</x-secondary-button>
        </div>
    </div>
</x-modal>

<!-- Stop modal -->
<x-modal name="stop-modal" id="stop-modal" title="Stop Phishing Campaign" :show="false">
    <div class="p-4 rounded-lg relative">
        @include('phishing-campaign.modals.stop-phishing-campaign')
    </div>
</x-modal>

<!-- Stop successfully message -->
<x-modal name="stop-successfully-modal" id="stop-successfully-modal" title="Stop successfully modal"
    :show="false">
    <div class="p-6 rounded-lg relative text-center text-sky-800">
        <p class="text-xl font-semibold pb-8">
            @lang('phishing-campaign.stopSucc')
        </p>

        <div class="flex justify-end">
            <x-secondary-button x-on:click="$dispatch('close')">@lang('phishing-campaign.close')</x-secondary-button>
        </div>
    </div>
</x-modal>

<!-- Duplicate modal -->
<x-modal name="duplicate-modal" id="duplicate-modal" title="Duplicate Phishing Campaign" :show="false">
    <div class="p-4 rounded-lg relative">
        @include('phishing-campaign.modals.duplicate-phishing-campaign')
    </div>
</x-modal>

<!-- Duplicate successfully message -->
<x-modal name="duplicate-successfully-modal" id="duplicate-successfully-modal" title="Duplicate successfully modal"
    :show="false">
    <div class="p-6 rounded-lg relative text-center text-sky-800">
        <p class="text-xl font-semibold pb-8">
            @lang('phishing-campaign.duplicateSucc')
        </p>

        <div class="flex justify-end">
            <x-secondary-button x-on:click="$dispatch('close')">@lang('phishing-campaign.close')</x-secondary-button>
        </div>
    </div>
</x-modal>

<!-- Delete modal -->
<x-modal name="delete-modal" id="delete-modal" title="Delete Phishing Campaign" :show="false">
    <div class="p-4 rounded-lg relative">
        @include('phishing-campaign.modals.delete-phishing-campaign')
    </div>
</x-modal>

<!-- Delete successfully message -->
<x-modal name="delete-successfully-modal" id="delete-successfully-modal" title="Delete successfully modal"
    :show="false">
    <div class="p-6 rounded-lg relative text-center text-sky-800">
        <p class="text-xl font-semibold pb-8">
            @lang('phishing-campaign.deleteSucc')
        </p>

        <div class="flex justify-end">
            <x-secondary-button x-on:click="$dispatch('close')">@lang('phishing-campaign.close')</x-secondary-button>
        </div>
    </div>
</x-modal>

<!-- Error modal -->
<x-modal name="error-modal" id="error-modal" title="Error modal" :show="false">
    <div class="p-6 rounded-lg relative text-center text-red-800">
        <p class="text-xl font-semibold pb-8">
            @lang('phishing-campaign.tryAgain')
        </p>

        <div class="flex justify-end">
            <x-secondary-button x-on:click="$dispatch('close')">@lang('phishing-campaign.close')</x-secondary-button>
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
            const table = document.getElementById('phishing-campaigns-table').getElementsByTagName('tbody')[0];
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

    // Filter
    document.addEventListener('DOMContentLoaded', function() {
        const filterInput = document.getElementById("filter");
        const clearFilterButton = document.getElementById("clear-filter");
        const rows = document.querySelectorAll("#phishing-campaigns-table tbody tr");

        if (filterInput && clearFilterButton) {
            filterInput.addEventListener("input", function() {
                const filterValue = this.value.toLowerCase().trim();

                clearFilterButton.style.display = this.value.trim() !== "" ? "block" : "none";

                rows.forEach(function(row) {
                    const state = row.cells[0].textContent.toLowerCase();
                    const title = row.cells[1].textContent.toLowerCase();
                    const description = row.cells[2].textContent.toLowerCase();

                    if (state.includes(filterValue) || title.includes(filterValue) ||
                        description.includes(filterValue)) {
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
