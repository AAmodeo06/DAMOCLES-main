{{-- resources/views/wizard/step1.blade.php --}}
{{-- REALIZZATO DA: Andrea Amodeo --}}

@extends('layouts.app')

@section('title', 'Wizard Campagna - Step 1')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Header con Progress Bar --}}
        <div class="mb-8">
            <div class="text-center">
                <h1 class="text-3xl font-bold text-gray-900">Crea Nuova Campagna di Training</h1>
                <p class="mt-2 text-gray-600">Step 1 di 6: Seleziona i Tipi di Attacco</p>
            </div>

            {{-- Progress Bar --}}
            <div class="mt-6 w-full bg-gray-200 rounded-full h-3">
                <div class="bg-blue-600 h-3 rounded-full transition-all duration-300"
                     style="width: {{ $progress }}%"></div>
            </div>
        </div>

        {{-- Main Form --}}
        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
            <form action="{{ route('wizard.process.step1') }}" method="POST">
                @csrf

                <div class="px-8 py-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-6">
                        🎯 Seleziona i Tipi di Attacco da Includere
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
                        @foreach($attackTypes as $key => $attack)
                            <label class="flex items-start p-5 border-2 border-gray-200 rounded-xl hover:border-blue-300 cursor-pointer transition-all">
                                <input type="checkbox" name="attack_types[]" value="{{ $key }}"
                                       class="mt-1 mr-4 h-5 w-5 text-blue-600 border-gray-300 rounded">

                                <div class="flex-1">
                                    <h3 class="font-semibold text-gray-900">{{ $attack['name'] }}</h3>
                                    <p class="text-sm text-gray-600 mb-2">{{ $attack['description'] }}</p>
                                    <span class="inline-flex px-2 py-1 text-xs rounded-full
                                        @if($attack['difficulty'] === 'beginner') bg-green-100 text-green-800
                                        @elseif($attack['difficulty'] === 'intermediate') bg-yellow-100 text-yellow-800
                                        @else bg-red-100 text-red-800 @endif">
                                        {{ ucfirst($attack['difficulty']) }}
                                    </span>
                                </div>
                            </label>
                        @endforeach
                    </div>

                    @error('attack_types')
                        <div class="mb-4 p-3 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="px-8 py-4 bg-gray-50 flex justify-between">
                    <a href="{{ route('dashboard') }}" class="px-4 py-2 text-gray-600 hover:text-gray-800">
                        ← Dashboard
                    </a>
                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        Continua → Step 2
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
