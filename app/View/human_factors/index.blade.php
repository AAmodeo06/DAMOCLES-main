{{-- Implementato da: Andrea Amodeo --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3>Human Factors Management</h3>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createHFModal">
                        Nuovo Human Factor
                    </button>
                </div>

                <div class="card-body">
                    {{-- Tabella Human Factors - Andrea Amodeo --}}
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nome</th>
                                <th>Descrizione</th>
                                <th>Vulnerabilità Associate</th>
                                <th>Azioni</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($humanFactors as $hf)
                            <tr>
                                <td>{{ $hf->id }}</td>
                                <td>{{ $hf->name }}</td>
                                <td>{{ Str::limit($hf->description, 50) }}</td>
                                <td>
                                    @foreach($hf->vulnerabilities as $vuln)
                                        <span class="badge bg-info">{{ $vuln->name }}</span>
                                    @endforeach
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-warning"
                                            onclick="editHF({{ $hf->id }})">
                                        Modifica
                                    </button>
                                    <form action="{{ route('human-factors.destroy', $hf) }}"
                                          method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"
                                                onclick="return confirm('Confermi eliminazione?')">
                                            Elimina
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{ $humanFactors->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modal Creazione - Andrea Amodeo --}}
<div class="modal fade" id="createHFModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('human-factors.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Nuovo Human Factor</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Nome</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Descrizione</label>
                        <textarea name="description" class="form-control" rows="4" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Crea</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
