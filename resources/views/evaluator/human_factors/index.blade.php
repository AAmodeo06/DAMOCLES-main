{{-- Implementato da: Andrea Amodeo --}}
@extends('layouts.app')

@section('content')
<div class="container mx-auto max-w-5xl py-6">
    <h1 class="text-2xl font-bold mb-4">Human Factors</h1>

    @if(session('success'))
        <div class="p-3 bg-green-100 text-green-900 rounded mb-3">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="p-3 bg-red-100 text-red-900 rounded mb-3">
            <ul class="list-disc ml-5">
                @foreach ($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Ricerca --}}
    <form method="get" class="mb-4 flex gap-2">
        <input
            type="text"
            name="q"
            value="{{ $q ?? '' }}"
            placeholder="Cerca…"
            class="border rounded p-2 w-full"
        >
        <button class="px-4 py-2 bg-gray-800 text-white rounded">Cerca</button>
    </form>

    <div class="grid md:grid-cols-2 gap-4">
        {{-- Creazione nuovo HF --}}
        <div class="border rounded p-4">
            <h2 class="font-semibold mb-2">Nuovo Human Factor</h2>
            <form method="post" action="{{ route('human-factors.store') }}" class="flex flex-col gap-2">
                @csrf
                <label class="text-sm">Nome</label>
                <input name="name" class="border rounded p-2 w-full" required>

                <label class="text-sm">Descrizione</label>
                <textarea name="description" class="border rounded p-2 w-full" rows="4"></textarea>

                <div class="pt-2">
                    <button class="px-4 py-2 bg-blue-600 text-white rounded">Crea</button>
                </div>
            </form>
        </div>

        {{-- Elenco + update/delete --}}
        <div class="border rounded p-4">
            <h2 class="font-semibold mb-2">Elenco</h2>

            @forelse($humanFactors as $f)
                <div class="border rounded p-3 mb-3">
                    {{-- Update --}}
                    <form method="post" action="{{ route('human-factors.update', $f) }}" class="flex flex-col gap-2">
                        @csrf
                        @method('PATCH')

                        <input name="name" value="{{ $f->name }}" class="border rounded p-2">

                        <textarea name="description" class="border rounded p-2" rows="3">{{ $f->description }}</textarea>

                        <div class="flex gap-2">
                            <button class="px-3 py-2 bg-amber-600 text-white rounded">Salva</button>
                            <a href="{{ route('human-factors.assign', ['user' => auth()->id()]) }}"
                               class="px-3 py-2 bg-gray-200 rounded border">Assegna a utente…</a>
                        </div>
                    </form>

                    {{-- Delete (form separato, niente annidamento) --}}
                    <form method="post" action="{{ route('human-factors.destroy', $f) }}" class="mt-2">
                        @csrf
                        @method('DELETE')
                        <button class="px-3 py-2 bg-red-600 text-white rounded"
                                onclick="return confirm('Eliminare &quot;{{ $f->name }}&quot;?')">
                            Elimina
                        </button>
                    </form>
                </div>
            @empty
                <div class="text-gray-500">Nessun human factor trovato.</div>
            @endforelse

            <div class="mt-3">
                {{ $humanFactors->withQueryString()->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
