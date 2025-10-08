{{-- Implementato da: Cosimo Mandrillo --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            {{-- Progress Bar - Cosimo Mandrillo --}}
            <div class="wizard-progress mb-4">
                <div class="progress" style="height: 30px;">
                    <div class="progress-bar" role="progressbar"
                         style="width: {{ ($step / 6) * 100 }}%">
                        Step {{ $step }} di 6
                    </div>
                </div>

                <div class="d-flex justify-content-between mt-2">
                    <small class="{{ $step >= 1 ? 'text-primary fw-bold' : 'text-muted' }}">1. Info Generali</small>
                    <small class="{{ $step >= 2 ? 'text-primary fw-bold' : 'text-muted' }}">2. Tipo Training</small>
                    <small class="{{ $step >= 3 ? 'text-primary fw-bold' : 'text-muted' }}">3. Template</small>
                    <small class="{{ $step >= 4 ? 'text-primary fw-bold' : 'text-muted' }}">4. Test Users</small>
                    <small class="{{ $step >= 5 ? 'text-primary fw-bold' : 'text-muted' }}">5. Simulazione</small>
                    <small class="{{ $step >= 6 ? 'text-primary fw-bold' : 'text-muted' }}">6. Utenti Finali</small>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3>Crea Nuova Campagna di Training</h3>
                </div>

                <div class="card-body">
                    <form action="{{ route('campaigns.store') }}" method="POST" id="wizardForm">
                        @csrf
                        <input type="hidden" name="current_step" value="{{ $step }}">

                        {{-- Step 1: General Info - Cosimo Mandrillo --}}
                        @if($step == 1)
                        <div class="step-content">
                            <h4>Informazioni Generali</h4>

                            <div class="mb-3">
                                <label for="title" class="form-label">Titolo Campagna*</label>
                                <input type="text" class="form-control" id="title" name="title"
                                       value="{{ $campaign['title'] ?? '' }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Descrizione*</label>
                                <textarea class="form-control" id="description" name="description"
                                          rows="4" required>{{ $campaign['description'] ?? '' }}</textarea>
                            </div>

                            <div class="mb-3">
                                <label for="vulnerability_id" class="form-label">Seleziona Attacco*</label>
                                <select class="form-select" id="vulnerability_id" name="vulnerability_id" required>
                                    <option value="">-- Seleziona --</option>
                                    @foreach($vulnerabilities as $vuln)
                                    <option value="{{ $vuln->id }}"
                                            {{ ($campaign['vulnerability_id'] ?? '') == $vuln->id ? 'selected' : '' }}>
                                        {{ $vuln->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="expiration_date" class="form-label">Data Scadenza*</label>
                                <input type="date" class="form-control" id="expiration_date"
                                       name="expiration_date"
                                       value="{{ $campaign['expiration_date'] ?? '' }}"
                                       min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                                       required>
                            </div>
                        </div>
                        @endif

                        {{-- Step 2: Training Type - Cosimo Mandrillo --}}
                        @if($step == 2)
                        <div class="step-content">
                            <h4>Tipo di Training</h4>

                            <div class="mb-4">
                                <label class="form-label">Modalità di Erogazione*</label>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="card training-type {{ ($campaign['content_type'] ?? '') == 'text' ? 'border-primary' : '' }}">
                                            <div class="card-body text-center">
                                                <input type="radio" name="content_type" value="text"
                                                       id="type_text"
                                                       {{ ($campaign['content_type'] ?? '') == 'text' ? 'checked' : '' }} required>
                                                <label for="type_text" class="w-100 cursor-pointer">
                                                    <i class="fas fa-file-alt fa-3x mb-2"></i>
                                                    <h5>Testo</h5>
                                                    <p class="small text-muted">Contenuto formativo testuale</p>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card training-type {{ ($campaign['content_type'] ?? '') == 'audio' ? 'border-primary' : '' }}">
                                            <div class="card-body text-center">
                                                <input type="radio" name="content_type" value="audio"
                                                       id="type_audio"
                                                       {{ ($campaign['content_type'] ?? '') == 'audio' ? 'checked' : '' }} required>
                                                <label for="type_audio" class="w-100 cursor-pointer">
                                                    <i class="fas fa-microphone fa-3x mb-2"></i>
                                                    <h5>Audio/Podcast</h5>
                                                    <p class="small text-muted">Contenuto audio interattivo</p>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Verbosità Contenuto*</label>
                                <select class="form-select" name="verbosity" required>
                                    <option value="low" {{ ($campaign['verbosity'] ?? '') == 'low' ? 'selected' : '' }}>
                                        Bassa - Contenuti concisi
                                    </option>
                                    <option value="medium" {{ ($campaign['verbosity'] ?? '') == 'medium' ? 'selected' : '' }}>
                                        Media - Contenuti bilanciati
                                    </option>
                                    <option value="high" {{ ($campaign['verbosity'] ?? '') == 'high' ? 'selected' : '' }}>
                                        Alta - Contenuti dettagliati
                                    </option>
                                </select>
                            </div>
                        </div>
                        @endif

                        {{-- Step 3: Template - Cosimo Mandrillo --}}
                        @if($step == 3)
                        <div class="step-content">
                            <h4>Selezione Template e LLM</h4>

                            <div class="mb-3">
                                <label class="form-label">Template Prompt*</label>
                                <select class="form-select" name="template_id" id="template_id" required>
                                    <option value="">-- Seleziona Template --</option>
                                    @foreach($templates->where('content_type', $campaign['content_type'] ?? 'text') as $template)
                                    <option value="{{ $template->id }}"
                                            {{ ($campaign['template_id'] ?? '') == $template->id ? 'selected' : '' }}>
                                        {{ $template->name }}
                                    </option>
                                    @endforeach
                                </select>
                                <small class="form-text text-muted">
                                    I template sono filtrati in base al tipo di training selezionato
                                </small>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Large Language Model*</label>
                                <select class="form-select" name="llm_id" required>
                                    @foreach($llms as $llm)
                                    <option value="{{ $llm->id }}"
                                            {{ ($campaign['llm_id'] ?? '') == $llm->id ? 'selected' : '' }}>
                                        {{ $llm->provider }} - {{ $llm->model }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Istruzioni Personalizzate (Opzionale)</label>
                                <textarea class="form-control" name="custom_instructions" rows="4"
                                          placeholder="Aggiungi istruzioni specifiche per personalizzare ulteriormente il contenuto generato..."
                                >{{ $campaign['custom_instructions'] ?? '' }}</textarea>
                                <small class="form-text text-muted">
                                    Queste istruzioni verranno aggiunte al prompt del template
                                </small>
                            </div>
                        </div>
                        @endif

                        {{-- Step 4: Fake Users - Cosimo Mandrillo --}}
                        @if($step == 4)
                        <div class="step-content">
                            <h4>Selezione Utenti di Test</h4>
                            <p class="text-muted">Seleziona gli utenti fake per simulare la campagna</p>

                            <div class="user-selection">
                                @foreach($fakeUsers as $user)
                                <div class="form-check p-3 border rounded mb-2">
                                    <input class="form-check-input" type="checkbox"
                                           name="fake_users[]" value="{{ $user->id }}"
                                           id="fake_{{ $user->id }}"
                                           {{ in_array($user->id, $campaign['fake_users'] ?? []) ? 'checked' : '' }}>
                                    <label class="form-check-label w-100" for="fake_{{ $user->id }}">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <strong>{{ $user->name }} {{ $user->surname }}</strong>
                                                <br>
                                                <small class="text-muted">{{ $user->email }}</small>
                                            </div>
                                            <div class="text-end">
                                                @foreach($user->humanFactors->take(3) as $hf)
                                                <span class="badge bg-secondary">{{ $hf->name }}</span>
                                                @endforeach
                                            </div>
                                        </div>
                                    </label>
                                </div>
                                @endforeach
                            </div>

                            <div class="alert alert-info mt-3">
                                <i class="fas fa-info-circle"></i>
                                Seleziona almeno 1 utente di test per procedere
                            </div>
                        </div>
                        @endif

                        {{-- Step 5: Simulation Review - Cosimo Mandrillo --}}
                        @if($step == 5)
                        <div class="step-content">
                            <h4>Revisione Simulazione</h4>
                            <p class="text-muted">Rivedi i risultati della simulazione prima di procedere</p>

                            @if(session('simulation_results'))
                                <div class="alert alert-success">
                                    <i class="fas fa-check-circle"></i>
                                    Simulazione completata con successo!
                                </div>

                                <a href="{{ route('prompt-templates.simulate') }}"
                                   class="btn btn-outline-primary mb-3">
                                    <i class="fas fa-eye"></i> Vedi Risultati Simulazione
                                </a>
                            @else
                                <div class="alert alert-warning">
                                    <i class="fas fa-exclamation-triangle"></i>
                                    Devi eseguire la simulazione prima di procedere
                                </div>

                                <button type="button" class="btn btn-primary"
                                        onclick="runSimulation()">
                                    Esegui Simulazione
                                </button>
                            @endif
                        </div>
                        @endif

                        {{-- Step 6: Final Users - Cosimo Mandrillo --}}
                        @if($step == 6)
                        <div class="step-content">
                            <h4>Selezione Utenti Finali</h4>
                            <p class="text-muted">Seleziona gli utenti reali destinatari della campagna</p>

                            {{-- Filtri - Cosimo Mandrillo --}}
                            <div class="filters mb-3">
                                <div class="row">
                                    <div class="col-md-4">
                                        <input type="text" class="form-control" id="search"
                                               placeholder="Cerca per nome...">
                                    </div>
                                    <div class="col-md-4">
                                        <select class="form-select" id="filter_hf">
                                            <option value="">Filtra per Human Factor</option>
                                            @foreach(\App\Models\HumanFactor::all() as $hf)
                                            <option value="{{ $hf->id }}">{{ $hf->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <button type="button" class="btn btn-secondary w-100"
                                                onclick="selectAll()">
                                            Seleziona Tutti
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="user-selection" id="finalUsersList">
                                @foreach($realUsers as $user)
                                <div class="form-check p-3 border rounded mb-2 user-item"
                                     data-name="{{ strtolower($user->name . ' ' . $user->surname) }}">
                                    <input class="form-check-input" type="checkbox"
                                           name="final_users[]" value="{{ $user->id }}"
                                           id="final_{{ $user->id }}"
                                           {{ in_array($user->id, $campaign['final_users'] ?? []) ? 'checked' : '' }}>
                                    <label class="form-check-label w-100" for="final_{{ $user->id }}">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <strong>{{ $user->name }} {{ $user->surname }}</strong>
                                                <br>
                                                <small class="text-muted">{{ $user->email }}</small>
                                            </div>
                                            <div class="text-end">
                                                @foreach($user->humanFactors->where('pivot.vuln_id', $campaign['vulnerability_id'] ?? null) as $hf)
                                                <span class="badge bg-{{ $hf->pivot->score >= 4 ? 'danger' : ($hf->pivot->score >= 3 ? 'warning' : 'info') }}">
                                                    {{ $hf->name }} ({{ $hf->pivot->score }})
                                                </span>
                                                @endforeach
                                            </div>
                                        </div>
                                    </label>
                                </div>
                                @endforeach
                            </div>

                            <div class="alert alert-info mt-3">
                                <i class="fas fa-info-circle"></i>
                                Seleziona almeno 1 utente finale. Gli utenti con score alto (4-5) sono più vulnerabili.
                            </div>
                        </div>
                        @endif

                        {{-- Navigation Buttons - Cosimo Mandrillo --}}
                        <div class="d-flex justify-content-between mt-4">
                            @if($step > 1)
                            <a href="{{ route('campaigns.create', ['step' => $step - 1]) }}"
                               class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Indietro
                            </a>
                            @else
                            <a href="{{ route('campaigns.index') }}" class="btn btn-secondary">
                                Annulla
                            </a>
                            @endif

                            <button type="submit" class="btn btn-primary">
                                @if($step == 6)
                                    <i class="fas fa-check"></i> Crea Campagna
                                @else
                                    Avanti <i class="fas fa-arrow-right"></i>
                                @endif
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// JavaScript per gestione wizard - Cosimo Mandrillo
function selectAll() {
    document.querySelectorAll('.user-item input[type="checkbox"]').forEach(cb => {
        cb.checked = true;
    });
}

document.getElementById('search')?.addEventListener('input', function(e) {
    const searchTerm = e.target.value.toLowerCase();
    document.querySelectorAll('.user-item').forEach(item => {
        const name = item.dataset.name;
        item.style.display = name.includes(searchTerm) ? 'block' : 'none';
    });
});

function runSimulation() {
    // Redirect to simulation
    const form = document.getElementById('wizardForm');
    form.action = "{{ route('prompt-templates.simulate') }}";
    form.submit();
}
</script>
@endsection
