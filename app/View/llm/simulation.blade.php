{{-- resources/views/llm/simulation.blade.php --}}
{{-- REALIZZATO DA: Andrea Amodeo --}}

@extends('layouts.app')

@section('title', 'Simulazione LLM - ' . $campaign->name)

@push('styles')
<style>
    .simulation-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.1);
    }

    .generation-status-pulse {
        animation: pulse 2s infinite;
    }

    .voice-player {
        background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
    }

    .content-preview {
        max-height: 100px;
        overflow: hidden;
        position: relative;
    }

    .content-preview::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 20px;
        background: linear-gradient(transparent, white);
    }
</style>
@endpush

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Header con breadcrumb --}}
        <nav class="flex mb-4" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('dashboard') }}" class="text-gray-700 hover:text-blue-600">
                        Dashboard
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <a href="{{ route('campaigns.show', $campaign) }}" class="ml-1 text-gray-700 hover:text-blue-600">
                            {{ $campaign->name }}
                        </a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="ml-1 text-gray-500">Simulazione LLM</span>
                    </div>
                </li>
            </ol>
        </nav>

        {{-- Header Principale --}}
        <div class="mb-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 flex items-center">
                        🤖 Simulazione LLM Interattiva
                        <span class="ml-3 px-3 py-1 bg-blue-100 text-blue-800 text-sm rounded-full">
                            {{ ucfirst($campaign->difficulty_level) }}
                        </span>
                    </h1>
                    <p class="mt-2 text-gray-600">
                        {{ $campaign->name }} •
                        <span class="font-medium">{{ $campaign->participants->count() }} partecipanti</span> •
                        Creata {{ $campaign->created_at->diffForHumans() }}
                    </p>
                </div>

                <div class="mt-4 md:mt-0 flex flex-wrap gap-3">
                    <button onclick="generateNewContent()"
                            class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                        Genera Contenuto
                    </button>
                    <button onclick="exportResults()"
                            class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Esporta Risultati
                    </button>
                    <a href="{{ route('campaigns.show', $campaign) }}"
                       class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Torna alla Campagna
                    </a>
                </div>
            </div>
        </div>

        {{-- Statistics Dashboard Real-time --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white p-6 rounded-lg shadow-sm border">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-100 text-green-600 mr-4">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Generazioni Completate</p>
                        <p class="text-2xl font-semibold text-gray-900" id="completed-count">
                            {{ $statistics['completed_generations'] ?? 0 }}
                        </p>
                        <p class="text-xs text-gray-500 mt-1">
                            su {{ $statistics['total_generations'] ?? 0 }} totali
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-sm border">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-purple-100 text-purple-600 mr-4">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M18 3a1 1 0 00-1.196-.98l-10 2A1 1 0 006 5v9.114A4.369 4.369 0 005 14c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V7.82l8-1.6v5.894A4.37 4.37 0 0015 12c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V3z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Con Voice AI</p>
                        <p class="text-2xl font-semibold text-gray-900" id="voice-count">
                            {{ $statistics['voice_generations'] ?? 0 }}
                        </p>
                        <p class="text-xs text-gray-500 mt-1">
                            sintesi vocale attiva
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-sm border">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-yellow-100 text-yellow-600 mr-4">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Token Utilizzati</p>
                        <p class="text-2xl font-semibold text-gray-900" id="tokens-count">
                            {{ number_format($statistics['total_tokens_used'] ?? 0) }}
                        </p>
                        <p class="text-xs text-gray-500 mt-1">
                            tempo medio: {{ number_format($statistics['average_generation_time'] ?? 0 / 1000, 1) }}s
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-sm border">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-blue-100 text-blue-600 mr-4">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Costo Stimato</p>
                        <p class="text-2xl font-semibold text-gray-900" id="cost-estimate">
                            ${{ number_format($statistics['estimated_cost'] ?? 0, 3) }}
                        </p>
                        <p class="text-xs text-gray-500 mt-1">
                            questo mese
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Panel di Controllo Avanzato --}}
        <div class="bg-white rounded-lg shadow-sm border mb-8">
            <div class="px-6 py-4 border-b">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                    <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                        🎛️ Centro di Controllo LLM
                        <span class="ml-2 px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full" id="api-status">
                            API Attiva
                        </span>
                    </h2>
                    <div class="mt-4 md:mt-0 flex flex-wrap gap-2">
                        <button onclick="filterByType('all')"
                                class="filter-btn active px-3 py-1 text-sm rounded-full bg-blue-600 text-white">
                            Tutti ({{ $generations->count() }})
                        </button>
                        @foreach($contentTypes as $type => $info)
                            @php $count = $generations->where('content_type', $type)->count() @endphp
                            @if($count > 0)
                                <button onclick="filterByType('{{ $type }}')"
                                        class="filter-btn px-3 py-1 text-sm rounded-full border border-gray-300 hover:bg-gray-50 transition-colors"
                                        data-type="{{ $type }}">
                                    {{ $info['name'] }} ({{ $count }})
                                </button>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="px-6 py-4">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tipo Contenuto</label>
                        <select id="content-type-select" class="w-full border border-gray-300 rounded-lg p-2 focus:ring-blue-500 focus:border-blue-500">
                            @foreach($contentTypes as $type => $info)
                                <option value="{{ $type }}" data-supports-voice="{{ $info['supports_voice'] ? 'true' : 'false' }}">
                                    {{ $info['name'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Modello LLM</label>
                        <select id="model-select" class="w-full border border-gray-300 rounded-lg p-2">
                            <option value="gpt-4-turbo-preview">GPT-4 Turbo (Raccomandato)</option>
                            <option value="gpt-3.5-turbo">GPT-3.5 Turbo (Veloce)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Opzioni Avanzate</label>
                        <div class="space-y-2">
                            <label class="flex items-center">
                                <input type="checkbox" id="generate-voice" class="mr-2 rounded">
                                <span class="text-sm">Genera Voce AI</span>
                                <span class="ml-1 text-purple-600" title="Disponibile per Vishing e Social Engineering">🎵</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" id="high-quality" class="mr-2 rounded" checked>
                                <span class="text-sm">Alta Qualità</span>
                            </label>
                        </div>
                    </div>

                    <div class="flex flex-col justify-end">
                        <button onclick="generateContent()"
                                class="w-full px-4 py-2 bg-gradient-to-r from-green-600 to-green-700 text-white rounded-lg hover:from-green-700 hover:to-green-800 transition-all duration-200 shadow-sm">
                            <span class="flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                                Genera Ora
                            </span>
                        </button>
                        <p class="text-xs text-gray-500 mt-1 text-center">
                            Tempo stimato: <span id="estimated-time">30-60s</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Grid Generazioni LLM --}}
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6" id="generations-grid">
            @forelse($generations as $generation)
                <div class="simulation-card bg-white rounded-lg shadow-sm border hover:shadow-md transition-all duration-200 cursor-pointer"
                     data-type="{{ $generation->content_type }}"
                     onclick="openSimulation({{ $generation->id }})">

                    <div class="p-6">
                        {{-- Header Card con Status --}}
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center">
                                <span class="text-3xl mr-3">
                                    @if($generation->content_type === 'email_phishing') 📧
                                    @elseif($generation->content_type === 'vishing') 📞
                                    @elseif($generation->content_type === 'social_engineering') 👥
                                    @elseif($generation->content_type === 'ceo_fraud') 👔
                                    @elseif($generation->content_type === 'smishing') 📱
                                    @elseif($generation->content_type === 'quiz_questions') 📝
                                    @else 🤖 @endif
                                </span>
                                <div>
                                    <h3 class="font-semibold text-gray-900">
                                        {{ $contentTypes[$generation->content_type]['name'] ?? 'Sconosciuto' }}
                                    </h3>
                                    <p class="text-sm text-gray-500">
                                        ID: #{{ $generation->id }} •
                                        {{ $generation->created_at->format('d/m H:i') }}
                                    </p>
                                </div>
                            </div>

                            <div class="flex flex-col items-end space-y-2">
                                @if($generation->hasVoice())
                                    <span class="text-purple-600 text-lg" title="Audio AI disponibile">🔊</span>
                                @endif
                                {!! $generation->getStatusBadge() !!}
                            </div>
                        </div>

                        {{-- Preview Contenuto --}}
                        <div class="mb-4">
                            @php $content = $generation->getFormattedContent() @endphp

                            @if($generation->content_type === 'email_phishing')
                                <div class="bg-gradient-to-r from-red-50 to-orange-50 rounded-lg p-4 border-l-4 border-red-400">
                                    <p class="text-sm font-medium text-red-700 mb-1">📧 Oggetto Email:</p>
                                    <p class="text-sm text-gray-900 font-medium">
                                        {{ Str::limit($content['subject'] ?? 'Oggetto non disponibile', 50) }}
                                    </p>
                                    @if(isset($content['from']))
                                        <p class="text-xs text-gray-600 mt-2">
                                            Da: {{ $content['from'] }}
                                        </p>
                                    @endif
                                </div>

                            @elseif($generation->content_type === 'vishing')
                                <div class="bg-gradient-to-r from-purple-50 to-blue-50 rounded-lg p-4 border-l-4 border-purple-400">
                                    <p class="text-sm font-medium text-purple-700 mb-1">📞 Script Chiamata:</p>
                                    @if(isset($content['caller_identity']))
                                        <p class="text-sm text-gray-900 font-medium">{{ $content['caller_identity'] }}</p>
                                    @endif
                                    @if(isset($content['script_phases']) && is_array($content['script_phases']))
                                        <p class="text-sm text-gray-600 mt-1">
                                            {{ Str::limit($content['script_phases'][0] ?? '', 60) }}
                                        </p>
                                    @endif
                                </div>

                            @elseif($generation->content_type === 'quiz_questions')
                                <div class="bg-gradient-to-r from-green-50 to-blue-50 rounded-lg p-4 border-l-4 border-green-400">
                                    <p class="text-sm font-medium text-green-700 mb-1">📝 Quiz Generato:</p>
                                    @if(isset($content['questions']) && is_array($content['questions']))
                                        <p class="text-sm text-gray-900 font-medium">
                                            {{ count($content['questions']) }} domande create
                                        </p>
                                        <p class="text-xs text-gray-600 mt-1">
                                            Difficoltà: {{ ucfirst($generation->campaign->difficulty_level) }}
                                        </p>
                                    @else
                                        <p class="text-sm text-gray-600">
                                            {{ Str::limit($content['raw_content'] ?? 'Contenuto quiz', 60) }}
                                        </p>
                                    @endif
                                </div>

                            @else
                                <div class="bg-gray-50 rounded-lg p-4 border-l-4 border-gray-400">
                                    <p class="text-sm font-medium text-gray-700 mb-1">
                                        {{ ucwords(str_replace('_', ' ', $generation->content_type)) }}:
                                    </p>
                                    <div class="content-preview">
                                        <p class="text-sm text-gray-600">
                                            {{ Str::limit($content['raw_content'] ?? $content['content'] ?? 'Contenuto generato', 100) }}
                                        </p>
                                    </div>
                                </div>
                            @endif
                        </div>

                        {{-- Metriche e Qualità --}}
                        <div class="grid grid-cols-2 gap-4 text-sm mb-4">
                            <div class="bg-gray-50 rounded p-2">
                                <span class="text-gray-500">Token:</span>
                                <span class="font-medium text-blue-600">{{ number_format($generation->tokens_consumed ?? 0) }}</span>
                            </div>
                            <div class="bg-gray-50 rounded p-2">
                                <span class="text-gray-500">Qualità:</span>
                                <span class="font-medium text-green-600">{{ number_format($generation->quality_score ?? 0, 1) }}%</span>
                            </div>
                            @if($generation->generation_time_ms)
                                <div class="bg-gray-50 rounded p-2">
                                    <span class="text-gray-500">Tempo:</span>
                                    <span class="font-medium">{{ number_format($generation->generation_time_ms / 1000, 1) }}s</span>
                                </div>
                            @endif
                            @if($generation->hasVoice())
                                <div class="bg-purple-50 rounded p-2">
                                    <span class="text-purple-600">🎵 Durata:</span>
                                    <span class="font-medium text-purple-700">{{ $generation->getFormattedVoiceDuration() }}</span>
                                </div>
                            @endif
                        </div>

                        {{-- Red Flags Preview (se disponibili) --}}
                        @if(isset($content['red_flags']) && is_array($content['red_flags']))
                            <div class="mb-4">
                                <p class="text-xs font-medium text-red-600 mb-2">🚩 Indicatori di Pericolo:</p>
                                <div class="flex flex-wrap gap-1">
                                    @foreach(array_slice($content['red_flags'], 0, 3) as $flag)
                                        <span class="px-2 py-1 bg-red-100 text-red-700 text-xs rounded-full">
                                            {{ $flag }}
                                        </span>
                                    @endforeach
                                    @if(count($content['red_flags']) > 3)
                                        <span class="px-2 py-1 bg-gray-100 text-gray-600 text-xs rounded-full">
                                            +{{ count($content['red_flags']) - 3 }} altri
                                        </span>
                                    @endif
                                </div>
                            </div>
                        @endif

                        {{-- Action Buttons --}}
                        <div class="flex justify-between items-center pt-4 border-t">
                            <div class="flex space-x-2">
                                @if($generation->hasVoice())
                                    <button onclick="event.stopPropagation(); playAudio('{{ $generation->voice_url }}')"
                                            class="p-2 text-purple-600 hover:bg-purple-50 rounded-lg transition-colors"
                                            title="Riproduci Audio">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                @endif

                                <button onclick="event.stopPropagation(); downloadContent({{ $generation->id }})"
                                        class="p-2 text-gray-600 hover:bg-gray-50 rounded-lg transition-colors"
                                        title="Download">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </button>

                                @if($generation->canRegenerate())
                                    <button onclick="event.stopPropagation(); regenerateContent({{ $generation->id }})"
                                            class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors"
                                            title="Rigenera">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                        </svg>
                                    </button>
                                @endif
                            </div>

                            <button onclick="openSimulation({{ $generation->id }})"
                                    class="px-4 py-2 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700 transition-colors">
                                🚀 Simula
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full">
                    <div class="text-center py-16">
                        <div class="text-6xl mb-4">🤖</div>
                        <h3 class="text-xl font-medium text-gray-900 mb-2">Nessuna Generazione Trovata</h3>
                        <p class="text-gray-500 mb-6 max-w-md mx-auto">
                            Inizia generando il primo contenuto per questa campagna usando il pannello di controllo sopra.
                        </p>
                        <button onclick="generateContent()"
                                class="px-8 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-lg hover:from-blue-700 hover:to-blue-800 transition-all duration-200 shadow-lg">
                            <span class="flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                                Genera Primo Contenuto
                            </span>
                        </button>
                    </div>
                </div>
            @endforelse
        </div>

        {{-- Loading Overlay --}}
        <div id="loading-overlay" class="fixed inset-0 bg-black bg-opacity-50 hidden z-40">
            <div class="flex items-center justify-center min-h-screen">
                <div class="bg-white rounded-lg p-8 max-w-sm w-full mx-4">
                    <div class="text-center">
                        <div class="inline-block animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600 mb-4"></div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Generazione in Corso</h3>
                        <p class="text-gray-600" id="loading-message">Preparazione del contenuto LLM...</p>
                        <div class="mt-4 w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-blue-600 h-2 rounded-full transition-all duration-300" style="width: 0%" id="progress-bar"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modal Simulazione Dettagliata --}}
