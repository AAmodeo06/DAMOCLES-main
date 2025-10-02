{{-- resources/views/wizard/step6.blade.php --}}
{{-- REALIZZATO DA: Andrea Amodeo --}}

@extends('layouts.app')

@section('title', 'Wizard Campagna - Step 6')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-8">
            <div class="text-center">
                <h1 class="text-3xl font-bold text-gray-900">Riassunto e Finalizzazione</h1>
                <p class="mt-2 text-gray-600">Step 6 di 6: Controlla le impostazioni e completa la campagna</p>
            </div>

            <div class="mt-6 w-full bg-gray-200 rounded-full h-3">
                <div class="bg-green-600 h-3 rounded-full transition-all duration-300" style="width: 100%"></div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Riassunto Configurazione --}}
            <div class="lg:col-span-2">
                <div class="bg-white shadow-lg rounded-lg overflow-hidden mb-6">
                    <div class="px-6 py-4 bg-gradient-to-r from-blue-600 to-blue-700">
                        <h2 class="text-xl font-semibold text-white">📋 Riassunto Configurazione</h2>
                    </div>

                    <div class="px-6 py-6 space-y-6">
                        {{-- Tipi di Attacco --}}
                        <div>
                            <h3 class="font-semibold text-gray-800 mb-2">🎯 Tipi di Attacco</h3>
                            <div class="flex flex-wrap gap-2">
                                @if(isset($wizardData['attack_types']))
                                    @foreach($wizardData['attack_types'] as $attackType)
                                        <span class="px-3 py-1 bg-blue-100 text-blue-800 text-sm rounded-full">
                                            {{ ucwords(str_replace('_', ' ', $attackType)) }}
                                        </span>
                                    @endforeach
                                @endif
                            </div>
                        </div>

                        {{-- Target e Difficoltà --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <h3 class="font-semibold text-gray-800 mb-2">👥 Target Audience</h3>
                                <p class="text-gray-600 text-sm">{{ $wizardData['target_audience'] ?? 'Non specificato' }}</p>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-800 mb-2">⚡ Difficoltà</h3>
                                <span class="px-3 py-1 text-sm rounded-full
                                    @if(($wizardData['difficulty'] ?? '') === 'beginner') bg-green-100 text-green-800
                                    @elseif(($wizardData['difficulty'] ?? '') === 'intermediate') bg-yellow-100 text-yellow-800
                                    @else bg-red-100 text-red-800 @endif">
                                    {{ ucfirst($wizardData['difficulty'] ?? 'intermediate') }}
                                </span>
                            </div>
                        </div>

                        {{-- Durata e Frequenza --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <h3 class="font-semibold text-gray-800 mb-2">📅 Durata</h3>
                                <p class="text-gray-600 text-sm">{{ $wizardData['duration_weeks'] ?? 4 }} settimane</p>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-800 mb-2">🔄 Frequenza</h3>
                                <p class="text-gray-600 text-sm">{{ ucfirst($wizardData['frequency'] ?? 'weekly') }}</p>
                            </div>
                        </div>

                        {{-- Fattori Umani --}}
                        <div>
                            <h3 class="font-semibold text-gray-800 mb-2">🧠 Fattori Umani</h3>
                            <div class="flex flex-wrap gap-2">
                                @if(isset($wizardData['human_factors']))
                                    @foreach($wizardData['human_factors'] as $factor)
                                        <span class="px-3 py-1 bg-purple-100 text-purple-800 text-sm rounded-full">
                                            {{ ucwords(str_replace('_', ' ', $factor)) }}
                                        </span>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Form Finalizzazione --}}
                <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                    <form action="{{ route('wizard.complete', $session) }}" method="POST">
                        @csrf

                        <div class="px-6 py-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">✍️ Dettagli Finali</h3>

                            <div class="mb-6">
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Nome della Campagna *
                                </label>
                                <input type="text" name="campaign_name"
                                       class="w-full border border-gray-300 rounded-lg p-3 focus:ring-blue-500 focus:border-blue-500"
                                       placeholder="Es: Training Anti-Phishing Q1 2024"
                                       value="{{ old('campaign_name') }}" required>
                                @error('campaign_name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-6">
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Descrizione della Campagna *
                                </label>
                                <textarea name="campaign_description" rows="4"
                                          class="w-full border border-gray-300 rounded-lg p-3 focus:ring-blue-500 focus:border-blue-500"
                                          placeholder="Descrivi l'obiettivo e il contesto di questa campagna di training..."
                                          required>{{ old('campaign_description') }}</textarea>
                                @error('campaign_description')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="space-y-4">
                                <label class="flex items-center">
                                    <input type="checkbox" name="auto_start" value="1"
                                           class="mr-3 h-5 w-5 text-blue-600">
                                    <span class="text-gray-700">Avvia automaticamente la campagna dopo la creazione</span>
                                </label>

                                <label class="flex items-center">
                                    <input type="checkbox" name="generate_content_now" value="1"
                                           class="mr-3 h-5 w-5 text-blue-600" checked>
                                    <span class="text-gray-700">Genera contenuti con LLM immediatamente</span>
                                </label>
                            </div>
                        </div>

                        <div class="px-6 py-4 bg-gray-50 flex justify-between">
                            <a href="{{ route('wizard.step5', $session) }}" class="px-4 py-2 text-gray-600 hover:text-gray-800">
                                ← Step Precedente
                            </a>
                            <button type="submit" class="px-8 py-3 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 transition-colors">
                                🚀 Crea Campagna
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Sidebar con Statistiche --}}
            <div class="lg:col-span-1">
                <div class="bg-white shadow-lg rounded-lg overflow-hidden sticky top-8">
                    <div class="px-6 py-4 bg-gradient-to-r from-green-600 to-green-700">
                        <h3 class="text-lg font-semibold text-white">📊 Stima Campagna</h3>
                    </div>

                    <div class="px-6 py-6 space-y-4">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Tipi di Attacco:</span>
                            <span class="font-semibold">{{ $summary['attack_types_count'] ?? 0 }}</span>
                        </div>

                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Durata:</span>
                            <span class="font-semibold">{{ $summary['estimated_duration'] ?? 0 }} settimane</span>
                        </div>

                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Fattori Umani:</span>
                            <span class="font-semibold">{{ $summary['human_factors_count'] ?? 0 }}</span>
                        </div>

                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Voice AI:</span>
                            <span class="font-semibold">
                                {{ $summary['has_voice'] ? '✅ Sì' : '❌ No' }}
                            </span>
                        </div>

                        <hr class="my-4">

                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                            <h4 class="font-medium text-blue-900 mb-2">💡 Prossimi Passi</h4>
                            <ul class="text-sm text-blue-800 space-y-1">
                                <li>• Generazione contenuti LLM</li>
                                <li>• Configurazione partecipanti</li>
                                <li>• Test e validazione</li>
                                <li>• Avvio campagna</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
