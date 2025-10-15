{{-- Realizzato da: Luigi La Gioia --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Le Mie Campagne di Training</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('warning'))
        <div class="alert alert-warning">{{ session('warning') }}</div>
    @endif

    <div class="row">
        @forelse($assignments as $assignment)
            <div class="col-md-4 mb-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ $assignment->campaign->title }}</h5>
                        <p class="card-text">{{ $assignment->campaign->attackType->name }}</p>
                        <p><strong>Progress:</strong> {{ $assignment->progress }}%</p>
                        <div class="progress mb-3">
                            <div class="progress-bar" style="width: {{ $assignment->progress }}%"></div>
                        </div>
                        <p><strong>Stato:</strong> {{ ucfirst($assignment->status) }}</p>

                        @if($assignment->campaign->status === 'active' && $assignment->status !== 'completed')
                            <a href="{{ route('training.unit.show', $assignment->campaign->units->first()) }}"
                               class="btn btn-primary">Continua Training</a>
                        @elseif($assignment->campaign->status === 'paused')
                            <span class="badge bg-warning">Campagna in pausa</span>
                        @else
                            <span class="badge bg-success">Completato</span>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <p>Nessuna campagna assegnata al momento.</p>
        @endforelse
    </div>
</div>
@endsection
