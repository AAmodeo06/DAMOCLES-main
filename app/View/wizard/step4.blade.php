{{-- resources/views/wizard/step4.blade.php --}}
{{-- REALIZZATO DA: Andrea Amodeo --}}

@extends('layouts.app')

@section('title', 'Wizard Campagna - Step 4')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-8">
            <div class="text-center">
                <h1 class="text-3xl font-bold text-gray-900">Fattori Umani e Personalizzazione</h1>
                <p class="mt-2 text-gray-600">Step 4 di 6: Configura i fattori psicologici da testare</p>
            </div>

            <div class="mt-6 w-full bg-gray-200 rounded-full h-3">
                <div class="bg-blue-600 h-3 rounded-full transition-all duration-300"
                     style="width: {{ $progress }}%"></div>
            </div>
        </div>

        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
            <form action="{{ route('wizard.process.step4', $session) }}" method="POST">
                @csrf

                <div class="px-8 py-6">
                    <div class="mb-8">
                        <h2 class="text-xl font-semibold text-gray-800 mb-4">
                            🧠 Seleziona i Fattori Umani da Testare
                        </h2>
                        <p class="text-gray-600 mb-6">
                            I fattori umani determinano come personalizzare gli attacchi per testare specifiche vulnerabilità comportamentali.
                        </p>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                            @foreach($humanFactors as $key => $factor)
                                <label class="flex items-start p-4 border-2 border-gray-200 rounded-lg hover:border-blue-300 cursor-pointer transition-all">
                                    <input type="checkbox" name="human_factors[]" value="{{ $key }}"
                                           class="mt-1 mr-3 h-5 w-5 text-blue-600 border-gray-300 rounded">

                                    <div class="flex-1">
                                        <h3 class="font-medium text-gray-900">{{ $factor }}</h3>
                                        <p class="text-sm text-gray-600 mt-1">
                                            @if($key === 'urgency') Testa la reazione a richieste urgenti e pressioni temporali
                                            @elseif($key === 'authority') Valuta la tendenza a obbedire a figure autorevoli
                                            @elseif($key === 'curiosity') Misura la propensione a esplorare contenuti sconosciuti
                                            @elseif($key === 'helpfulness') Testa la tendenza ad aiutare senza verifiche
                                            @elseif($key === 'fear') Valuta la reazione a scenari di paura o minacce
                                            @elseif($key === 'greed') Misura la vulnerabilità a offerte vantaggiose
                                            @elseif($key === 'social_proof') Testa l'influenza del comportamento altrui
                                            @elseif($key === 'reciprocity') Valuta la tendenza a ricambiare favori
                                            @endif
                                        </p>
                                    </div>
                                </label>
                            @endforeach
                        </div>

                        @error('human_factors')
                            <div class="mb-4 p-3 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-3">
                            Livello di Personalizzazione
                        </label>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <label class="flex items-center p-4 border rounded-lg cursor-pointer hover:bg-gray-50">
                                <input type="radio" name="personalization_level" value="low"
                                       class="mr-3 text-blue-600" {{ old('personalization_level') === 'low' ? 'checked' : '' }}>
                                <div>
                                    <div class="font-medium">Basso</div>
                                    <div class="text-sm text-gray-600">Contenuti generici</div>
                                </div>
                            </label>

                            <label class="flex items-center p-4 border rounded-lg cursor-pointer hover:bg-gray-50">
                                <input type="radio" name="personalization_level" value="medium"
                                       class="mr-3 text-blue-600" {{ old('personalization_level') === 'medium' ? 'checked' : '' }} checked>
                                <div>
                                    <div class="font-medium">Medio</div>
                                    <div class="text-sm text-gray-600">Adattamento moderato</div>
                                </div>
                            </label>

                            <label class="flex items-center p-4 border rounded-lg cursor-pointer hover:bg-gray-50">
                                <input type="radio" name="personalization_level" value="high"
                                       class="mr-3 text-blue-600" {{ old('personalization_level') === 'high' ? 'checked' : '' }}>
                                <div>
                                    <div class="font-medium">Alto</div>
                                    <div class="text-sm text-gray-600">Altamente personalizzato</div>
                                </div>
                            </label>
                        </div>
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-3">
                            Trigger Comportamentali Aggiuntivi (Opzionale)
                        </label>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                            @foreach(['deadline_pressure', 'social_validation', 'scarcity', 'consistency', 'liking', 'commitment'] as $trigger)
                                <label class="flex items-center">
                                    <input type="checkbox" name="behavioral_triggers[]" value="{{ $trigger }}"
                                           class="mr-2 text-blue-600">
                                    <span class="text-sm">{{ ucwords(str_replace('_', ' ', $trigger)) }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="px-8 py-4 bg-gray-50 flex justify-between">
                    <a href="{{ route('wizard.step3', $session) }}" class="px-4 py-2 text-gray-600 hover:text-gray-800">
                        ← Step Precedente
                    </a>
                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        Continua → Step 5
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
