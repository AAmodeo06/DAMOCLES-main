{{-- resources/views/wizard/step5.blade.php --}}
{{-- REALIZZATO DA: Andrea Amodeo --}}

@extends('layouts.app')

@section('title', 'Wizard Campagna - Step 5')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-8">
            <div class="text-center">
                <h1 class="text-3xl font-bold text-gray-900">Notifiche e Monitoraggio</h1>
                <p class="mt-2 text-gray-600">Step 5 di 6: Configura le notifiche e il sistema di monitoraggio</p>
            </div>

            <div class="mt-6 w-full bg-gray-200 rounded-full h-3">
                <div class="bg-blue-600 h-3 rounded-full transition-all duration-300"
                     style="width: {{ $progress }}%"></div>
            </div>
        </div>

        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
            <form action="{{ route('wizard.process.step5', $session) }}" method="POST">
                @csrf

                <div class="px-8 py-6">
                    <div class="mb-8">
                        <h2 class="text-xl font-semibold text-gray-800 mb-4">
                            📬 Canali di Notifica
                        </h2>
                        <p class="text-gray-600 mb-6">
                            Seleziona come vuoi essere notificato degli eventi della campagna e dei risultati delle simulazioni.
                        </p>

                        <div class="space-y-4 mb-8">
                            <label class="flex items-center p-4 border rounded-lg cursor-pointer hover:bg-gray-50">
                                <input type="checkbox" name="email_notifications" value="1"
                                       class="mr-4 h-5 w-5 text-blue-600" checked>
                                <div class="flex-1">
                                    <div class="flex items-center">
                                        <span class="text-2xl mr-3">📧</span>
                                        <div>
                                            <h3 class="font-medium text-gray-900">Notifiche Email</h3>
                                            <p class="text-sm text-gray-600">Ricevi aggiornamenti via email (raccomandato)</p>
                                        </div>
                                    </div>
                                </div>
                            </label>

                            <label class="flex items-center p-4 border rounded-lg cursor-pointer hover:bg-gray-50">
                                <input type="checkbox" name="sms_notifications" value="1"
                                       class="mr-4 h-5 w-5 text-blue-600">
                                <div class="flex-1">
                                    <div class="flex items-center">
                                        <span class="text-2xl mr-3">📱</span>
                                        <div>
                                            <h3 class="font-medium text-gray-900">Notifiche SMS</h3>
                                            <p class="text-sm text-gray-600">Notifiche immediate per eventi critici</p>
                                        </div>
                                    </div>
                                </div>
                            </label>

                            <label class="flex items-center p-4 border rounded-lg cursor-pointer hover:bg-gray-50">
                                <input type="checkbox" name="push_notifications" value="1"
                                       class="mr-4 h-5 w-5 text-blue-600" checked>
                                <div class="flex-1">
                                    <div class="flex items-center">
                                        <span class="text-2xl mr-3">🔔</span>
                                        <div>
                                            <h3 class="font-medium text-gray-900">Notifiche Push</h3>
                                            <p class="text-sm text-gray-600">Notifiche in tempo reale nel browser</p>
                                        </div>
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>

                    <div class="mb-8">
                        <label class="block text-sm font-medium text-gray-700 mb-3">
                            Frequenza delle Notifiche
                        </label>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <label class="flex items-center p-4 border rounded-lg cursor-pointer hover:bg-gray-50">
                                <input type="radio" name="notification_frequency" value="immediate"
                                       class="mr-3 text-blue-600" {{ old('notification_frequency') === 'immediate' ? 'checked' : '' }}>
                                <div>
                                    <div class="font-medium">Immediata</div>
                                    <div class="text-sm text-gray-600">Notifica ogni evento</div>
                                </div>
                            </label>

                            <label class="flex items-center p-4 border rounded-lg cursor-pointer hover:bg-gray-50">
                                <input type="radio" name="notification_frequency" value="daily"
                                       class="mr-3 text-blue-600" {{ old('notification_frequency') === 'daily' ? 'checked' : '' }} checked>
                                <div>
                                    <div class="font-medium">Giornaliera</div>
                                    <div class="text-sm text-gray-600">Riassunto quotidiano</div>
                                </div>
                            </label>

                            <label class="flex items-center p-4 border rounded-lg cursor-pointer hover:bg-gray-50">
                                <input type="radio" name="notification_frequency" value="weekly"
                                       class="mr-3 text-blue-600" {{ old('notification_frequency') === 'weekly' ? 'checked' : '' }}>
                                <div>
                                    <div class="font-medium">Settimanale</div>
                                    <div class="text-sm text-gray-600">Report settimanale</div>
                                </div>
                            </label>
                        </div>
                    </div>

                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-800 mb-4">📊 Tipi di Report</h3>
                        <div class="space-y-3">
                            <label class="flex items-center">
                                <input type="checkbox" name="summary_reports" value="1"
                                       class="mr-3 h-5 w-5 text-blue-600" checked>
                                <span class="text-gray-700">Report riassuntivi delle performance</span>
                            </label>

                            <label class="flex items-center">
                                <input type="checkbox" name="real_time_alerts" value="1"
                                       class="mr-3 h-5 w-5 text-blue-600" checked>
                                <span class="text-gray-700">Allerte in tempo reale per vulnerabilità critiche</span>
                            </label>

                            <label class="flex items-center">
                                <input type="checkbox" name="detailed_analytics" value="1"
                                       class="mr-3 h-5 w-5 text-blue-600">
                                <span class="text-gray-700">Analytics dettagliate con grafici e metriche</span>
                            </label>

                            <label class="flex items-center">
                                <input type="checkbox" name="participant_progress" value="1"
                                       class="mr-3 h-5 w-5 text-blue-600" checked>
                                <span class="text-gray-700">Progressi individuali dei partecipanti</span>
                            </label>
                        </div>
                    </div>

                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                        <div class="flex items-start">
                            <span class="text-blue-600 text-xl mr-3">💡</span>
                            <div>
                                <h4 class="font-medium text-blue-900 mb-1">Suggerimento</h4>
                                <p class="text-sm text-blue-800">
                                    Per campagne critiche, abilita le notifiche immediate e gli allerte in tempo reale.
                                    Per training di routine, le notifiche giornaliere sono sufficienti.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="px-8 py-4 bg-gray-50 flex justify-between">
                    <a href="{{ route('wizard.step4', $session) }}" class="px-4 py-2 text-gray-600 hover:text-gray-800">
                        ← Step Precedente
                    </a>
                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        Continua → Step 6
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
