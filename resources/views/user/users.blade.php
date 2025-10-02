<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row item-center gap-3">
            <!-- Breadcrumb -->
            <ul class="flex flex-row gap-1 flex-wrap break-words text-sky-800">
                <li><a href="{{ route('users') }}">@lang('user.users')</a></li>
                @if ($role)
                    <li>/ {{ ucfirst($role) }}</li>
                @endif
            </ul>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 ">
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-8 text-sky-900">

                    <div
                        class="flex flex-col md:flex-row w-full space-y-3 sm:space-y-0 sm:justify-between sm:items-center">
                        <div>
                            <p class="font-semibold text-xl">
                                @lang('user.users') @if ($role)
                                    - {{ ucfirst($role) }}
                                @endif
                            </p>
                        </div>
                        <div>
                            @if ($users->count() > 0)
                                <div class="flex items-center mb-4">
                                    <!-- Filter -->
                                    <div class="flex flex-row w-80 gap-3 justify-end items-center relative">
                                        <label for="filter"
                                            class="block text-sm font-bold text-sky-700">@lang('user.search')</label>
                                        <input type="text" id="filter" name="filter"
                                            class="p-2 border border-sky-700 focus:border-sky-800 focus:ring-sky-800 rounded-md shadow-sm w-full placeholder:text-sky-700"
                                            placeholder="@lang('user.placeholderSearch')">
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
                        </div>
                    </div>

                    @if ($users->count() === 0)
                        <p class="text-center">@lang('user.noResult')</p>
                    @elseif ($users->count() > 0)
                        <!-- Desktop version -->
                        <table id="user-table" class="min-w-full text-center border-collapse">
                            <thead class="bg-gray-100">
                                <tr class="border-b-2 border-gray-300">
                                    <th class="py-2 px-4">@lang('user.name')</th>
                                    <th class="py-2 px-4">@lang('user.surname')</th>
                                    <th class="py-2 px-4">@lang('user.gender')</th>
                                    <th class="py-2 px-4">@lang('user.dob')</th>
                                    <th class="py-2 px-4">@lang('user.email')</th>
                                    <th class="py-2 px-4">@lang('user.role')</th>
                                    <th class="py-2 px-4">@lang('user.companyRole')</th>
                                    <th class="py-2 px-4"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr class="hover:bg-gray-100 border-b border-gray-200">
                                        <td class=" py-2 px-4">{{ $user->name }}</td>
                                        <td class=" py-2 px-4">{{ $user->surname }}</td>
                                        <td class=" py-2 px-4">{{ $user->gender }}</td=>
                                        <td class=" py-2 px-4">
                                            {{ \Carbon\Carbon::parse($user->dob)->format('d/m/Y') }}</td>
                                        <td class=" py-2 px-4">{{ $user->email }}</td>
                                        <td class=" py-2 px-4">{{ $user->role }}</td>
                                        <td class=" py-2 px-4">{{ $user->company_role }}</td>
                                        <td class=" py-2 px-4">
                                            <x-dropdown align="right" width="48">
                                                <x-slot name="trigger">
                                                    <button class="inline-flex items-center font-semibold">
                                                        <p class="classic">
                                                            @lang('user.option')
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
                                                        <button class="hover:bg-gray-100" data-id="{{ $user->id }}"
                                                            data-name="{{ $user->name }}"
                                                            data-surname="{{ $user->surname }}"
                                                            data-gender="{{ $user->gender }}"
                                                            data-dob="{{ $user->dob }}"
                                                            data-email="{{ $user->email }}"
                                                            data-role="{{ $user->role }}"
                                                            data-company-role="{{ $user->company_role }}"
                                                            x-data=""
                                                            @click="
                                                                    $dispatch('open-modal', 'update-modal');
                                                                    fillUpdateModal({
                                                                        id: '{{ $user->id }}',
                                                                        name: '{{ $user->name }}',
                                                                        surname: '{{ $user->surname }}',
                                                                        gender: '{{ $user->gender }}',
                                                                        dob: '{{ $user->dob }}',
                                                                        email: '{{ $user->email }}',
                                                                        role: '{{ $user->role }}',
                                                                        company_role: '{{ $user->company_role }}'
                                                                    });
                                                                ">
                                                            @lang('user.update')
                                                        </button>
                                                        @if ($user->role !== 'Admin')
                                                            <button class="hover:bg-gray-100 text-red-500"
                                                                data-id="{{ $user->id }}" x-data=""
                                                                @click="$dispatch('open-modal', 'delete-modal', { id: {{ $user->id }} })">@lang('user.delete')</button>
                                                        @endif
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
                                <x-primary-button id="prevPage">@lang('user.previous')</x-primary-button>
                            </div>
                            <div class="flex flex-row justify-center items-center w-1/3 gap-4">
                                <span id="pageIndicator" class="text-gray-700"></span>
                                <span id="totalUsers" class="text-gray-500 text-sm"></span>
                                <select id="rowsPerPage" class="border border-gray-300 rounded-md shadow-sm">
                                    <option value="10" selected>10</option>
                                    <option value="20">20</option>
                                    <option value="50">50</option>
                                </select>
                            </div>
                            <div class="flex justify-center w-1/3">
                                <x-primary-button id="nextPage">@lang('user.next')</x-primary-button>
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

