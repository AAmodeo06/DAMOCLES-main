<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row item-center gap-3">
            <!-- Back to phishing campaign -->
            <a href="{{ route('phishing-campaign.index') }}" class="cursor-pointer">
                <x-primary-button>
                    @lang('phishing-campaign.sent.back')
                </x-primary-button>
            </a>
            <!-- Breadcrumb -->
            <ul class="flex flex-row gap-1 flex-wrap break-words text-sky-800">
                <li><a href="{{ route('phishing-campaign.index') }}">@lang('phishing-campaign.sent.phishingCampaign')</a></li>
                <li>/</li>
                <li><a href="{{ route('phishing-campaign.new') }}">@lang('phishing-campaign.sent.new')</a></li>
                <li>/</li>
                <li><a>@lang('phishing-campaign.sent.sent')</a></li>
            </ul>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-8 text-sky-900">

                    <!-- Email sent -->
                    @if (isset($emailSent))
                        @if (!$usersWithEmailSent->isEmpty())
                            <h3 class="text-lg font-semibold text-sky-700 pb-2">@lang('phishing-campaign.sent.sentTo')</h3>
                            <div>
                                <table id="user-table-sent" class="w-full text-center">
                                    <thead>
                                        <tr>
                                            <th>@lang('phishing-campaign.sent.name')</th>
                                            <th>@lang('phishing-campaign.sent.surname')</th>
                                            <th>@lang('phishing-campaign.sent.email')</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($usersWithEmailSent as $user)
                                            <tr>
                                                <td>{{ $user->name }}</td>
                                                <td>{{ $user->surname }}</td>
                                                <td>{{ $user->email }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                        @endif

                        @if (!$usersWithoutEmailSent->isEmpty())
                            <div class="pt-4">
                                <h3 class="text-lg font-semibold text-red-700 pb-2">@lang('phishing-campaign.sent.emailNotSent')</h3>
                                <div>
                                    <table id="user-table-not-sent" class="w-full text-center">
                                        <thead>
                                            <tr>
                                                <th>@lang('phishing-campaign.sent.name')</th>
                                                <th>@lang('phishing-campaign.sent.surname')</th>
                                                <th>@lang('phishing-campaign.sent.email')</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($usersWithoutEmailSent as $user)
                                                <tr>
                                                    <td>{{ $user->name }}</td>
                                                    <td>{{ $user->surname }}</td>
                                                    <td>{{ $user->email }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endif
                    @endif

                </div>
            </div>
        </div>

</x-app-layout>
