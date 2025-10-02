<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row item-center gap-3">
            <!-- Breadcrumb -->
            <ul class="flex flex-row gap-1 flex-wrap break-words text-sky-800">
                <li><a href="{{ route('dashboard') }}">@lang('dashboard.dashboard')</a></li>
            </ul>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-8 text-sky-900">
                    <div class="text-sky-800">
                        <p class="text-center text-lg font-semibold">@lang('dashboard.welcome') {{ auth()->user()->name }}
                            {{ auth()->user()->surname }} </p>
                    </div>

                    @if (auth()->user()->role === 'Admin')
                        <div class="flex flex-col py-4">
                            @include('dashboard.partials.admin')
                        </div>
                    @elseif (auth()->user()->role === 'Evaluator')
                        <div class="flex flex-col py-4">
                            @include('dashboard.partials.evaluator')
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
