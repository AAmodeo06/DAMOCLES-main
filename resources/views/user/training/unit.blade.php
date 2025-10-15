@extends('layouts.app')

@section('content')
<div class="container mx-auto max-w-3xl py-6">
  {{-- Flash (non strettamente necessario qui, ma utile se decidi di fare back()->with(...) ) --}}
  @if (session('status'))
    <div class="p-3 mb-4 rounded bg-green-100 text-green-800">
      {{ session('status') }}
    </div>
  @endif

  <a href="{{ route('user.training.index') }}" class="text-sm text-sky-700 underline">&larr; Torna al training</a>

  <h1 class="text-2xl font-bold mt-2">
    Unit #{{ $unit->id }}
  </h1>
  <div class="text-sm text-gray-500 mb-3">Tipo: {{ $unit->content_type }}</div>

  {{-- Audio opzionale (se in futuro aggiungi una colonna per l'audio) --}}
  @if(method_exists($unit, 'isAudio') && $unit->isAudio() && !empty($unit->audio_url))
    <audio controls class="w-full mb-4">
      <source src="{{ $unit->audio_url }}" type="audio/mpeg">
    </audio>
  @endif

  <article class="prose max-w-none whitespace-pre-wrap bg-white border rounded p-4">
    {{ $unit->content_body }}
  </article>

  <div class="mt-4">
    {{-- Bottone richiesto dai Dusk: "Completa Unit"  --}}
    <form method="post" action="{{ route('user.training.unit.complete', $unit->id) }}">
      @csrf
      <button class="px-4 py-2 bg-green-600 text-white rounded">Completa Unit</button>
    </form>
  </div>
</div>
@endsection
