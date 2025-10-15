@extends('layouts.app')

@section('content')
<div class="container mx-auto max-w-3xl py-6">
  <h1 class="text-2xl font-bold">Notifiche</h1>

  {{-- Flash richiesto dai Dusk: "Notifica segnata come letta" --}}
  @if (session('status'))
    <div class="p-3 mb-4 rounded bg-green-100 text-green-800">
      {{ session('status') }}
    </div>
  @endif

  <div class="mt-4 space-y-2">
    @forelse(($notifications ?? []) as $n)
      <div class="border rounded p-3 {{ $n->read_at ? '' : 'bg-yellow-50' }}">
        <div class="text-xs text-gray-500">#{{ $n->id }}</div>
        <div class="font-semibold">{{ $n->message }}</div>

        <div class="flex items-center gap-2 mt-2 text-sm">
          @if(!$n->read_at)
            {{-- Bottone richiesto dai Dusk: "Segna come letta" (POST) --}}
            <form method="post" action="{{ route('notifications.read', $n->id) }}">
              @csrf
              <button class="px-2 py-1 border rounded">Segna come letta</button>
            </form>
          @else
            <span class="text-green-700">Letta ✓</span>
          @endif
        </div>
      </div>
    @empty
      <p>Nessuna notifica.</p>
    @endforelse
  </div>
</div>
@endsection
