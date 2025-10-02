<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row item-center gap-3">
            <!-- Back to questionnaire campaign -->
            <a href="{{ route('questionnaires-campaign.index') }}" class="cursor-pointer">
                <x-primary-button>
                    @lang('questionnaire-campaign.detailsCampaign.back')
                </x-primary-button>
            </a>
            <!-- Breadcrumb -->
            <ul class="flex flex-row gap-1 flex-wrap break-words text-sky-800">
                <li><a href="{{ route('questionnaires-campaign.index') }}">@lang('questionnaire-campaign.detailsCampaign.questionnaireCampaign')</a></li>
                <li>/</li>
                <li>@lang('questionnaire-campaign.detailsCampaign.detail')</li>
            </ul>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-8 text-sky-900">

                    <p class="font-semibold text-xl">@lang('questionnaire-campaign.detailsCampaign.details')</p>

                    @if ($questionnaireCampaign)
                        <div class="flex flex-col">
                            <div class="flex flex-row gap-2">
                                <p class="font-semibold">
                                    @lang('questionnaire-campaign.detailsCampaign.title'):
                                </p>
                                <p>{{ $questionnaireCampaign->title }}</p>
                            </div>

                            <div class="flex flex-row gap-2">
                                <p class="font-semibold">
                                    @lang('questionnaire-campaign.detailsCampaign.description'):
                                </p>
                                <p>{{ $questionnaireCampaign->description }}</p>
                            </div>

                            <div class="flex flex-row gap-2">
                                <p class="font-semibold">
                                    @lang('questionnaire-campaign.detailsCampaign.expirationDate'):
                                </p>
                                <p>{{ \Carbon\Carbon::parse($questionnaireCampaign->expirationDate)->format('d/m/Y') }}
                                </p>
                            </div>

                            <!-- Questionnaires -->
                            @if ($questionnaires->isNotEmpty())
                                <div class="flex flex-row  gap-2">
                                    <p class="font-semibold">@lang('questionnaire-campaign.detailsCampaign.questionnaires'):</p>
                                    <p>
                                        @foreach ($questionnaires as $index => $questionnaire)
                                            {{ $questionnaire->name }}{{ $index < $questionnaires->count() - 1 ? ',' : '' }}
                                        @endforeach
                                    </p>
                                </div>

                                <!-- Users -->
                                @if ($users->isNotEmpty())

                                    <div class="flex flex-col gap-2">
                                        <p class="font-semibold">@lang('questionnaire-campaign.detailsCampaign.users'):</p>
                                        <table id="user-table" class="w-full text-center">
                                            <thead class="bg-gray-100">
                                                <tr class="border-b-2 border-gray-300">
                                                    <th class="py-2 px-4">@lang('questionnaire-campaign.detailsCampaign.name')</th>
                                                    <th class="py-2 px-4">@lang('questionnaire-campaign.detailsCampaign.surname')</th>
                                                    <th class="py-2 px-4">@lang('questionnaire-campaign.detailsCampaign.dob')</th>
                                                    <th class="py-2 px-4">@lang('questionnaire-campaign.detailsCampaign.gender')</th>
                                                    <th class="py-2 px-4">@lang('questionnaire-campaign.detailsCampaign.companyRole')</th>
                                                    <th class="py-2 px-4">@lang('questionnaire-campaign.detailsCampaign.email')</th>
                                                </tr>
                                            </thead>
                                            <tbody class="bg-white">
                                                @foreach ($users as $user)
                                                    <tr class="hover:bg-gray-100 border-b border-gray-200">
                                                        <td class="py-2 px-4">{{ $user->name }}</td>
                                                        <td class="py-2 px-4">{{ $user->surname }}</td>
                                                        <td class="py-2 px-4">
                                                            {{ \Carbon\Carbon::parse($user->dob)->format('d/m/Y') }}
                                                        </td>
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
                                                <x-primary-button id="prevPage">@lang('questionnaire-campaign.detailsCampaign.previous')</x-primary-button>
                                            </div>
                                            <div class="flex flex-row justify-center items-center w-1/3 gap-4">
                                                <span id="pageIndicator" class="text-gray-700"></span>
                                                <span id="totalUsers" class="text-gray-500 text-sm"></span>
                                                <select id="rowsPerPage"
                                                    class="border border-gray-300 rounded-md shadow-sm">
                                                    <option value="10" selected>10</option>
                                                    <option value="20">20</option>
                                                    <option value="50">50</option>
                                                </select>
                                            </div>
                                            <div class="flex justify-center w-1/3">
                                                <x-primary-button id="nextPage">@lang('questionnaire-campaign.detailsCampaign.next')</x-primary-button>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="flex flex-col w-full item-center gap-2">
                                        <p class="text-center text-lg text-sky-700">@lang('questionnaire-campaign.detailsCampaign.noUsers')
                                        </p>
                                        <div class="flex justify-center">
                                            <a href="{{ route('questionnaire-campaign.users', ['questionnaireCampaign' => $questionnaireCampaign->id]) }}"
                                                id="chooseUsersButton" class="flex justify-end pt-2">
                                                <x-primary-button>@lang('questionnaire-campaign.detailsCampaign.chooseUsers')</x-primary-button>
                                            </a>
                                        </div>
                                    </div>
                                @endif
                            @else
                                <div class="flex flex-col w-full item-center gap-2">
                                    <p class="text-center text-lg text-sky-700">@lang('questionnaire-campaign.detailsCampaign.noQuestionnairesSelected')</p>
                                    <div class="flex justify-center">
                                        <a href="{{ route('questionnaire-campaign.questionnaires', ['questionnaireCampaign' => $questionnaireCampaign->id]) }}"
                                            id="chooseQuestionnaireButton" class="flex justify-end pt-2">
                                            <x-primary-button>@lang('questionnaire-campaign.detailsCampaign.chooseQuestionnaires')</x-primary-button>
                                        </a>
                                    </div>
                                </div>
                            @endif
                        </div>

                </div>
            @else
                <div class="text-center text-xl">
                    <p>@lang('questionnaire-campaign.detailsCampaign.errorRetrievingCampaign')</p>
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

    var currentTab = 0;
    showTab(currentTab);

    function showTab(n) {
        var x = document.getElementsByClassName("email-container");
        if (x.length === 0) return; // Exit if no tabs are found

        for (var i = 0; i < x.length; i++) {
            x[i].style.display = "none";
        }

        x[n].style.display = "block";

        if (n === 0) {
            if (document.getElementById("prevBtn")) {
                document.getElementById("prevBtn").style.display = "none";
            }
        } else {
            document.getElementById("prevBtn").style.display = "inline";
        }

        if (n === (x.length - 1)) {
            if (document.getElementById("nextBtn")) {
                document.getElementById("nextBtn").style.display = "none";
            }
        } else {
            document.getElementById("nextBtn").style.display = "inline";
        }

        fixStepIndicator(n);
    }

    function nextPrev(n) {
        var x = document.getElementsByClassName("email-container");
        if (x.length === 0) return;

        x[currentTab].style.display = "none";
        currentTab += n;

        if (currentTab >= x.length) {
            currentTab = x.length - 1;
        } else if (currentTab < 0) {
            currentTab = 0;
        }

        showTab(currentTab);
    }

    function fixStepIndicator(n) {
        var i, x = document.getElementsByClassName("step");
        if (x.length === 0) return;

        for (i = 0; i < x.length; i++) {
            x[i].className = x[i].className.replace(" active", "");
        }
        x[n].className += " active";
    }

    document.addEventListener('DOMContentLoaded', function() {
        const chooseQuestionnaireButton = document.getElementById('chooseQuestionnaireButton');

        if (chooseQuestionnaireButton) {
            chooseQuestionnaireButton.addEventListener('click', function(event) {
                document.getElementById('loadingOverlay').classList.add('flex');
                document.getElementById('loadingOverlay').classList.remove('hidden');
            });
        }

        const chooseUsersButton = document.getElementById('chooseUsersButton');

        if (chooseUsersButton) {
            chooseUsersButton.addEventListener('click', function(event) {
                document.getElementById('loadingOverlay').classList.add('flex');
                document.getElementById('loadingOverlay').classList.remove('hidden');
            });
        }
    });
</script>
