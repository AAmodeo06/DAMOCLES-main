<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row item-center gap-3">
            <!-- Breadcrumb -->
            <ul class="flex flex-row gap-1 flex-wrap break-words text-sky-800">
                <li><a href="{{ route('llms.index') }}">@lang('llm.llm')</a></li>
            </ul>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-8 text-sky-900">

                    <div
                        class="flex flex-col md:flex-row w-full space-y-2 md:space-y-0 sm:justify-between items-center mb-6">
                        <p class="font-semibold text-xl">@lang('llm.llms')</p>
                        <div>
                            @if (!$llms->isEmpty())
                                <!-- Filter -->
                                <div class="flex flex-row w-80 gap-3 items-center relative">
                                    <label for="filter"
                                        class="block text-sm font-bold text-sky-700">@lang('llm.search')</label>
                                    <input type="text" id="filter" name="filter"
                                        class="p-2 border border-sky-700 focus:border-sky-800 focus:ring-sky-800 rounded-md shadow-sm w-full placeholder:text-sky-700"
                                        placeholder="Enter keyword">
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
                            <p class="font-semibold">@lang('llm.llmsAvailable')</p>
                        </div>
                        <div>
                            <!-- Add model -->
                            <x-primary-button x-data="" @click="$dispatch('open-modal', 'add-modal')">
                                @lang('llm.addNew')
                            </x-primary-button>
                        </div>
                    </div>

                    @if ($llms->isEmpty())
                        <p class="text-center">@lang('llm.noModels')</p>
                    @else
                        <table id="llm-table" class="w-full text-center">
                            <thead class="bg-gray-100">
                                <tr class="border-b-2 border-gray-300">
                                    <th class="py-2 px-4">@lang('llm.endpoint')</th>
                                    <th class="py-2 px-4">@lang('llm.provider')</th>
                                    <th class="py-2 px-4">@lang('llm.model')</th>
                                    <th class="py-2 px-4"></th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($llms as $llm)
                                    <tr class="hover:bg-gray-100 border-b border-gray-200">
                                        <td class=" py-2 px-4">{{ $llm->endpoint }}</td>
                                        <td class=" py-2 px-4">{{ $llm->provider }}</td>
                                        <td class=" py-2 px-4">{{ $llm->model }}</td>
                                        <td class=" py-2 px-4">
                                            <x-dropdown align="right" width="48">
                                                <x-slot name="trigger">
                                                    <button class="inline-flex items-center font-semibold">
                                                        <p class="classic">
                                                            @lang('llm.options')
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
                                                        <button class="hover:bg-gray-100" data-id="{{ $llm->id }}"
                                                            x-data=""
                                                            @click="$dispatch('open-modal', 'update-modal', { id: {{ $llm->id }} } )"
                                                            onclick="fillUpdateModal({ 
                                                                id: '{{ $llm->id }}', 
                                                                endpoint: '{{ $llm->endpoint }}', 
                                                                provider: '{{ $llm->provider }}', 
                                                                model: '{{ $llm->model }}' 
                                                            })">
                                                            @lang('llm.update')
                                                        </button>

                                                        <button class="hover:bg-gray-100 text-red-500"
                                                            data-id="{{ $llm->id }}" x-data=""
                                                            @click="$dispatch('open-modal', 'delete-modal', { id: {{ $llm->id }} })">@lang('llm.delete')</button>
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
                                <x-primary-button id="prevPage">@lang('llm.previous')</x-primary-button>
                            </div>
                            <div class="flex flex-row justify-center items-center w-1/3 gap-4">
                                <span id="pageIndicator" class="text-gray-700"></span>
                                <span id="totalLLMs" class="text-gray-500 text-sm"></span>
                                <select id="rowsPerPage" class="border border-gray-300 rounded-md shadow-sm">
                                    <option value="10" selected>10</option>
                                    <option value="20">20</option>
                                    <option value="50">50</option>
                                </select>
                            </div>
                            <div class="flex justify-center w-1/3">
                                <x-primary-button id="nextPage">@lang('llm.next')</x-primary-button>
                            </div>
                        </div>
                    @endif
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

<!-- Add modal -->
<x-modal name="add-modal" id="add-modal" title="Add New Endpoint" :show="false">
    <div class="p-4 rounded-lg relative space-y-6">
        @include('llm.partials.add-llm')
    </div>
</x-modal>

