<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row item-center gap-3">
            <!-- Back to questionnaire campaign -->
            <a href="{{ route('questionnaires-campaign.index') }}" class="cursor-pointer">
                <x-primary-button>
                    @lang('questionnaire-campaign.users.back')
                </x-primary-button>
            </a>
            <!-- Breadcrumb -->
            <ul class="flex flex-row gap-1 flex-wrap break-words text-sky-800">
                <li><a href="{{ route('questionnaires-campaign.index') }}">@lang('questionnaire-campaign.users.questionnaireCampaign')</a></li>
                <li>/</li>
                <li><a href="{{ route('questionnaires-campaign.new') }}">@lang('questionnaire-campaign.users.newQuestionnaireCampaign')</a></li>
                <li>/</li>
                <li>@lang('questionnaire-campaign.users.selectUsers')</li>
            </ul>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-8 text-sky-900">

                    <p class="flex text-lg font-medium text-sky-900 pb-2">
                        @lang('questionnaire-campaign.users.selectUsersToInvite'):
                    </p>

                    @if (!$users->isEmpty())
                        <!-- Filters -->
                        <p class="font-medium">Filters:</p>
                        <div class="flex flex-row flex-wrap gap-2 pb-4">
                            <div class="flex flex-row w-80 gap-3 items-center relative">
                                @if (!$users->isEmpty())
                                    <!-- Filter -->
                                    <label for="userFilter"
                                        class="block text-sm font-bold text-sky-700">@lang('questionnaire-campaign.users.search')</label>
                                    <input type="text" id="userFilter" name="userFilter"
                                        class="p-2 border border-sky-700 focus:border-sky-800 focus:ring-sky-800 rounded-md shadow-sm w-full placeholder:text-sky-700"
                                        placeholder="@lang('questionnaire-campaign.users.enterSearch')">
                                    <button id="clear-user-filter"
                                        class="hidden absolute right-2 top-1/2 transform -translate-y-1/2 focus:outline-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-sky-600"
                                            viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M10 0a10 10 0 0 1 7.071 2.929A10 10 0 0 1 20 10a10 10 0 0 1-2.929 7.071A10 10 0 0 1 10 20a10 10 0 0 1-7.071-2.929A10 10 0 0 1 0 10a10 10 0 0 1 2.929-7.071A10 10 0 0 1 10 0zm3.536 5.05a.5.5 0 0 1 .708.708L10.707 10l3.536 3.536a.5.5 0 0 1-.708.708L10 10.707l-3.536 3.536a.5.5 0 1 1-.708-.708L9.293 10 5.757 6.464a.5.5 0 0 1 .708-.708L10 9.293l3.536-3.536z" />
                                        </svg>
                                    </button>
                                @endif
                            </div>

                            <div class="flex flex-wrap gap-2 items-center">
                                <button
                                    class="all-button py-2 px-4 border border-sky-700 bg-white rounded-md shadow-sm focus:outline-none focus:ring-sky-800 focus:border-sky-800 text-sm"
                                    id="selectAllButton">@lang('questionnaire-campaign.users.all')</button>
                                <!-- Gender -->
                                <button type="button"
                                    class="all-male-button py-2 px-4 border border-sky-700 bg-white rounded-md shadow-sm focus:outline-none focus:ring-sky-800 focus:border-sky-800 text-sm"
                                    id="selectAllMaleButton">@lang('questionnaire-campaign.users.allMale')</button>
                                <button type="button"
                                    class="all-female-button py-2 px-4 border border-sky-700 bg-white rounded-md shadow-sm focus:outline-none focus:ring-sky-800 focus:border-sky-800 text-sm"
                                    id="selectAllFemaleButton">@lang('questionnaire-campaign.users.allFemale')</button>
                                <button type="button"
                                    class="all-other-button py-2 px-4 border border-sky-700 bg-white rounded-md shadow-sm focus:outline-none focus:ring-sky-800 focus:border-sky-800 text-sm"
                                    id="selectAllOtherButton">@lang('questionnaire-campaign.users.allOther')</button>
                            </div>

                            <!-- Age -->
                            <div class="flex flex-row items-center gap-2">
                                <label for="ageFrom"
                                    class="block text-sm font-bold text-sky-700">@lang('questionnaire-campaign.users.ageFrom'):</label>
                                <input type="number" id="ageFrom" name="ageFrom" min="18" max="80"
                                    class="p-2 border border-sky-700 focus:border-sky-800 focus:ring-sky-800 rounded-md shadow-sm w-16">
                                <label for="ageTo"
                                    class="block text-sm font-bold text-sky-700">@lang('questionnaire-campaign.users.ageTo'):</label>
                                <input type="number" id="ageTo" name="ageTo" min="18" max="80"
                                    class="p-2 border border-sky-700 focus:border-sky-800 focus:ring-sky-800 rounded-md shadow-sm w-16">
                                <x-primary-button id="selectAgeRangeButton">@lang('questionnaire-campaign.users.ageSelect')</x-primary-button>
                            </div>
                        </div>

                        <div class="pt-2 pb-4 shadow">
                            <p class="font-bold pb-2 pl-2">@lang('questionnaire-campaign.users.totalUser'): <span id="totalSelectedUsers">0</span>
                            </p>
                            <table id="user-table" class="w-full text-center">
                                <thead class="bg-gray-100">
                                    <tr class="border-b-2 border-gray-300">
                                        <th class="py-2 px-4"></th> <!-- Colonna per le checkbox -->
                                        <th class="py-2 px-4">@lang('questionnaire-campaign.users.name')</th>
                                        <th class="py-2 px-4">@lang('questionnaire-campaign.users.surname')</th>
                                        <th class="py-2 px-4">@lang('questionnaire-campaign.users.dob')</th>
                                        <th class="py-2 px-4">@lang('questionnaire-campaign.users.gender')</th>
                                        <th class="py-2 px-4">@lang('questionnaire-campaign.users.companyRole')</th>
                                        <th class="py-2 px-4">@lang('questionnaire-campaign.users.email')</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white">
                                    @foreach ($users as $user)
                                        <tr class="hover:bg-gray-100 border-b border-gray-200">
                                            <td class="py-2 px-4">
                                                <input id="{{ $user->id }}" type="checkbox" class="user-checkbox"
                                                    data-user-id="{{ $user->id }}"
                                                    data-gender="{{ $user->gender }}">
                                            </td>
                                            <td class="py-2 px-4">{{ $user->name }}</td>
                                            <td class="py-2 px-4">{{ $user->surname }}</td>
                                            <td class="py-2 px-4">
                                                {{ \Carbon\Carbon::parse($user->dob)->format('d/m/Y') }}</td>
                                            <td class="py-2 px-4">{{ $user->gender }}</td>
                                            <td class="py-2 px-4">{{ $user->company_role }}</td>
                                            <td class="py-2 px-4">{{ $user->email }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <!-- Paginator controls -->
                            <div id="pagination-controls" class="flex justify-around items-center mt-4">
                                <div class="flex justify-center w-1/3">
                                    <x-primary-button id="prevPage">@lang('questionnaire-campaign.users.previous')</x-primary-button>
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
                                    <x-primary-button id="nextPage">@lang('questionnaire-campaign.users.next')</x-primary-button>
                                </div>
                            </div>
                        </div>

                        <form id="saveUsersQuestionnaireCampaignForm"
                            action="{{ route('questionnaire-campaign.users-questionnaire-campaign') }}"
                            method="POST">
                            @csrf
                            @method('post')

                            <input type="hidden" name="questionnaireCampaignId" id="questionnaireCampaignIdInput"
                                value="{{ $questionnaireCampaignId }}">
                            <input type="hidden" name="usersIds" id="usersIdsInput">

                            <div class="flex flex-row justify-around items-center pt-6">
                                <div class="flex w-1/3">
                                </div>
                                <!-- Circles which indicates the steps of the creation -->
                                <div class="flex flex-row w-1/3 justify-center items-center">
                                    <span class="status"></span>
                                    <span class="status"></span>
                                    <span class="status active"></span>
                                </div>
                                <div class="flex w-1/3 justify-center">
                                    <x-primary-button type="submit">@lang('questionnaire-campaign.users.create')</x-primary-button>
                                </div>
                            </div>
                        </form>
                    @else
                        <p class="text-center">@lang('questionnaire-campaign.users.noUsers')</p>
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

<!-- Error user modal -->
<x-modal name="error-user-modal" id="error-user-modal" title="Error user!" :show="false">
    <div class="p-4 rounded-lg relative text-center">
        <p class="text-2xl font-semibold text-red-700 pb-8">@lang('questionnaire-campaign.users.chooseUser')</p>
        <x-primary-button x-on:click="$dispatch('close')">@lang('questionnaire-campaign.users.close')</x-primary-button>
    </div>
</x-modal>

<!-- Error age modal -->
<x-modal name="error-age-modal" id="error-age-modal" title="Error age!" :show="false">
    <div class="p-4 rounded-lg relative text-center">
        <p class="text-2xl font-semibold text-red-700 pb-8">@lang('questionnaire-campaign.users.errorAge')</p>
        <x-primary-button x-on:click="$dispatch('close')">@lang('questionnaire-campaign.users.close')</x-primary-button>
    </div>
</x-modal>

<script>
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

    document.addEventListener('DOMContentLoaded', function() {
        const userCheckboxes = document.querySelectorAll('.user-checkbox');
        const selectAllButton = document.getElementById('selectAllButton');
        const selectAllMaleButton = document.getElementById('selectAllMaleButton');
        const selectAllFemaleButton = document.getElementById('selectAllFemaleButton');
        const selectAllOtherButton = document.getElementById('selectAllOtherButton');
        const selectAgeRangeButton = document.getElementById('selectAgeRangeButton');
        const ageFromInput = document.getElementById('ageFrom');
        const ageToInput = document.getElementById('ageTo');

        let allUsersSelected = false;
        let allMalesSelected = false;
        let allFemalesSelected = false;
        let allOthersSelected = false;

        function updateSelectedUsersCount() {
            const selectedCount = document.querySelectorAll('.user-checkbox:checked').length;
            document.getElementById('totalSelectedUsers').textContent = selectedCount;
        }

        // Utility function to calculate age
        function calculateAge(dateString) {
            if (!dateString) return NaN; // Return NaN if dateString is empty

            // Convert dd/mm/yyyy to yyyy-mm-dd
            const parts = dateString.split('/');
            const formattedDateString = `${parts[2]}-${parts[1]}-${parts[0]}`;

            const birthDate = new Date(formattedDateString);
            const today = new Date();

            let age = today.getFullYear() - birthDate.getFullYear();
            const monthDifference = today.getMonth() - birthDate.getMonth();
            if (monthDifference < 0 || (monthDifference === 0 && today.getDate() < birthDate.getDate())) {
                age--;
            }
            return age;
        }

        // Utility function to toggle button styles
        function toggleButtonStyles(button, isActive) {
            if (isActive) {
                button.classList.remove('bg-white', 'text-sky-700');
                button.classList.add('bg-sky-800', 'text-white');
            } else {
                button.classList.remove('bg-sky-800', 'text-white');
                button.classList.add('bg-white', 'text-sky-700');
            }
        }

        function updateSelectAllButton() {
            const userCheckboxes = document.querySelectorAll('.user-checkbox');
            const allChecked = Array.from(userCheckboxes).every(checkbox => checkbox.checked);
            selectAllButton.textContent = allChecked ? "Deselect all" : "Select all";
            toggleButtonStyles(selectAllButton, allChecked);
        }

        if (selectAllButton) {
            selectAllButton.addEventListener('click', function() {
                allUsersSelected = !allUsersSelected;
                allMalesSelected = allUsersSelected;
                allFemalesSelected = allUsersSelected;
                allOthersSelected = allUsersSelected;

                userCheckboxes.forEach(function(checkbox) {
                    checkbox.checked = allUsersSelected;
                });

                selectAllButton.textContent = allUsersSelected ? "Deselect all" : "Select all";
                toggleButtonStyles(selectAllButton, allUsersSelected);

                toggleButtonStyles(selectAllMaleButton, allMalesSelected);
                toggleButtonStyles(selectAllFemaleButton, allFemalesSelected);
                toggleButtonStyles(selectAllOtherButton, allOthersSelected);

                updateSelectedUsersCount();
            });
        }

        if (selectAllMaleButton) {
            selectAllMaleButton.addEventListener('click', function() {
                allMalesSelected = !allMalesSelected;
                userCheckboxes.forEach(function(checkbox) {
                    if (checkbox.dataset.gender === 'Male') {
                        checkbox.checked = allMalesSelected;
                    }
                });
                toggleButtonStyles(selectAllMaleButton, allMalesSelected);
                updateSelectAllButton();
                updateSelectedUsersCount();
            });
        }

        if (selectAllFemaleButton) {
            selectAllFemaleButton.addEventListener('click', function() {
                allFemalesSelected = !allFemalesSelected;
                userCheckboxes.forEach(function(checkbox) {
                    if (checkbox.dataset.gender === 'Female') {
                        checkbox.checked = allFemalesSelected;
                    }
                });
                toggleButtonStyles(selectAllFemaleButton, allFemalesSelected);
                updateSelectAllButton();
                updateSelectedUsersCount();
            });
        }

        if (selectAllOtherButton) {
            selectAllOtherButton.addEventListener('click', function() {
                allOthersSelected = !allOthersSelected;
                userCheckboxes.forEach(function(checkbox) {
                    if (checkbox.dataset.gender === 'Other') {
                        checkbox.checked = allOthersSelected;
                    }
                });
                toggleButtonStyles(selectAllOtherButton, allOthersSelected);
                updateSelectAllButton();
                updateSelectedUsersCount();
            });
        }

        if (selectAgeRangeButton) {
            selectAgeRangeButton.addEventListener('click', function() {
                const ageFrom = parseInt(ageFromInput.value, 10);
                const ageTo = parseInt(ageToInput.value, 10);

                userCheckboxes.forEach(function(checkbox) {
                    const dob = checkbox.closest('tr').querySelector('td:nth-child(4)')
                        .textContent.trim();
                    const age = calculateAge(dob);
                    checkbox.checked = (!isNaN(ageFrom) && age >= ageFrom) && (isNaN(ageTo) ||
                        age <= ageTo);
                });
                updateSelectAllButton();
                updateSelectedUsersCount();
            });
        }

        userCheckboxes.forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                updateSelectAllButton();
                updateSelectedUsersCount();
            });
        });
    });

    // Filter
    function setupTableFilter(userFilterInput, clearFilterButton, rows) {
        userFilterInput.addEventListener("input", function() {
            const userFilterValue = this.value.toLowerCase().trim();

            clearFilterButton.style.display = this.value.trim() !== "" ? "block" : "none";

            rows.forEach(function(row) {
                const rowData = Array.from(row.cells).map(cell => cell.textContent.toLowerCase());
                const matchesFilter = rowData.some(data => data.includes(userFilterValue));
                row.style.display = matchesFilter ? "" : "none";
            });
        });

        clearFilterButton.addEventListener("click", function() {
            userFilterInput.value = "";
            clearFilterButton.style.display = "none";

            rows.forEach(function(row) {
                row.style.display = "";
            });
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        const userFilterInput = document.getElementById("userFilter");
        const clearFilterButton = document.getElementById("clear-user-filter");
        const rows = document.querySelectorAll("#user-table tbody tr");

        setupTableFilter(userFilterInput, clearFilterButton, rows);
    });

    document.getElementById('saveUsersQuestionnaireCampaignForm').addEventListener('submit', function(event) {
        event.preventDefault();

        const selectedUserCheckboxes = document.querySelectorAll('.user-checkbox:checked');
        if (selectedUserCheckboxes.length === 0) {
            const modalEvent = new CustomEvent('open-modal', {
                detail: 'error-user-modal'
            });
            window.dispatchEvent(modalEvent);
            return;
        }

        document.getElementById('loadingOverlay').classList.add('flex');
        document.getElementById('loadingOverlay').classList.remove('hidden');

        const selectedUsersIds = Array.from(selectedUserCheckboxes).map(checkbox => checkbox.dataset.userId);
        document.getElementById('usersIdsInput').value = selectedUsersIds.join(',');

        document.getElementById('saveUsersQuestionnaireCampaignForm').submit();
    });
</script>