<div id="simulation-modal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg max-w-5xl w-full max-h-screen overflow-y-auto">
            <div class="p-6 border-b flex items-center justify-between bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-t-lg">
                <h3 class="text-xl font-semibold" id="modal-title">🎯 Simulazione Interattiva</h3>
                <button onclick="closeSimulation()" class="text-white hover:text-gray-200 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="p-6" id="modal-content">
                {{-- Contenuto dinamico della simulazione --}}
                <div class="text-center py-8">
                    <div class="animate-pulse">
                        <div class="text-4xl mb-4">⚡</div>
                        <p class="text-gray-600">Caricamento simulazione...</p>
                    </div>
                </div>
            </div>

            <div class="p-6 border-t bg-gray-50 flex justify-between items-center rounded-b-lg">
                <div class="flex items-center space-x-4">
                    <div class="text-sm text-gray-600">
                        ⏱️ Tempo: <span id="simulation-timer" class="font-mono font-bold">00:00</span>
                    </div>
                    <div class="text-sm text-gray-600">
                        📊 Score: <span id="current-score" class="font-bold text-blue-600">0</span>
                    </div>
                </div>
                <div class="space-x-3">
                    <button onclick="submitSimulation()"
                            class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                        ✅ Completa Simulazione
                    </button>
                    <button onclick="pauseSimulation()"
                            class="px-6 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 transition-colors">
                        ⏸️ Pausa
                    </button>
                    <button onclick="closeSimulation()"
                            class="px-6 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                        Chiudi
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Audio Player Modal Avanzato --}}
<div id="audio-modal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="voice-player rounded-lg p-8 max-w-md w-full text-white shadow-2xl">
            <h3 class="text-xl font-semibold mb-6 text-center flex items-center justify-center">
                <span class="text-2xl mr-2">🎵</span>
                Player Audio AI
            </h3>

            <div class="mb-6">
                <audio id="audio-player" controls class="w-full mb-4 rounded-lg">
                    <source src="" type="audio/mpeg">
                    Il tuo browser non supporta l'elemento audio.
                </audio>

                <div class="flex items-center justify-between text-sm">
                    <span id="audio-duration">0:00</span>
                    <span class="text-purple-200">Voice AI • ElevenLabs</span>
                    <span id="audio-current">0:00</span>
                </div>
            </div>

            <div class="flex justify-center space-x-3">
                <button onclick="closeAudioModal()"
                        class="px-6 py-2 bg-white bg-opacity-20 rounded-lg hover:bg-opacity-30 transition-all">
                    Chiudi
                </button>
                <button onclick="downloadAudio()"
                        class="px-6 py-2 bg-white bg-opacity-20 rounded-lg hover:bg-opacity-30 transition-all">
                    💾 Download
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Variabili globali per gestione simulazione
let currentSimulation = null;
let simulationStartTime = null;
let timerInterval = null;
let currentScore = 0;
let generationPolling = new Map();

