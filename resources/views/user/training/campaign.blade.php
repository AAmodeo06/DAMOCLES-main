@extends('layouts.app')

@section('content')
<div class="container mx-auto max-w-4xl py-6">
  <a href="{{ route('user.training.index') }}" class="text-sm text-sky-700 underline">&larr; Indietro</a>

  <h1 class="text-2xl font-bold mt-2">{{ $campaign->title ?? 'Campagna' }}</h1>

  <div class="mt-4 space-y-2">
    @foreach(($units ?? []) as $u)
      <a href="{{ route('user.training.unit.show', $u->id) }}" class="block border rounded p-3 hover:bg-gray-50">
        <div class="flex items-center justify-between">
          <div>
            <div class="font-semibold">#{{ $u->id }}</div>
            <div class="text-xs text-gray-500">Tipo: {{ $u->content_type }}</div>
          </div>
          <span class="text-xs text-gray-500">Apri</span>
        </div>
      </a>
    @endforeach
  </div>
</div>
@endsection