<!-- Detail modal -->
<x-modal name="detail-modal" id="detail-modal" title="Detail profile" :show="false">
    <div class="p-4 rounded-lg relative">
        <p class="text-lg font-semibold mb-4 text-sky-800">@lang('user.detail')</p>

        <div class="detail-modal-content gap-2">
            <p id="detail-name"></p>
            <p id="detail-surname"></p>
            <p id="detail-gender"></p>
            <p id="detail-dob"></p>
            <p id="detail-email"></p>
            <p id="detail-role"></p>
        </div>

        <div class="flex justify-end">
            <x-secondary-button x-on:click="$dispatch('close')">@lang('user.close')</x-secondary-button>
        </div>

    </div>
</x-modal>

<!-- Update modal -->
<x-modal name="update-modal" id="update-modal" title="Update user" :show="false">
    <div class="p-4 rounded-lg relative">
        @include('user.partials.update-user')
    </div>
</x-modal>

<!-- Update successfully message -->
<x-modal name="update-successfully-modal" id="update-successfully-modal" title="Update successfully modal"
    :show="false">
    <div class="p-4 rounded-lg relative text-center text-sky-800">
        <p class="text-xl font-semibold pb-8">
            @lang('user.updateSucc')
        </p>

        <div class="flex justify-end">
            <x-secondary-button x-on:click="$dispatch('close')">@lang('user.close')</x-secondary-button>
        </div>
    </div>
</x-modal>

<!-- Delete modal -->
<x-modal name="delete-modal" id="delete-modal" title="Delete User" :show="false">
    <div class="p-4 rounded-lg relative">
        @include('user.partials.delete-user')
    </div>
</x-modal>

<!-- Delete successfully message -->
<x-modal name="delete-successfully-modal" id="delete-successfully-modal" title="Delete successfully modal"
    :show="false">
    <div class="p-4 rounded-lg relative text-center text-sky-800">
        <p class="text-xl font-semibold pb-8">
            @lang('user.deleteSUcc')
        </p>

        <div class="flex justify-end">
            <x-secondary-button x-on:click="$dispatch('close')">@lang('user.close')</x-secondary-button>
        </div>
    </div>
</x-modal>

<!-- Error modal -->
<x-modal name="error-modal" id="error-modal" title="Error modal" :show="false">
    <div class="p-4 rounded-lg relative text-center text-red-800">
        <p class="text-xl font-semibold pb-8">
            @lang('user.tryAgain')
        </p>

        <div class="flex justify-end">
            <x-secondary-button x-on:click="$dispatch('close')">@lang('user.close')</x-secondary-button>
        </div>
    </div>
</x-modal>

<script>
    var users = {!! json_encode($users) !!};

    // Modal options campaign
    document.addEventListener('DOMContentLoaded', function() {
        @if (session('success'))
            @php
                $successMessage = session('success');
            @endphp

            if ("{{ $successMessage }}" === "User updated successfully!") {

                const updateModalEvent = new CustomEvent('open-modal', {
                    detail: 'update-successfully-modal'
                });
                window.dispatchEvent(updateModalEvent);

            } else if ("{{ $successMessage }}" === "User deleted successfully!") {

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
            const totalUsers = document.getElementById('totalUsers');

            let rowsPerPage = parseInt(rowsPerPageSelect.value);
            let currentPage = 1;
            const table = document.getElementById('user-table').getElementsByTagName('tbody')[0];
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
                totalUsers.innerText = `Total users: ${totalRows}`;
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

    // Used for mobile version
    /*
    function showUserDetails(userId) {
        const user = users.find(user => user.id === userId);

        const detailName = document.getElementById('detail-name');
        const detailSurname = document.getElementById('detail-surname');
        const detailGender = document.getElementById('detail-gender');
        const detailDob = document.getElementById('detail-dob');
        const detailEmail = document.getElementById('detail-email');
        const detailRole = document.getElementById('detail-role');
        const detailCompanyRole = document.getElementById('detail-company-role');

        detailName.textContent = "Name: " + user.name;
        detailSurname.textContent = "Surname: " + user.surname;
        detailGender.textContent = "Gender: " + user.gender;
        detailDob.textContent = "Date of Birth: " + user.dob;
        detailEmail.textContent = "Email: " + user.email;
        detailRole.textContent = "Role: " + user.role;
        detailCompanyRole.textContent = "Company role: " + user.company_role;
    }
    */

    // Filter
    function setupTableFilter(filterInput, clearFilterButton, rows) {
        filterInput.addEventListener("input", function() {
            const filterValue = this.value.toLowerCase().trim();

            clearFilterButton.style.display = this.value.trim() !== "" ? "block" : "none";

            rows.forEach(function(row) {
                const rowData = Array.from(row.cells).map(cell => cell.textContent.toLowerCase());
                const matchesFilter = rowData.some(data => data.includes(filterValue));
                row.style.display = matchesFilter ? "" : "none";
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

    document.addEventListener('DOMContentLoaded', function() {
        const filterInputDesktop = document.getElementById("filter");
        const clearFilterButtonDesktop = document.getElementById("clear-filter");
        const rowsDesktop = document.querySelectorAll("#user-table tbody tr");

        setupTableFilter(filterInputDesktop, clearFilterButtonDesktop, rowsDesktop);

        const filterInputMobile = document.getElementById("filter");
        const clearFilterButtonMobile = document.getElementById("clear-filter");
        const rowsMobile = document.querySelectorAll("#user-table-mobile tbody tr");

        setupTableFilter(filterInputMobile, clearFilterButtonMobile, rowsMobile);
    });
</script>