// Meta CSRF token
const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

// Inizializzazione pagina
document.addEventListener('DOMContentLoaded', function() {
    console.log('🤖 Simulazione LLM inizializzata');

    // Update contenuto type options basato su voice support
    updateVoiceOptions();

    // Setup event listeners
    document.getElementById('content-type-select').addEventListener('change', updateVoiceOptions);
});

// Aggiorna opzioni voice basato su tipo contenuto
function updateVoiceOptions() {
    const select = document.getElementById('content-type-select');
    const voiceCheckbox = document.getElementById('generate-voice');
    const selectedOption = select.options[select.selectedIndex];
    const supportsVoice = selectedOption.dataset.supportsVoice === 'true';

    voiceCheckbox.disabled = !supportsVoice;
    if (!supportsVoice) {
        voiceCheckbox.checked = false;
    }

    // Update estimated time
    const estimatedTime = {
        'email_phishing': '20-40s',
        'smishing': '15-30s',
        'vishing': '45-90s',
        'social_engineering': '60-120s',
        'ceo_fraud': '30-60s',
        'quiz_questions': '40-80s'
    };

    document.getElementById('estimated-time').textContent = estimatedTime[select.value] || '30-60s';
}

// Filtra generazioni per tipo
function filterByType(type) {
    const cards = document.querySelectorAll('.simulation-card');
    const buttons = document.querySelectorAll('.filter-btn');

    // Update button states
    buttons.forEach(btn => {
        btn.classList.remove('active', 'bg-blue-600', 'text-white');
        btn.classList.add('border-gray-300', 'hover:bg-gray-50');
    });

    if (type === 'all') {
        event.target.classList.add('active', 'bg-blue-600', 'text-white');
        cards.forEach(card => {
            card.style.display = 'block';
            card.classList.add('animate-fadeIn');
        });
    } else {
        const targetBtn = document.querySelector(`[data-type="${type}"]`);
        if (targetBtn) {
            targetBtn.classList.add('active', 'bg-blue-600', 'text-white');
            targetBtn.classList.remove('border-gray-300', 'hover:bg-gray-50');
        }

        cards.forEach(card => {
            if (card.dataset.type === type) {
                card.style.display = 'block';
                card.classList.add('animate-fadeIn');
            } else {
                card.style.display = 'none';
            }
        });
    }
}

