{{-- resources/views/wizard/step2.blade.php --}}
{{-- REALIZZATO DA: Andrea Amodeo --}}

@extends('layouts.app')

@section('title', 'Wizard Campagna - Step 2')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-8">
            <div class="text-center">
                <h1 class="text-3xl font-bold text-gray-900">Target Audience e Difficoltà</h1>
                <p class="mt-2 text-gray-600">Step 2 di 6: Definisci il pubblico target</p>
            </div>

            <div class="mt-6 w-full bg-gray-200 rounded-full h-3">
                <div class="bg-blue-600 h-3 rounded-full transition-all duration-300"
                     style="width: {{ $progress }}%"></div>
            </div>
        </div>

        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
            <form action="{{ route('wizard.process.step2', $session) }}" method="POST">
                @csrf

                <div class="px-8 py-6">
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Descrizione del Target Audience
                        </label>
                        <textarea name="target_audience" rows="3"
                                  class="w-full border border-gray-300 rounded-lg p-3 focus:ring-blue-500 focus:border-blue-500"
                                  placeholder="Es: Dipendenti dell'ufficio amministrativo con esperienza limitata in cybersecurity...">{{ old('target_audience') }}</textarea>
                        @error('target_audience')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Livello di Difficoltà
                        </label>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            @foreach($difficulties as $key => $difficulty)
                                <label class="flex items-center p-4 border rounded-lg cursor-pointer hover:bg-gray-50">
                                    <input type="radio" name="difficulty" value="{{ $key }}"
                                           class="mr-3 text-blue-600" {{ old('difficulty') === $key ? 'checked' : '' }}>
                                    <div>
                                        <div class="font-medium">{{ $difficulty['name'] }}</div>
                                        <div class="text-sm text-gray-600">{{ $difficulty['description'] }}</div>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                        @error('difficulty')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Dimensione Azienda
                            </label>
                            <select name="company_size" class="w-full border border-gray-300 rounded-lg p-3">
                                <option value="">Seleziona...</option>
                                <option value="small">Piccola (1-50 dipendenti)</option>
                                <option value="medium">Media (51-200 dipendenti)</option>
                                <option value="large">Grande (201-1000 dipendenti)</option>
                                <option value="enterprise">Enterprise (1000+ dipendenti)</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Settore Industria
                            </label>
                            <input type="text" name="industry"
                                   class="w-full border border-gray-300 rounded-lg p-3"
                                   placeholder="Es: Bancario, Sanità, Manifatturiero..."
                                   value="{{ old('industry') }}">
                        </div>
                    </div>
                </div>

                <div class="px-8 py-4 bg-gray-50 flex justify-between">
                    <a href="{{ route('wizard.step1') }}" class="px-4 py-2 text-gray-600 hover:text-gray-800">
                        ← Step Precedente
                    </a>
                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        Continua → Step 3
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
