<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row item-center gap-3">
            <!-- Breadcrumb -->
            <ul class="flex flex-row gap-1 flex-wrap break-words text-sky-800">
                <li><a href="{{ route('questionnaires') }}">@lang('questionnaire-campaign.questionnaires')</a></li>
            </ul>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white sm:overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-8 text-sky-900">
                    <div class="space-y-6">
                        <div>
                            <p class="text-lg font-medium text-sky-900">
                                @lang('questionnaire-campaign.questionnaires'):
                            </p>
                            @if ($questionnaires->isEmpty())
                                <p class="text-center">@lang('questionnaire-campaign.noQuestionnaires')</p>
                            @else
                                <div id="questionnaireButtons" class="flex flex-wrap gap-2">
                                    <table id="questionnaires-table" class="w-full text-center">
                                        <thead class="bg-gray-100">
                                            <tr class="border-b-2 border-gray-300">
                                                <th class="w-2/3 py-2 px-4">@lang('questionnaire-campaign.nameQuestionnaire')</th>
                                                <th class="w-1/3 py-2 px-4"></th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white">
                                            @foreach ($questionnaires as $questionnaire)
                                                <tr class="hover:bg-gray-100 border-b border-gray-200">
                                                    <td class="w-2/3 py-2 px-4">{{ $questionnaire->name }}</td>
                                                    <td class="w-1/3 py-2 px-4">

                                                        <a
                                                            href="{{ route(strtolower($questionnaire->name) . '.preview') }}">
                                                            <x-primary-button>
                                                                @lang('questionnaire-campaign.preview')
                                                            </x-primary-button>
                                                        </a>

                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