// Genera nuovo contenuto LLM
async function generateContent() {
    const contentType = document.getElementById('content-type-select').value;
    const generateVoice = document.getElementById('generate-voice').checked;
    const model = document.getElementById('model-select').value;
    const highQuality = document.getElementById('high-quality').checked;

    showLoadingOverlay('Inizializzazione generazione LLM...');

    try {
        const response = await fetch('/api/llm/generate-content', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({
                campaign_id: {{ $campaign->id }},
                content_type: contentType,
                generate_voice: generateVoice,
                parameters: {
                    model: model,
                    high_quality: highQuality,
                    difficulty: '{{ $campaign->difficulty_level }}',
                    target_audience: '{{ $campaign->target_audience }}',
                    human_factors: @json($campaign->human_factors ?? [])
                }
            })
        });

        const data = await response.json();

        if (data.success) {
            showNotification('✅ Generazione avviata con successo!', 'success');
            startGenerationPolling(data.generation_id);
        } else {
            hideLoadingOverlay();
            showNotification('❌ Errore: ' + (data.error || 'Errore sconosciuto'), 'error');
        }
    } catch (error) {
        hideLoadingOverlay();
        console.error('Generation error:', error);
        showNotification('❌ Errore di connessione durante la generazione', 'error');
    }
}