<!-- Add successfully message -->
<x-modal name="add-successfully-modal" id="add-successfully-modal" title="Add successfully modal" :show="false">
    <div class="p-6 rounded-lg relative text-center text-sky-800">
        <p class="text-xl font-semibold pb-8">
            @lang('llm.addSucc')
        </p>

        <div class="flex justify-end">
            <x-secondary-button x-on:click="$dispatch('close')">@lang('llm.close')</x-secondary-button>
        </div>
    </div>
</x-modal>

<!-- Update modal -->
<x-modal name="update-modal" id="update-modal" title="Update Endpoint" :show="false">
    <div class="p-4 rounded-lg relative space-y-6">
        @include('llm.partials.update-llm')
    </div>
</x-modal>

<!-- Update successfully message -->
<x-modal name="update-successfully-modal" id="update-successfully-modal" title="Update successfully modal"
    :show="false">
    <div class="p-4 rounded-lg relative text-center text-sky-800">
        <p class="text-xl font-semibold pb-8">
            @lang('llm.updateSucc')
        </p>

        <div class="flex justify-end">
            <x-secondary-button x-on:click="$dispatch('close')">@lang('llm.close')</x-secondary-button>
        </div>
    </div>
</x-modal>

<!-- Delete modal -->
<x-modal name="delete-modal" id="delete-modal" title="Delete Endpoint" :show="false">
    <div class="p-4 rounded-lg relative space-y-6">
        @include('llm.partials.delete-llm')
    </div>
</x-modal>

<!-- Delete successfully message -->
<x-modal name="delete-successfully-modal" id="delete-successfully-modal" title="Delete successfully modal"
    :show="false">
    <div class="p-6 rounded-lg relative text-center text-sky-800">
        <p class="text-xl font-semibold pb-8">
            @lang('llm.deleteSucc')
        </p>

        <div class="flex justify-end">
            <x-secondary-button x-on:click="$dispatch('close')">@lang('llm.close')</x-secondary-button>
        </div>
    </div>
</x-modal>

<!-- Error modal -->
<x-modal name="error-modal" id="error-modal" title="Error modal" :show="false">
    <div class="p-4 rounded-lg relative space-y-6 text-red-800">
        <p class="text-xl font-semibold">
            @lang('llm.tryAgain')
        </p>

        <div class="flex justify-end">
            <x-secondary-button x-on:click="$dispatch('close')">@lang('llm.close')</x-secondary-button>
        </div>
    </div>
</x-modal>

<script>
    // Modal options campaign
    document.addEventListener('DOMContentLoaded', function() {
        @if (session('success'))
            @php
                $successMessage = session('success');
            @endphp

            if ("{{ $successMessage }}" === "LLM added successfully!") {

                const addModalEvent = new CustomEvent('open-modal', {
                    detail: 'add-successfully-modal'
                });
                window.dispatchEvent(addModalEvent);

            } else if ("{{ $successMessage }}" === "LLM updated successfully!") {

                const updateModalEvent = new CustomEvent('open-modal', {
                    detail: 'update-successfully-modal'
                });
                window.dispatchEvent(updateModalEvent);

            } else if ("{{ $successMessage }}" === "LLM deleted successfully!") {

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
            const totalLLMs = document.getElementById('totalLLMs');

            let rowsPerPage = parseInt(rowsPerPageSelect.value);
            let currentPage = 1;
            const table = document.getElementById('llm-table').getElementsByTagName('tbody')[0];
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
                totalLLMs.innerText = `Total llms: ${totalRows}`;
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
        const rows = document.querySelectorAll("#llm-table tbody tr");

        if (filterInput) {
            filterInput.addEventListener("input", function() {
                const filterValue = this.value.toLowerCase().trim();

                clearFilterButton.style.display = this.value.trim() !== "" ? "block" : "none";

                rows.forEach(function(row) {
                    const id = row.cells[0].textContent.toLowerCase();
                    const endpoint = row.cells[1].textContent.toLowerCase();

                    if (id.includes(filterValue) || endpoint.includes(filterValue)) {
                        row.style.display = "";
                    } else {
                        row.style.display = "none";
                    }
                });
            });

            clearFilterButton.addEventListener("click", function() {
                filterInput.value = "";

                clearFilterButton.style.display = "none";

                rows.forEach(function(row) {
                    row.style.display = "";
                });
            });
        }
    });
</script>
