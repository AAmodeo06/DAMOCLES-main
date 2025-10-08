{{-- Implementato da: Andrea Amodeo --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3>Simulazione Template: {{ $template->name }}</h3>
                </div>

                <div class="card-body">
                    {{-- Risultati Simulazione - Andrea Amodeo --}}
                    @foreach($simulations as $index => $simulation)
                    <div class="simulation-result mb-4 p-3 border rounded">
                        <h5>Utente Test: {{ $simulation['user']->name }} {{ $simulation['user']->surname }}</h5>

                        {{-- Human Factors dell'utente - Andrea Amodeo --}}
                        <div class="mb-3">
                            <strong>Human Factors:</strong>
                            @foreach($simulation['user']->humanFactors as $hf)
                                <span class="badge bg-secondary">
                                    {{ $hf->name }} (Score: {{ $hf->pivot->score }})
                                </span>
                            @endforeach
                        </div>

                        {{-- Contenuto Generato - Andrea Amodeo --}}
                        <div class="generated-content bg-light p-3 rounded">
                            <strong>Contenuto Generato:</strong>
                            <div class="mt-2">
                                {{ $simulation['content'] }}
                            </div>
                        </div>

                        {{-- Opzioni Modifica - Andrea Amodeo --}}
                        <div class="mt-3">
                            <button class="btn btn-sm btn-primary"
                                    onclick="editPrompt({{ $index }})">
                                Modifica Prompt
                            </button>
                            <button class="btn btn-sm btn-success"
                                    onclick="regenerate({{ $index }})">
                                Rigenera
                            </button>
                        </div>
                    </div>
                    @endforeach

                    {{-- Azioni Finali - Andrea Amodeo --}}
                    <div class="mt-4">
                        <form action="{{ route('training-campaign.SelectFinalUsers') }}" method="GET">
                            <input type="hidden" name="approved_simulation" value="true">
                            <button type="submit" class="btn btn-success">
                                Procedi con Selezione Utenti Finali
                            </button>
                        </form>
                        <a href="{{ route('prompt-templates.index') }}" class="btn btn-secondary">
                            Torna ai Template
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// JavaScript per editing inline - Andrea Amodeo
function editPrompt(index) {
    // Implementa modifica inline del prompt
    alert('Funzionalità di editing prompt per simulazione ' + index);
}

function regenerate(index) {
    // Rigenera contenuto per specifico utente
    alert('Rigenerazione contenuto per utente ' + index);
}
</script>
@endsection