// Polling status generazione con progress
function startGenerationPolling(generationId) {
    let progress = 0;
    const progressBar = document.getElementById('progress-bar');
    const loadingMessage = document.getElementById('loading-message');

    const pollInterval = setInterval(async () => {
        try {
            const response = await fetch(`/api/llm/status/${generationId}`, {
                headers: { 'X-CSRF-TOKEN': csrfToken }
            });
            const data = await response.json();

            if (data.success) {
                progress = data.generation.progress || 0;
                progressBar.style.width = progress + '%';

                if (data.generation.status === 'completed') {
                    clearInterval(pollInterval);
                    hideLoadingOverlay();
                    showNotification('🎉 Generazione completata! Ricaricando la pagina...', 'success');
                    setTimeout(() => window.location.reload(), 2000);

                } else if (data.generation.status === 'failed') {
                    clearInterval(pollInterval);
                    hideLoadingOverlay();
                    showNotification('❌ Generazione fallita: ' + data.generation.error_message, 'error');

                } else if (data.generation.status === 'generating') {
                    loadingMessage.textContent = 'Generazione contenuto con LLM...';
                }
            }
        } catch (error) {
            console.error('Polling error:', error);
            clearInterval(pollInterval);
            hideLoadingOverlay();
            showNotification('❌ Errore durante il controllo dello stato', 'error');
        }
    }, 3000); // Poll ogni 3 secondi

    // Stop polling dopo 5 minuti
    setTimeout(() => {
        clearInterval(pollInterval);
        if (document.getElementById('loading-overlay').style.display !== 'none') {
            hideLoadingOverlay();
            showNotification('⏰ Timeout generazione. Controlla manualmente lo stato.', 'warning');
        }
    }, 300000);
}

