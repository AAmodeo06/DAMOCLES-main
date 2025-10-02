<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row item-center gap-3">
            <!-- Back to phishing campaign -->
            <a href="{{ route('phishing-campaign.index') }}" class="cursor-pointer">
                <x-primary-button>
                    @lang('phishing-campaign.detailsCampaign.back')
                </x-primary-button>
            </a>
            <!-- Breadcrumb -->
            <ul class="flex flex-row gap-1 flex-wrap break-words text-sky-800">
                <li><a href="{{ route('phishing-campaign.index') }}">@lang('phishing-campaign.detailsCampaign.phishingCampaign')</a></li>
                <li>/</li>
                <li>@lang('phishing-campaign.detailsCampaign.phishingCampaignDetails')</li>
            </ul>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-8 text-sky-900">

                    <p class="font-semibold text-xl">@lang('phishing-campaign.detailsCampaign.phishingCampaignDetails')</p>

                    @if ($phishingCampaign)
                        <div class="flex flex-col">
                            <div class="flex flex-row gap-2">
                                <p class="font-semibold">
                                    @lang('phishing-campaign.detailsCampaign.title'):
                                </p>
                                <p>{{ $phishingCampaign->title }}</p>
                            </div>

                            <div class="flex flex-row gap-2">
                                <p class="font-semibold">
                                    @lang('phishing-campaign.detailsCampaign.description'):
                                </p>
                                <p>{{ $phishingCampaign->description }}</p>
                            </div>

                            <div class="flex flex-row gap-2">
                                <p class="font-semibold">
                                    @lang('phishing-campaign.detailsCampaign.expirationDate'):
                                </p>
                                <p>{{ \Carbon\Carbon::parse($phishingCampaign->expirationDate)->format('d/m/Y') }}</p>
                            </div>

                            <div class="flex flex-row gap-2">
                                <p class="font-semibold">
                                    @lang('phishing-campaign.detailsCampaign.numbers'){{ $phishingCampaign->numberEmails == 1 ? '' : __('phishing-campaign.detailsCampaign.s') }}:
                                </p>
                                <p>{{ $phishingCampaign->numberEmails }}</p>
                            </div>

                            <div class="flex flex-row gap-2">
                                <p class="font-semibold">
                                    @lang('phishing-campaign.detailsCampaign.timingEmail'):
                                </p>
                                <p>{{ $phishingCampaign->timingEmail }}
                                    day{{ $phishingCampaign->timingEmail > 1 ? __('phishing-campaign.detailsCampaign.s') : '' }}</p>
                            </div>

                            <div class="flex flex-row gap-2">
                                <p class="font-semibold">@lang('phishing-campaign.detailsCampaign.context'):</p>
                                <p>{{ $phishingCampaign->phishingContext->description }}</p>
                            </div>

                            @if ($persuasions->isNotEmpty())
                                <div class="flex flex-row gap-2">
                                    <p class="font-semibold">@lang('phishing-campaign.detailsCampaign.persuasions'):</p>
                                    <p>
                                        @foreach ($persuasions as $index => $persuasion)
                                            {{ $persuasion->description }}{{ $index < $persuasions->count() - 1 ? ',' : '' }}
                                        @endforeach
                                    </p>
                                </div>
                            @endif

                            @if ($emotionalTriggers->isNotEmpty())
                                <div class="flex flex-row gap-2">
                                    <p class="font-semibold">@lang('phishing-campaign.detailsCampaign.emotionalTriggers'):</p>
                                    <p>
                                        @foreach ($emotionalTriggers as $index => $trigger)
                                            {{ $trigger->description }}{{ $index < $emotionalTriggers->count() - 1 ? ',' : '' }}
                                        @endforeach
                                    </p>
                                </div>
                            @endif

                            <div class="flex flex-col">
                                <p class="font-semibold">@lang('phishing-campaign.detailsCampaign.llm'):</p>
                                @if ($llm)
                                    <div class="flex flex-col">
                                        <p>@lang('phishing-campaign.detailsCampaign.provider'): {{ $llm->provider }}</p>
                                        <p> @lang('phishing-campaign.detailsCampaign.model'): {{ $llm->model }}</p>
                                    </div>
                                @else
                                    <p>@lang('phishing-campaign.detailsCampaign.llmNotFound')</p>
                                @endif
                            </div>

                            <!-- Phishing emails generated -->
                            @if ($emails->isEMpty())
                                <div class="flex flex-col gap-2">
                                    <p class="font-semibold">@lang('phishing-campaign.detailsCampaign.prompt'):</p>
                                    <textarea id="prompt" name="prompt"
                                        class="w-full p-2 border border-sky-700 focus:border-sky-800 focus:ring-sky-800 rounded-md shadow-sm" rows="4"
                                        readonly>{{ $phishingCampaign->prompt }}</textarea>
                                </div>
                            @endif

                            <div class="pt-2">
                                @if ($emails->isNotEmpty())
                                    @foreach ($emails as $index => $email)
                                        <div class="email-container tab flex flex-col">
                                            @if ($phishingCampaign->numberEmails > 1)
                                                <div class="flex flex-row gap-2">
                                                    <p class="font-semibold">
                                                        @lang('phishing-campaign.detailsCampaign.email'){{ $emails->count() > 1 ? __('phishing-campaign.detailsCampaign.s') : '' }}
                                                        @lang('phishing-campaign.detailsCampaign.generated')
                                                        ({{ $index + 1 }}/{{ $emails->count() }})
                                                        :
                                                    </p>
                                                </div>
                                            @else
                                                <p class="font-semibold">
                                                    @lang('phishing-campaign.detailsCampaign.email'):
                                                </p>
                                            @endif

                                            <p class="font-semibold">@lang('phishing-campaign.detailsCampaign.subject'):</p>
                                            <textarea id="subject-{{ $index }}"
                                                class="w-full p-2 border border-sky-700 focus:border-sky-800 focus:ring-sky-800 rounded-md shadow-sm tab-content"
                                                rows="2" readonly>{{ $email->subject }}</textarea>

                                            <p class="font-semibold">@lang('phishing-campaign.detailsCampaign.body'):</p>
                                            <textarea id="body-{{ $index }}"
                                                class="w-full p-2 border border-sky-700 focus:border-sky-800 focus:ring-sky-800 rounded-md shadow-sm tab-content"
                                                rows="10" readonly>{{ $email->body }}</textarea>
                                        </div>
                                    @endforeach

                                    @if ($emails->count() > 1)
                                        <div class="flex w-full items-center py-2">
                                            <div class="flex w-1/3 justify-center">
                                                <x-primary-button type="button" id="prevBtn"
                                                    onclick="nextPrev(-1)">@lang('phishing-campaign.detailsCampaign.previousEmail')</x-primary-button>
                                            </div>
                                            <!-- Circles which indicate the steps of the bodies: -->
                                            <div class="flex w-1/3 justify-center flex-row">
                                                @for ($i = 0; $i < $emails->count(); $i++)
                                                    <span
                                                        class="step @if ($i === 0) active @endif"></span>
                                                @endfor
                                            </div>
                                            <div class="flex w-1/3 justify-center">
                                                <x-primary-button type="button" id="nextBtn"
                                                    onclick="nextPrev(1)">@lang('phishing-campaign.detailsCampaign.nextEmail')</x-primary-button>
                                            </div>
                                        </div>
                                    @endif

                                    <!-- Users selected -->
                                    @if (count($users) == 0)
                                        <div class="flex flex-col w-full item-center pt-2 gap-2">
                                            <p class="text-center text-lg text-sky-700">@lang('phishing-campaign.detailsCampaign.noUsers')</p>

                                            <div class="flex justify-center">
                                                <a href="{{ route('phishing-campaign.users', ['phishingCampaign' => $phishingCampaign->id]) }}"
                                                    id="chooseUserButton" class="flex justify-end pt-2">
                                                    <x-primary-button>@lang('phishing-campaign.detailsCampaign.chooseUsers')</x-primary-button>
                                                </a>
                                            </div>
                                        </div>
                                    @else
                                        <div class="flex flex-col pt-2 gap-2">
                                            <p class="font-semibold">@lang('phishing-campaign.detailsCampaign.users'):</p>
                                            <table id="user-table" class="w-full text-center">
                                                <thead class="bg-gray-100">
                                                    <tr class="border-b-2 border-gray-300">
                                                        <th class="py-2 px-4">@lang('phishing-campaign.detailsCampaign.name')</th>
                                                        <th class="py-2 px-4">@lang('phishing-campaign.detailsCampaign.surname')</th>
                                                        <th class="py-2 px-4">@lang('phishing-campaign.detailsCampaign.dob')</th>
                                                        <th class="py-2 px-4">@lang('phishing-campaign.detailsCampaign.gender')</th>
                                                        <th class="py-2 px-4">@lang('phishing-campaign.detailsCampaign.companyRole')</th>
                                                        <th class="py-2 px-4">@lang('phishing-campaign.detailsCampaign.email')</th>
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
                                                    <x-primary-button
                                                        id="prevPage">@lang('phishing-campaign.detailsCampaign.previous')</x-primary-button>
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
                                                    <x-primary-button
                                                        id="nextPage">@lang('phishing-campaign.detailsCampaign.next')</x-primary-button>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Send email button -->
                                        <!--
                            <x-primary-button>@lang('phishing-campaign.detailsCampaign.send'){{ $phishingCampaign->numberEmails > 1 ? __('phishing-campaign.detailsCampaign.s') : '' }}</x-primary-button>
                            -->
                                    @endif
                                @else
                                    <!-- Generate the phishing emails -->
                                    <div class="flex flex-col w-full item-center pt-2 gap-2">
                                        <p class="text-center text-lg text-sky-700">
                                            @lang('phishing-campaign.detailsCampaign.noEmails')
                                        </p>
                                        <div class="flex justify-center">
                                            <a href="{{ route('phishing-campaign.generate-emails', ['phishingCampaign' => $phishingCampaign->id]) }}"
                                                id="generateEmailsButton" class="flex justify-end pt-2">
                                                <x-primary-button>
                                                    @lang('phishing-campaign.detailsCampaign.generate'){{ $phishingCampaign->numberEmails > 1 ? __('phishing-campaign.detailsCampaign.s') : '' }}
                                                </x-primary-button>
                                            </a>
                                        </div>
                                    </div>

                                @endif

                            </div>

                        </div>
                    @else
                        <div class="text-center text-xl">
                            <p>@lang('phishing-campaign.detailsCampaign.errorRetrievingCampaign')</p>
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
        const generateButton = document.getElementById('generateEmailsButton');

        if (generateButton) {
            generateButton.addEventListener('click', function(event) {
                document.getElementById('loadingOverlay').classList.add('flex');
                document.getElementById('loadingOverlay').classList.remove('hidden');
            });
        }

        const chooseUserButton = document.getElementById('chooseUserButton');

        if (chooseUserButton) {
            chooseUserButton.addEventListener('click', function(event) {
                document.getElementById('loadingOverlay').classList.add('flex');
                document.getElementById('loadingOverlay').classList.remove('hidden');
            });
        }
    });
</script>
