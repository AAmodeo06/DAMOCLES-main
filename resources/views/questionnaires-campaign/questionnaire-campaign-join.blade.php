<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row item-center gap-3">
            <!-- Back to questionnaire campaign -->
            <a href="{{ route('questionnaires-campaign.index') }}" class="cursor-pointer">
                <x-primary-button>
                    @lang('questionnaire-campaign.join.back')
                </x-primary-button>
            </a>
            <!-- Breadcrumb -->
            <ul class="flex flex-row gap-1 flex-wrap break-words text-sky-800">
                <li><a href="{{ route('questionnaires-campaign.index') }}">@lang('questionnaire-campaign.join.questionnaireCampaign')</a></li>
            </ul>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-8 text-sky-900">

                    <p class="font-semibold text-xl">@lang('questionnaire-campaign.join.details')</p>

                    @if ($questionnaireCampaign)
                        <div class="flex flex-col">
                            <div class="flex flex-row gap-2">
                                <p class="font-semibold">
                                    @lang('questionnaire-campaign.join.title'):
                                </p>
                                <p>{{ $questionnaireCampaign->title }}</p>
                            </div>

                            <div class="flex flex-row gap-2">
                                <p class="font-semibold">
                                    @lang('questionnaire-campaign.join.description'):
                                </p>
                                <p>{{ $questionnaireCampaign->description }}</p>
                            </div>

                            <div class="flex flex-row gap-2">
                                <p class="font-semibold">
                                    @lang('questionnaire-campaign.join.expirationDate'):
                                </p>
                                <p>{{ \Carbon\Carbon::parse($questionnaireCampaign->expirationDate)->format('d/m/Y') }}
                                </p>
                            </div>

                            <!-- Questionnaires -->
                            @if ($questionnaires->isNotEmpty())
                                <div class="gap-2">
                                    <p class="font-semibold">@lang('questionnaire-campaign.join.questionnaires'):</p>
                                    <div class="flex flex-wrap gap-2">
                                        <table id="questionnaires-campaign-table"
                                            class="min-w-full text-center border-collapse">
                                            <thead class="bg-gray-100">
                                                <tr class="border-b-2 border-gray-300">
                                                    <th class="py-2 px-4">@lang('questionnaire-campaign.join.title')</th>
                                                    <th class="py-2 px-4"></th>
                                                </tr>
                                            </thead>
                                            <tbody class="bg-white">
                                                @foreach ($questionnaires as $index => $questionnaire)
                                                    @php
                                                        // Check if the user has already answered
                                                        $alreadyAnswered = App\Models\UserQuestionnaireAnswer::where([
                                                            'user_id' => Auth::id(),
                                                            'q_id' => $questionnaire->id,
                                                            'q_c_id' => $questionnaireCampaign->id,
                                                        ])->exists();
                                                    @endphp

                                                    <tr class="hover:bg-gray-100 border-b border-gray-200">
                                                        <td class="py-2 px-4">{{ $questionnaire->name }}</td>

                                                        <td class="py-2 px-4">
                                                            @if ($alreadyAnswered)
                                                                <a
                                                                    href="{{ route(strtolower($questionnaire->name) . '.answer', ['user' => Auth::id(), 'questionnaireCampaign' => $questionnaireCampaign->id, 'questionnaire' => $questionnaire->id]) }}">
                                                                    <x-primary-button>
                                                                        @lang('questionnaire-campaign.join.showAnswers')
                                                                    </x-primary-button>
                                                                </a>
                                                            @elseif ($questionnaireCampaign->state == 'Finished' && !$alreadyAnswered)
                                                                <p>@lang('questionnaire-campaign.join.expired')</p>
                                                            @else
                                                                <a
                                                                    href="{{ route(strtolower($questionnaire->name) . '.index', ['questionnaireCampaign' => $questionnaireCampaign->id, 'questionnaire' => $questionnaire->id]) }}">
                                                                    <x-primary-button>
                                                                        @lang('questionnaire-campaign.join.start')
                                                                    </x-primary-button>
                                                                </a>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @else
                                <div class="flex flex-col w-full item-center gap-2">
                                    <p class="text-center text-lg text-sky-700">@lang('questionnaire-campaign.join.noQuestionnaires')</p>
                                </div>
                            @endif
                        </div>

                </div>
            @else
                <div class="text-center text-xl">
                    <p>@lang('questionnaire-campaign.join.errorRetrievingCampaign')</p>
                </div>
                @endif
            </div>
        </div>
    </div>
    </div>

</x-app-layout>
