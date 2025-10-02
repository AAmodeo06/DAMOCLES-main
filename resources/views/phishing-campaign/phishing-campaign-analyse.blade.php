<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row items-center gap-3">
            <!-- Back to phishing campaign details -->
            <a href="{{ route('phishing-campaign.index') }}" class="cursor-pointer">
                <x-primary-button>
                    @lang('phishing-campaign.analyseCampaign.back')
                </x-primary-button>
            </a>
            <!-- Breadcrumb -->
            <ul class="flex flex-row gap-1 flex-wrap break-words text-sky-800">
                <li><a href="{{ route('phishing-campaign.index') }}">@lang('phishing-campaign.analyseCampaign.phishingCampaign')</a></li>
                <li>/</li>
                <li>@lang('phishing-campaign.analyseCampaign.analyse')</li>
            </ul>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-8 text-sky-900">

                    <div class="flex flex-col w-full">

                        <div class="flex justify-between">
                            <p class="font-semibold text-xl">@lang('phishing-campaign.analyseCampaign.analyses')</p>

                            <x-primary-button class="hover:bg-gray-100 inner-element"
                                data-id="{{ $phishingCampaign->id }}" x-data=""
                                @click="$dispatch('open-modal', 'download-data-csv-modal', { id: {{ $phishingCampaign->id }} })">@lang('phishing-campaign.analyseCampaign.downloadData')</x-primary-button>
                        </div>

                        <!-- Charts -->
                        <div class="my-4">
                            <div
                                class="flex flex-col py-2 space-y-4 md:space-y-0 md:flex-row md:justify-around w-full items-center">
                                <div class="flex flex-col items-center w-60 md:w-64">
                                    <canvas id="totalEmails"></canvas>
                                </div>
                                <div class="flex flex-col items-center w-60 md:w-64">
                                    <canvas id="openedEmails"></canvas>
                                </div>
                                <div class="flex flex-col items-center w-60 md:w-64">
                                    <canvas id="clickedEmails"></canvas>
                                </div>
                            </div>
                            <div
                                class="flex flex-col py-2 space-y-4 md:space-y-0 md:flex-row md:justify-around w-full items-center">
                                <div class="flex flex-col items-center w-60 md:w-64">
                                    <canvas id="genderOpened"></canvas>
                                </div>
                                <div class="flex flex-col items-center w-60 md:w-64">
                                    <canvas id="genderClicked"></canvas>
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-col md:flex-row justify-end items-center gap-4">
                            <!-- Filter -->
                            @if ($users->count() > 1)
                                <div class="flex w-full md:w-1/2 justify-center md:justify-end">
                                    <div class="flex flex-row w-80 gap-3 justify-end items-center relative">
                                        <label for="filter"
                                            class="block text-sm font-bold text-sky-700">@lang('phishing-campaign.analyseCampaign.search')</label>
                                        <input type="text" id="filter" name="filter"
                                            class="p-2 border border-sky-700 focus:border-sky-800 focus:ring-sky-800 rounded-md shadow-sm w-full placeholder:text-sky-700"
                                            placeholder="@lang('phishing-campaign.analyseCampaign.placeholderFilter')">
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

                    <!-- User -->
                    <div id="no-results" class="font-bold py-4 text-center hidden">
                        @lang('phishing-campaign.analyseCampaign.noResult')
                    </div>

                    @foreach ($users as $user)
                        <div class="py-4 user-entry" id="user-{{ $user->id }}">
                            <div class="flex flex-col">
                                <div class="flex flex-row gap-1">
                                    <p class="font-bold">@lang('phishing-campaign.analyseCampaign.user'):</p>
                                    <p class="user-name">{{ $user->name }} {{ $user->surname }}</p>
                                </div>
                                <div class="flex flex-row gap-1">
                                    <p class="font-bold">@lang('phishing-campaign.analyseCampaign.gender'):</p>
                                    <p class="user-gender">{{ $user->gender }}</p>
                                </div>
                                <div class="flex flex-row gap-1">
                                    <p class="font-bold">@lang('phishing-campaign.analyseCampaign.email'):</p>
                                    <p class="user-email">{{ $user->email }}</p>
                                </div>
                            </div>
                            <div class="w-full text-center mb-4">
                                <table id="email-table-{{ $user->id }}" class="w-full text-center mb-4">
                                    <thead class="bg-gray-100">
                                        <tr class="border-b-2 border-gray-300">
                                            <th class="py-2 px-4">@lang('phishing-campaign.analyseCampaign.subject')</th>
                                            <th class="py-2 px-4">@lang('phishing-campaign.analyseCampaign.sent')</th>
                                            <th class="py-2 px-4">@lang('phishing-campaign.analyseCampaign.opened')</th>
                                            <th class="py-2 px-4">@lang('phishing-campaign.analyseCampaign.clicked')</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white">
                                        @foreach ($user->emails as $email)
                                            <tr class="hover:bg-gray-100 border-b border-gray-200">
                                                <td class="py-2 px-4">{{ $email['email']->subject }}</td>
                                                <td
                                                    class="py-2 px-4 {{ $email['sent'] ? 'text-green-500' : 'text-red-500' }}">
                                                    {!! $email['sent'] ? 'Yes - ' . \Carbon\Carbon::parse($email['sent'])->format('d/m/Y H:i') : 'No' !!}
                                                </td>
                                                <td
                                                    class="py-2 px-4 {{ $email['opened'] ? 'text-green-500' : 'text-red-500' }}">
                                                    {!! $email['opened'] ? 'Yes - ' . \Carbon\Carbon::parse($email['opened'])->format('d/m/Y H:i') : 'No' !!}
                                                </td>
                                                <td
                                                    class="py-2 px-4 {{ $email['clicked'] ? 'text-green-500' : 'text-red-500' }}">
                                                    {!! $email['clicked'] ? 'Yes - ' . \Carbon\Carbon::parse($email['clicked'])->format('d/m/Y H:i') : 'No' !!}
                                                </td>
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
                            <x-primary-button id="prevUser">@lang('phishing-campaign.analyseCampaign.previous')</x-primary-button>
                        </div>
                        <div class="flex justify-center w-1/3">
                            <span id="userIndicator" class="text-gray-700"></span>
                        </div>
                        <div class="flex justify-center w-1/3">
                            <x-primary-button id="nextUser">@lang('phishing-campaign.analyseCampaign.next')</x-primary-button>
                        </div>
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