// Mostra/Nascondi loading overlay
function showLoadingOverlay(message = 'Caricamento...') {
    document.getElementById('loading-message').textContent = message;
    document.getElementById('progress-bar').style.width = '0%';
    document.getElementById('loading-overlay').classList.remove('hidden');
}

function hideLoadingOverlay() {
    document.getElementById('loading-overlay').classList.add('hidden');
}

// Apri simulazione interattiva
async function openSimulation(generationId) {
    showLoadingOverlay('Caricamento simulazione...');

    try {
        const response = await fetch(`/api/llm/simulation/{{ $campaign->id }}`, {
            headers: { 'X-CSRF-TOKEN': csrfToken }
        });
        const data = await response.json();

        if (data.success) {
            const simulation = data.simulations.find(s => s.id === generationId);
            if (simulation) {
                hideLoadingOverlay();
                displaySimulation(simulation);
                document.getElementById('simulation-modal').classList.remove('hidden');
                startSimulationTimer();
            }
        }
    } catch (error) {
        hideLoadingOverlay();
        console.error('Simulation load error:', error);
        showNotification('❌ Errore caricamento simulazione', 'error');
    }
}

// Visualizza contenuto simulazione nel modal
function displaySimulation(simulation) {
    const content = document.getElementById('modal-content');
    const title = document.getElementById('modal-title');

    title.textContent = `🎯 Simulazione ${simulation.type.charAt(0).toUpperCase() + simulation.type.slice(1)}`;

    let htmlContent = '';

    switch (simulation.type) {
        case 'email_phishing':
            htmlContent = generateEmailSimulationHTML(simulation);
            break;
        case 'vishing':
            htmlContent = generateVishingSimulationHTML(simulation);
            break;
        case 'social_engineering':
            htmlContent = generateSocialEngineeringHTML(simulation);
            break;
        case 'quiz_questions':
            htmlContent = generateQuizSimulationHTML(simulation);
            break;
        default:
            htmlContent = generateGenericSimulationHTML(simulation);
    }

    content.innerHTML = htmlContent;
    currentSimulation = simulation;
}

// HTML simulazione email phishing
function generateEmailSimulationHTML(simulation) {
    const content = simulation.content;
    return `
        <div class="email-simulation space-y-6">
            <div class="bg-gradient-to-r from-red-50 to-orange-50 p-6 rounded-lg border-l-4 border-red-400">
                <h4 class="font-semibold mb-4 text-red-800 flex items-center">
                    📧 Email Sospetta Ricevuta
                    <span class="ml-2 px-2 py-1 bg-red-200 text-red-800 text-xs rounded-full">PHISHING</span>
                </h4>

                <div class="bg-white p-4 rounded border shadow-sm">
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-sm font-medium text-gray-600">Da:</span>
                            <span class="text-sm text-gray-900">${content.from || 'sender@suspicious-domain.com'}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm font-medium text-gray-600">Oggetto:</span>
                            <span class="text-sm font-medium text-gray-900">${content.subject || 'Azione Urgente Richiesta'}</span>
                        </div>
                        <hr>
                        <div>
                            <span class="text-sm font-medium text-gray-600">Contenuto:</span>
                            <div class="mt-2 p-4 bg-gray-50 rounded border">
                                ${content.body || 'Contenuto email di phishing generato dall\'IA...'}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-blue-50 p-6 rounded-lg border-l-4 border-blue-400">
                <h4 class="font-semibold mb-4 text-blue-800 flex items-center">
                    🎯 Come Reagiresti?
                    <span class="ml-2 text-sm text-blue-600">(Seleziona la risposta più appropriata)</span>
                </h4>

                <div class="space-y-3">
                    <label class="flex items-start p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-blue-300 hover:bg-blue-50 transition-all">
                        <input type="radio" name="email_action" value="click" class="mt-1 mr-3 text-blue-600">
                        <div>
                            <span class="font-medium text-red-600">❌ Cliccare sul link o scaricare l'allegato</span>
                            <p class="text-sm text-gray-600 mt-1">Azione pericolosa - cadere nella trappola</p>
                        </div>
                    </label>

                    <label class="flex items-start p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-blue-300 hover:bg-blue-50 transition-all">
                        <input type="radio" name="email_action" value="ignore" class="mt-1 mr-3 text-blue-600">
                        <div>
                            <span class="font-medium text-yellow-600">⚠️ Ignorare completamente l'email</span>
                            <p class="text-sm text-gray-600 mt-1">Sicuro ma non proattivo</p>
                        </div>
                    </label>

                    <label class="flex items-start p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-blue-300 hover:bg-blue-50 transition-all">
                        <input type="radio" name="email_action" value="verify" class="mt-1 mr-3 text-blue-600">
                        <div>
                            <span class="font-medium text-green-600">✅ Verificare la legittimità prima di agire</span>
                            <p class="text-sm text-gray-600 mt-1">Buona pratica di sicurezza</p>
                        </div>
                    </label>

                    <label class="flex items-start p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-blue-300 hover:bg-blue-50 transition-all">
                        <input type="radio" name="email_action" value="report" class="mt-1 mr-3 text-blue-600">
                        <div>
                            <span class="font-medium text-green-700">🏆 Segnalare come sospetta al team IT</span>
                            <p class="text-sm text-gray-600 mt-1">Risposta ottimale - proteggere l'organizzazione</p>
                        </div>
                    </label>
                </div>
            </div>

            ${content.red_flags ? `
            <div class="bg-yellow-50 p-6 rounded-lg border-l-4 border-yellow-400">
                <h4 class="font-semibold mb-3 text-yellow-800">🚩 Riesci a Identificare gli Indicatori Sospetti?</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    ${content.red_flags.map(flag => `
                        <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-yellow-100">
                            <input type="checkbox" name="identified_red_flags[]" value="${flag}" class="mr-3 text-yellow-600">
                            <span class="text-sm">${flag}</span>
                        </label>
                    `).join('')}
                </div>
            </div>
            ` : ''}
        </div>
    `;
}

