{{-- Implementato da: Cosimo Mandrillo --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Le Mie Campagne di Training</h2>Gestione Campagne</h2>
                <a href="{{ route('campaigns.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Nuova Campagna
                </a>
            </div>

            {{-- Statistiche - Cosimo Mandrillo --}}
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card text-center">
                        <div class="card-body">
                            <h3>{{ $stats['draft'] }}</h3>
                            <p class="text-muted">Bozze</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-center">
                        <div class="card-body">
                            <h3>{{ $stats['ready'] }}</h3>
                            <p class="text-muted">Pronte</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-center">
                        <div class="card-body">
                            <h3>{{ $stats['ongoing'] }}</h3>
                            <p class="text-muted">In Corso</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-center">
                        <div class="card-body">
                            <h3>{{ $stats['finished'] }}</h3>
                            <p class="text-muted">Completate</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Filtri - Cosimo Mandrillo --}}
            <div class="card mb-3">
                <div class="card-body">
                    <div class="btn-group" role="group">
                        <a href="{{ route('campaigns.index', ['state' => 'all']) }}"
                           class="btn btn-{{ $filter == 'all' ? 'primary' : 'outline-primary' }}">
                            Tutte
                        </a>
                        <a href="{{ route('campaigns.index', ['state' => 'draft']) }}"
                           class="btn btn-{{ $filter == 'draft' ? 'primary' : 'outline-primary' }}">
                            Bozze
                        </a>
                        <a href="{{ route('campaigns.index', ['state' => 'ready']) }}"
                           class="btn btn-{{ $filter == 'ready' ? 'primary' : 'outline-primary' }}">
                            Pronte
                        </a>
                        <a href="{{ route('campaigns.index', ['state' => 'ongoing']) }}"
                           class="btn btn-{{ $filter == 'ongoing' ? 'primary' : 'outline-primary' }}">
                            In Corso
                        </a>
                        <a href="{{ route('campaigns.index', ['state' => 'finished']) }}"
                           class="btn btn-{{ $filter == 'finished' ? 'primary' : 'outline-primary' }}">
                            Completate
                        </a>
                    </div>
                </div>
            </div>

            {{-- Lista Campagne - Cosimo Mandrillo --}}
            <div class="card">
                <div class="card-body">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Titolo</th>
                                <th>Vulnerabilità</th>
                                <th>Stato</th>
                                <th>Utenti</th>
                                <th>Completamento</th>
                                <th>Scadenza</th>
                                <th>Azioni</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($campaigns as $campaign)
                            <tr>
                                <td>
                                    <strong>{{ $campaign->title }}</strong>
                                    <br>
                                    <small class="text-muted">{{ Str::limit($campaign->description, 50) }}</small>
                                </td>
                                <td>
                                    <span class="badge bg-info">{{ $campaign->vulnerability->name }}</span>
                                </td>
                                <td>
                                    @php
                                        $stateColors = [
                                            'draft' => 'secondary',
                                            'ready' => 'warning',
                                            'ongoing' => 'primary',
                                            'finished' => 'success'
                                        ];
                                        $stateLabels = [
                                            'draft' => 'Bozza',
                                            'ready' => 'Pronta',
                                            'ongoing' => 'In Corso',
                                            'finished' => 'Completata'
                                        ];
                                    @endphp
                                    <span class="badge bg-{{ $stateColors[$campaign->state] }}">
                                        {{ $stateLabels[$campaign->state] }}
                                    </span>
                                </td>
                                <td>{{ $campaign->trainingSessions->count() }}</td>
                                <td>
                                    <div class="progress" style="height: 20px;">
                                        <div class="progress-bar" style="width: {{ $campaign->completion_rate }}%">
                                            {{ round($campaign->completion_rate) }}%
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $campaign->expiration_date->format('d/m/Y') }}</td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('campaigns.show', $campaign) }}"
                                           class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @if($campaign->state == 'ready')
                                        <form action="{{ route('campaigns.changeState', $campaign) }}"
                                              method="POST" class="d-inline">
                                            @csrf
                                            <input type="hidden" name="action" value="start">
                                            <button type="submit" class="btn btn-sm btn-success">
                                                <i class="fas fa-play"></i>
                                            </button>
                                        </form>
                                        @endif
                                        @if($campaign->state == 'ongoing')
                                        <form action="{{ route('campaigns.changeState', $campaign) }}"
                                              method="POST" class="d-inline">
                                            @csrf
                                            <input type="hidden" name="action" value="stop">
                                            <button type="submit" class="btn btn-sm btn-warning">
                                                <i class="fas fa-pause"></i>
                                            </button>
                                        </form>
                                        @endif
                                        <button class="btn btn-sm btn-danger"
                                                onclick="deleteCampaign({{ $campaign->id }})">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">
                                    Nessuna campagna trovata
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>

                    {{ $campaigns->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Elimina campagna - Cosimo Mandrillo
function deleteCampaign(id) {
    if (confirm('Sei sicuro di voler eliminare questa campagna?')) {
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
