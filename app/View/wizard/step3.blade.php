{{-- resources/views/wizard/step3.blade.php --}}
{{-- REALIZZATO DA: Andrea Amodeo --}}

@extends('layouts.app')

@section('title', 'Wizard Campagna - Step 3')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-8">
            <div class="text-center">
                <h1 class="text-3xl font-bold text-gray-900">Durata e Pianificazione</h1>
                <p class="mt-2 text-gray-600">Step 3 di 6: Configura la durata della campagna</p>
            </div>

            <div class="mt-6 w-full bg-gray-200 rounded-full h-3">
                <div class="bg-blue-600 h-3 rounded-full transition-all duration-300"
                     style="width: {{ $progress }}%"></div>
            </div>
        </div>

        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
            <form action="{{ route('wizard.process.step3', $session) }}" method="POST">
                @csrf

                <div class="px-8 py-6">
                    <div class="mb-8">
                        <label class="block text-sm font-medium text-gray-700 mb-4">
                            Durata della Campagna
                        </label>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                            @foreach($durationPresets as $weeks => $description)
                                <label class="flex items-center p-4 border rounded-lg cursor-pointer hover:bg-gray-50">
                                    <input type="radio" name="duration_weeks" value="{{ $weeks }}"
                                           class="mr-3 text-blue-600" {{ old('duration_weeks') == $weeks ? 'checked' : '' }}>
                                    <div>
                                        <div class="font-medium">{{ $weeks }} settiman{{ $weeks > 1 ? 'e' : 'a' }}</div>
                                        <div class="text-sm text-gray-600">{{ $description }}</div>
                                    </div>
                                </label>
                            @endforeach
                        </div>

                        <div class="flex items-center">
                            <label class="flex items-center mr-4">
                                <input type="radio" name="duration_weeks" value="custom"
                                       class="mr-2 text-blue-600" {{ old('duration_weeks') === 'custom' ? 'checked' : '' }}>
                                <span class="text-sm font-medium">Personalizzato:</span>
                            </label>
                            <input type="number" name="custom_duration" min="1" max="52"
                                   class="w-20 border border-gray-300 rounded-lg p-2 text-center"
                                   placeholder="8" value="{{ old('custom_duration') }}">
                            <span class="ml-2 text-sm text-gray-600">settimane</span>
                        </div>

                        @error('duration_weeks')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Frequenza delle Simulazioni
                        </label>
                        <select name="frequency" class="w-full border border-gray-300 rounded-lg p-3">
                            <option value="daily">Giornaliera - Maggiore intensità</option>
                            <option value="weekly" selected>Settimanale - Bilanciato</option>
                            <option value="bi-weekly">Bi-settimanale - Più rilassato</option>
                        </select>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Data di Inizio (Opzionale)
                            </label>
                            <input type="date" name="start_date"
                                   class="w-full border border-gray-300 rounded-lg p-3"
                                   min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                                   value="{{ old('start_date') }}">
                            <p class="mt-1 text-xs text-gray-500">Se non specificata, inizierà immediatamente</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Fuso Orario
                            </label>
                            <select name="timezone" class="w-full border border-gray-300 rounded-lg p-3">
                                <option value="Europe/Rome" selected>Europa/Roma (GMT+1)</option>
                                <option value="UTC">UTC (GMT+0)</option>
                                <option value="America/New_York">America/New York (GMT-5)</option>
                                <option value="Asia/Tokyo">Asia/Tokyo (GMT+9)</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="px-8 py-4 bg-gray-50 flex justify-between">
                    <a href="{{ route('wizard.step2', $session) }}" class="px-4 py-2 text-gray-600 hover:text-gray-800">
                        ← Step Precedente
                    </a>
                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        Continua → Step 4
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