<!-- Download data csv modal -->
<x-modal name="download-data-csv-modal" id="download-data-csv-modal" title="Download data csv Phishing Campaign"
    :show="false">
    <div class="p-4 rounded-lg relative">
        @include('phishing-campaign.modals.download-data-csv')
    </div>
</x-modal>

<script>
    // Charts initialization
    const totalEmailsCount = {{ $userPhishingEmails->count() }};
    const sentEmailsCount = {{ $emailSent->count() }};
    const emailOpenedCount = {{ $emailOpened->count() }};
    const emailNotOpenedCount = {{ $emailNotOpened->count() }};
    const emailClickedCount = {{ $emailClicked->count() }};
    const emailNotClickedCount = {{ $emailNotClicked->count() }};

    const dataTotalEmails = [{
            status: 'Not sent',
            count: totalEmailsCount - sentEmailsCount
        },
        {
            status: 'Sent',
            count: sentEmailsCount
        }
    ];

    new Chart(document.getElementById('totalEmails'), {
        type: 'doughnut',
        data: {
            labels: dataTotalEmails.map(row => row.status),
            datasets: [{
                data: dataTotalEmails.map(row => row.count),
                backgroundColor: ['#F44336', '#4CAF50']
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'left',
                },
                title: {
                    display: true,
                    text: 'Total emails (' + totalEmailsCount + ') and emails sent (' + sentEmailsCount + ')'
                }
            }
        }
    });

    const opened = sentEmailsCount - emailNotOpenedCount
    const notOpened = sentEmailsCount - emailOpenedCount
    const dataOpenedEmails = [{
            status: 'Not opened',
            count: notOpened
        },
        {
            status: 'Opened',
            count: opened
        }
    ];

    new Chart(document.getElementById('openedEmails'), {
        type: 'doughnut',
        data: {
            labels: dataOpenedEmails.map(row => row.status),
            datasets: [{
                data: dataOpenedEmails.map(row => row.count),
                backgroundColor: ['#F44336', '#4CAF50']
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'left',
                },
                title: {
                    display: true,
                    text: 'Emails opened (' + opened + ') and not opened (' + notOpened + ')'
                }
            }
        }
    });

    const clicked = sentEmailsCount - emailNotClickedCount
    const notClicked = sentEmailsCount - emailClickedCount
    const dataClickedEmails = [{
            status: 'Not clicked',
            count: notClicked
        },
        {
            status: 'Clicked',
            count: clicked
        }
    ];

    new Chart(document.getElementById('clickedEmails'), {
        type: 'doughnut',
        data: {
            labels: dataClickedEmails.map(row => row.status),
            datasets: [{
                data: dataClickedEmails.map(row => row.count),
                backgroundColor: ['#F44336', '#4CAF50']
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'left',
                },
                title: {
                    display: true,
                    text: 'Emails clicked (' + clicked + ') and not clicked (' + notClicked + ')'
                }
            }
        }
    });

    const dataGenderOpened = [{
            status: 'Male',
            count: emailOpenedCount - {{ $openedFemaleCount }} - {{ $openedOtherCount }}
        },
        {
            status: 'Female',
            count: emailOpenedCount - {{ $openedMaleCount }} - {{ $openedOtherCount }}
        },
        {
            status: 'Other',
            count: emailOpenedCount - {{ $openedMaleCount }} - {{ $openedFemaleCount }}
        }
    ];

    new Chart(document.getElementById('genderOpened'), {
        type: 'doughnut',
        data: {
            labels: dataGenderOpened.map(row => row.status),
            datasets: [{
                data: dataGenderOpened.map(row => row.count),
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'left',
                },
                title: {
                    display: true,
                    text: 'Gender has opened on the phishing email'
                }
            }
        }
    });

    const dataGenderClicked = [{
            status: 'Male',
            count: emailClickedCount - {{ $clickedFemaleCount }} - {{ $clickedOtherCount }}
        },
        {
            status: 'Female',
            count: emailClickedCount - {{ $clickedMaleCount }} - {{ $clickedOtherCount }}
        },
        {
            status: 'Other',
            count: emailClickedCount - {{ $clickedMaleCount }} - {{ $clickedFemaleCount }}
        }
    ];

    new Chart(document.getElementById('genderClicked'), {
        type: 'doughnut',
        data: {
            labels: dataGenderClicked.map(row => row.status),
            datasets: [{
                data: dataGenderClicked.map(row => row.count),
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'left',
                },
                title: {
                    display: true,
                    text: 'Gender has clicked on the phishing link'
                }
            }
        }
    });

    // Tabulation and Filter
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
                    const gender = container.querySelector('.user-gender').textContent
                        .toLowerCase();

                    if (name.includes(filterValue) || email.includes(filterValue) || gender
                        .includes(filterValue)) {
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
