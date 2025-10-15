@extends('layouts.app')

@section('content')
<div class="container mx-auto max-w-5xl py-6">
  <h1 class="text-2xl font-bold mb-4">Le mie campagne di training</h1>

  @if (session('status'))
    <div class="p-3 mb-4 rounded bg-green-100 text-green-800">
      {{ session('status') }}
    </div>
  @endif

  @forelse(($assignments ?? []) as $a)
    @php
      $camp = $a->campaign ?? null;
      $perc = $progress[$a->id] ?? 0;

      $firstUnit = \App\Models\TrainingUnit::where('campaign_id', $a->campaign_id)
                    ->orderBy('order_index')->orderBy('id')->first();
    @endphp

    <div class="border rounded p-4 mb-3">
      <div class="text-sm text-gray-500">Campagna #{{ $camp->id ?? '—' }}</div>
      <div class="font-semibold">{{ $camp->title ?? 'Campagna' }}</div>

      <div class="mt-2 text-sm">Progress: {{ $perc }}%</div>
      <div class="w-full bg-gray-200 rounded h-2 mt-1">
        <div class="bg-green-600 h-2 rounded" style="width: {{ $perc }}%"></div>
      </div>

      <div class="mt-3">
        @if($firstUnit)
          <a href="{{ route('user.training.unit.show', $firstUnit->id) }}"
             class="inline-block px-3 py-2 border rounded hover:bg-gray-50">
            Continua Training
          </a>
        @else
          <span class="text-xs text-gray-500">Nessuna unit disponibile.</span>
        @endif
      </div>
    </div>
  @empty
    <p>Non hai campagne assegnate.</p>
  @endforelse
</div>
@endsection
