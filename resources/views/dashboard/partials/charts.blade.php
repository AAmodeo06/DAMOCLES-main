<section>

    <div class="flex flex-wrap space-y-6 justify-center md:space-y-0 md:justify-around w-full items-center">
        @if ($totalPhishingCampaigns != 0)
            <div class="flex flex-col items-center w-80 md:w-1/4">
                <canvas id="phishingCampaigns"></canvas>
                <p class="text-sm">@lang('dashboard.charts.totalCampaigns'): {{ $totalPhishingCampaigns }} </p>
            </div>
        @endif

        @if ($totalQuestionnaireCampaigns != 0)
            <div class="flex flex-col items-center w-80 md:w-1/4">
                <canvas id="questionnairesCampaigns"></canvas>
                <p class="text-sm">@lang('dashboard.charts.totalCampaigns'): {{ $totalQuestionnaireCampaigns }} </p>
            </div>
        @endif
    </div>

</section>

<script>
    if ({{ $totalPhishingCampaigns }} > 0) {
        const dataPhishingCampaigns = [{
                status: 'Draft',
                count: {!! $phishingCampaignsDraft !!}
            },
            {
                status: 'Ready',
                count: {!! $phishingCampaignsReady !!}
            },
            {
                status: 'Ongoing',
                count: {!! $phishingCampaignsOngoing !!}
            },
            {
                status: 'Finished',
                count: {!! $phishingCampaignsFinished !!}
            },

        ];

        new Chart(
            document.getElementById('phishingCampaigns'), {
                type: 'doughnut',
                data: {
                    labels: dataPhishingCampaigns.map(row => row.status),
                    datasets: [{
                        data: dataPhishingCampaigns.map(row => row.count)
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
                            text: 'Phishing campaigns chart'
                        }
                    }
                }
            }
        );
    }

    if ({{ $totalQuestionnaireCampaigns }} > 0) {
        const dataQuestionnairesCampaigns = [{
                status: 'Draft',
                count: {!! $questionnairesCampaignsDraft !!}
            },
            {
                status: 'Ready',
                count: {!! $questionnairesCampaignsReady !!}
            },
            {
                status: 'Ongoing',
                count: {!! $questionnairesCampaignsOngoing !!}
            },
            {
                status: 'Finished',
                count: {!! $questionnairesCampaignsFinished !!}
            },

        ];

        new Chart(
            document.getElementById('questionnairesCampaigns'), {
                type: 'doughnut',
                data: {
                    labels: dataQuestionnairesCampaigns.map(row => row.status),
                    datasets: [{
                        data: dataQuestionnairesCampaigns.map(row => row.count)
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
                            text: 'Questionnaire campaigns chart'
                        }
                    }
                }
            }
        );
    }
</script>