// Timer simulazione
function startSimulationTimer() {
    simulationStartTime = Date.now();
    currentScore = 0;
    updateScore(0);

    timerInterval = setInterval(() => {
        const elapsed = Math.floor((Date.now() - simulationStartTime) / 1000);
        const minutes = Math.floor(elapsed / 60);
        const seconds = elapsed % 60;

        document.getElementById('simulation-timer').textContent =
            `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
    }, 1000);
}

// Aggiorna score simulazione
function updateScore(points) {
    currentScore += points;
    document.getElementById('current-score').textContent = currentScore;
}

// Chiudi simulazione
function closeSimulation() {
    document.getElementById('simulation-modal').classList.add('hidden');
    if (timerInterval) {
        clearInterval(timerInterval);
        timerInterval = null;
    }
    currentSimulation = null;
    simulationStartTime = null;
}

// Pausa simulazione
function pauseSimulation() {
    if (timerInterval) {
        clearInterval(timerInterval);
        timerInterval = null;
        showNotification('⏸️ Simulazione in pausa', 'info');
    } else {
        startSimulationTimer();
        showNotification('▶️ Simulazione ripresa', 'info');
    }
}

// Sottometti simulazione completata
async function submitSimulation() {
    if (!currentSimulation) return;

    const elapsed = Math.floor((Date.now() - simulationStartTime) / 1000);
    const responses = {};

    // Raccoglie tutte le risposte dell'utente
    document.querySelectorAll('#modal-content input:checked').forEach(input => {
        if (input.type === 'radio') {
            responses[input.name] = input.value;
        } else if (input.type === 'checkbox') {
            if (!responses[input.name]) responses[input.name] = [];
            responses[input.name].push(input.value);
        }
    });

    try {
        const response = await fetch(`/api/llm/simulation/${currentSimulation.id}/execute`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({
                user_responses: responses,
                execution_time: elapsed,
                final_score: currentScore
            })
        });

        const data = await response.json();

        if (data.success) {
            showSimulationResults(data.result);
            updateDashboardStats(data.result);
        } else {
            showNotification('❌ Errore durante la valutazione', 'error');
        }
    } catch (error) {
        console.error('Simulation submission error:', error);
        showNotification('❌ Errore di connessione', 'error');
    }
}

// Mostra risultati simulazione
function showSimulationResults(result) {
    const content = document.getElementById('modal-content');
    content.innerHTML = `
        <div class="text-center py-8">
            <div class="text-6xl mb-4">${result.is_vulnerable ? '❌' : '✅'}</div>
            <h3 class="text-2xl font-bold mb-2 ${result.is_vulnerable ? 'text-red-600' : 'text-green-600'}">
                ${result.is_vulnerable ? 'Vulnerabilità Rilevata!' : 'Eccellente Performance!'}
            </h3>
            <p class="text-lg text-gray-600 mb-6">${result.performance_summary}</p>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <div class="bg-blue-50 p-4 rounded-lg">
                    <div class="text-2xl font-bold text-blue-600">${result.final_score}</div>
                    <div class="text-sm text-blue-700">Score Finale</div>
                </div>
                <div class="bg-yellow-50 p-4 rounded-lg">
                    <div class="text-2xl font-bold text-yellow-600">${Math.floor(result.execution_time / 60)}:${(result.execution_time % 60).toString().padStart(2, '0')}</div>
                    <div class="text-sm text-yellow-700">Tempo Impiegato</div>
                </div>
                <div class="bg-purple-50 p-4 rounded-lg">
                    <div class="text-2xl font-bold text-purple-600">${result.risk_level}</div>
                    <div class="text-sm text-purple-700">Livello Rischio</div>
                </div>
            </div>

            ${result.feedback.length > 0 ? `
            <div class="bg-gray-50 p-6 rounded-lg text-left mb-6">
                <h4 class="font-semibold mb-3">📋 Feedback Dettagliato:</h4>
                <ul class="space-y-2">
                    ${result.feedback.map(item => `<li class="text-sm">• ${item}</li>`).join('')}
                </ul>
            </div>
            ` : ''}

            ${result.recommendations.length > 0 ? `
            <div class="bg-blue-50 p-6 rounded-lg text-left">
                <h4 class="font-semibold text-blue-800 mb-3">💡 Raccomandazioni:</h4>
                <ul class="space-y-2">
                    ${result.recommendations.map(item => `<li class="text-sm text-blue-700">• ${item}</li>`).join('')}
                </ul>
            </div>
            ` : ''}
        </div>
    `;

    // Nasconde i bottoni di azione e mostra solo chiudi
    const actionButtons = document.querySelector('#simulation-modal .border-t .space-x-3');
    actionButtons.innerHTML = `
        <button onclick="closeSimulation()" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
            Chiudi e Continua
        </button>
    `;
}

// Player audio
function playAudio(audioUrl) {
    const audioPlayer = document.getElementById('audio-player');
    audioPlayer.src = audioUrl;
    document.getElementById('audio-modal').classList.remove('hidden');

    audioPlayer.addEventListener('loadedmetadata', function() {
        const duration = Math.floor(audioPlayer.duration);
        const minutes = Math.floor(duration / 60);
        const seconds = duration % 60;
        document.getElementById('audio-duration').textContent = `${minutes}:${seconds.toString().padStart(2, '0')}`;
    });

    audioPlayer.addEventListener('timeupdate', function() {
        const current = Math.floor(audioPlayer.currentTime);
        const minutes = Math.floor(current / 60);
        const seconds = current % 60;
        document.getElementById('audio-current').textContent = `${minutes}:${seconds.toString().padStart(2, '0')}`;
    });
}

function closeAudioModal() {
    document.getElementById('audio-modal').classList.add('hidden');
    const audioPlayer = document.getElementById('audio-player');
    audioPlayer.pause();
}

function downloadAudio() {
    const audioPlayer = document.getElementById('audio-player');
    const link = document.createElement('a');
    link.href = audioPlayer.src;
    link.download = `voice_generation_${Date.now()}.mp3`;
    link.click();
}

// Funzioni utility
function regenerateContent(generationId) {
    if (confirm('Sei sicuro di voler rigenerare questo contenuto? Il contenuto attuale sarà sostituito.')) {
        showNotification('🔄 Rigenerazione avviata...', 'info');
        // TODO: Implementare rigenerazione
    }
}

function downloadContent(generationId) {
    showNotification('💾 Preparazione download...', 'info');
    // TODO: Implementare download
}

function exportResults() {
    showNotification('📊 Preparazione export...', 'info');
    // TODO: Implementare export completo
}

// Sistema notifiche
function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 px-6 py-3 rounded-lg text-white z-50 shadow-lg transform transition-all duration-300 ${
        type === 'success' ? 'bg-green-600' :
        type === 'error' ? 'bg-red-600' :
        type === 'warning' ? 'bg-yellow-600' : 'bg-blue-600'
    }`;
    notification.textContent = message;

    // Animazione entrata
    notification.style.transform = 'translateX(100%)';
    document.body.appendChild(notification);

    setTimeout(() => {
        notification.style.transform = 'translateX(0)';
    }, 100);

    // Auto remove
    setTimeout(() => {
        notification.style.transform = 'translateX(100%)';
        setTimeout(() => notification.remove(), 300);
    }, 5000);
}

// Update statistiche dashboard
function updateDashboardStats(result) {
    // Incrementa contatori
    const completedElement = document.getElementById('completed-count');
    const currentCompleted = parseInt(completedElement.textContent);
    completedElement.textContent = currentCompleted + 1;

    // Aggiorna altre metriche se necessario
    // Implementazione per aggiornamento real-time delle statistiche
}
</script>

<style>
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

.animate-fadeIn {
    animation: fadeIn 0.3s ease-out;
}

.simulation-card {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.simulation-card:hover {
    transform: translateY(-4px) scale(1.02);
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
}

.voice-player {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    backdrop-filter: blur(10px);
}

#loading-overlay {
    backdrop-filter: blur(4px);
}
</style>
@endpush
