{{-- Implementato da: Cosimo Mandrillo --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            {{-- Header - Cosimo Mandrillo --}}
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2>{{ $campaign->title }}</h2>
                    <p class="text-muted">{{ $campaign->description }}</p>
                </div>
                <div>
                    @php
                        $stateColors = [
                            'draft' => 'secondary',
                            'ready' => 'warning',
                            'ongoing' => 'primary',
                            'finished' => 'success'
                        ];
                    @endphp
                    <span class="badge bg-{{ $stateColors[$campaign->state] }} fs-5">
                        {{ ucfirst($campaign->state) }}
                    </span>
                </div>
            </div>

            {{-- Statistiche Overview - Cosimo Mandrillo --}}
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card text-center">
                        <div class="card-body">
                            <h3>{{ $stats['total_users'] }}</h3>
                            <p class="text-muted mb-0">Utenti Totali</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-center">
                        <div class="card-body">
                            <h3>{{ $stats['completed_users'] }}</h3>
                            <p class="text-muted mb-0">Completati</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-center">
                        <div class="card-body">
                            <h3>{{ $stats['completion_rate'] }}%</h3>
                            <p class="text-muted mb-0">Tasso Completamento</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-center">
                        <div class="card-body">
                            <h3>{{ $stats['average_score'] }}%</h3>
                            <p class="text-muted mb-0">Punteggio Medio</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Dettagli Campagna - Cosimo Mandrillo --}}
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h5>Dettagli Campagna</h5>
                        </div>
                        <div class="card-body">
                            <dl class="row">
                                <dt class="col-sm-4">Vulnerabilità:</dt>
                                <dd class="col-sm-8">
                                    <span class="badge bg-info">{{ $campaign->vulnerability->name }}</span>
                                </dd>

                                <dt class="col-sm-4">Tipo Contenuto:</dt>
                                <dd class="col-sm-8">{{ $campaign->content_type == 'text' ? 'Testo' : 'Audio' }}</dd>

                                <dt class="col-sm-4">Verbosità:</dt>
                                <dd class="col-sm-8">{{ ucfirst($campaign->verbosity) }}</dd>

                                <dt class="col-sm-4">Template:</dt>
                                <dd class="col-sm-8">{{ $campaign->template->name }}</dd>

                                <dt class="col-sm-4">LLM:</dt>
                                <dd class="col-sm-8">{{ $campaign->llm->provider }} - {{ $campaign->llm->model }}</dd>

                                <dt class="col-sm-4">Data Creazione:</dt>
                                <dd class="col-sm-8">{{ $campaign->created_at->format('d/m/Y H:i') }}</dd>

                                <dt class="col-sm-4">Scadenza:</dt>
                                <dd class="col-sm-8">
                                    {{ $campaign->expiration_date->format('d/m/Y') }}
                                    @if($campaign->isExpired())
                                        <span class="badge bg-danger">Scaduta</span>
                                    @endif
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h5>Azioni</h5>
                        </div>
                        <div class="card-body">
                            @if($campaign->state == 'draft' || $campaign->state == 'ready')
                            <form action="{{ route('campaigns.changeState', $campaign) }}"
                                  method="POST" class="mb-2">
                                @csrf
                                <input type="hidden" name="action" value="start">
                                <button type="submit" class="btn btn-success w-100">
                                    <i class="fas fa-play"></i> Avvia Campagna
                                </button>
                            </form>
                            @endif

                            @if($campaign->state == 'ongoing')
                            <form action="{{ route('campaigns.changeState', $campaign) }}"
                                  method="POST" class="mb-2">
                                @csrf
                                <input type="hidden" name="action" value="stop">
                                <button type="submit" class="btn btn-warning w-100">
                                    <i class="fas fa-pause"></i> Sospendi Campagna
                                </button>
                            </form>

                            <form action="{{ route('campaigns.changeState', $campaign) }}"
                                  method="POST" class="mb-2">
                                @csrf
                                <input type="hidden" name="action" value="finish">
                                <button type="submit" class="btn btn-info w-100">
                                    <i class="fas fa-check"></i> Termina Campagna
                                </button>
                            </form>
                            @endif

                            <button class="btn btn-secondary w-100 mb-2"
                                    onclick="duplicateCampaign({{ $campaign->id }})">
                                <i class="fas fa-copy"></i> Duplica Campagna
                            </button>

                            <button class="btn btn-danger w-100"
                                    onclick="deleteCampaign({{ $campaign->id }})">
                                <i class="fas fa-trash"></i> Elimina Campagna
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Lista Utenti e Progressi - Cosimo Mandrillo --}}
            <div class="card">
                <div class="card-header">
                    <h5>Progressi Utenti</h5>
                </div>
                <div class="card-body">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Utente</th>
                                <th>Human Factors Critici</th>
                                <th>Stato</th>
                                <th>Punteggio Quiz</th>
                                <th>Data Completamento</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($campaign->trainingSessions as $session)
                            <tr>
                                <td>
                                    <strong>{{ $session->user->name }} {{ $session->user->surname }}</strong>
                                    <br>
                                    <small class="text-muted">{{ $session->user->email }}</small>
                                </td>
                                <td>
                                    @foreach($session->user->humanFactors
                                        ->where('pivot.vuln_id', $campaign->vulnerability_id)
                                        ->where('pivot.score', '>=', 3) as $hf)
                                        <span class="badge bg-{{ $hf->pivot->score >= 4 ? 'danger' : 'warning' }}">
                                            {{ $hf->name }} ({{ $hf->pivot->score }})
                                        </span>
                                    @endforeach
                                </td>
                                <td>
                                    @if($session->isCompleted)
                                        <span class="badge bg-success">Completato</span>
                                    @else
                                        <span class="badge bg-warning">In Corso</span>
                                    @endif
                                </td>
                                <td>
                                    @if($session->isCompleted)
                                        <span class="badge bg-{{ $session->quiz_score >= 70 ? 'success' : 'danger' }}">
                                            {{ $session->quiz_score }}%
                                        </span>
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </td>
                                <td>
                                    {{ $session->completion_date ? $session->completion_date->format('d/m/Y H:i') : '-' }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-3">
                <a href="{{ route('campaigns.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Torna alla Lista
                </a>
            </div>
        </div>
    </div>
</div>

<script>
// JavaScript per azioni - Cosimo Mandrillo
function duplicateCampaign(id) {
    if (confirm('Vuoi duplicare questa campagna?')) {
        fetch(`/evaluator/campaigns/${id}/duplicate`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
            }
        }).then(response => {
            if (response.ok) {
                location.reload();
            }
        });
    }
}

function deleteCampaign(id) {
    if (confirm('Sei sicuro di voler eliminare questa campagna? Questa azione è irreversibile.')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/evaluator/campaigns/${id}`;

        const csrfField = document.createElement('input');
        csrfField.type = 'hidden';
        csrfField.name = '_token';
        csrfField.value = '{{ csrf_token() }}';

        const methodField = document.createElement('input');
        methodField.type = 'hidden';
        methodField.name = '_method';
        methodField.value = 'DELETE';

        form.appendChild(csrfField);
        form.appendChild(methodField);
        document.body.appendChild(form);
        form.submit();
    }
}
</script>
@endsection
