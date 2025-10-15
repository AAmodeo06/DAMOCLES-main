{{-- Implementato da: Andrea Amodeo --}}
@extends('layouts.app')

@section('content')
<div class="container mx-auto max-w-3xl py-6">
    <h1 class="text-2xl font-bold mb-4">Assegna Human Factors a {{ $user->name }}</h1>

    @if(session('success'))
        <div class="p-3 bg-green-100 rounded mb-3">{{ session('success') }}</div>
    @endif

    <form method="post" action="{{ route('human-factors.assign.store',$user) }}">
        @csrf

        <div class="space-y-3">
            @foreach($factors as $f)
                @php
                    $current = $user->humanFactors->firstWhere('id',$f->id)?->pivot->debt_level ?? 'none';
                @endphp
                <div class="border rounded p-3">
                    <div class="font-semibold">{{ $f->name }}</div>
                    <div class="text-sm text-gray-600 mb-2">{{ $f->description }}</div>
                    <select name="factors[{{ $loop->index }}][debt_level]" class="border rounded p-2">
                        @foreach($debtLabels as $value => $label)
                            <option value="{{ $value }}" @selected($current===$value)>{{ $label }}</option>
                        @endforeach
                    </select>
                    <input type="hidden" name="factors[{{ $loop->index }}][id]" value="{{ $f->id }}">
                </div>
            @endforeach
        </div>

        <button class="mt-4 px-4 py-2 bg-blue-600 text-white rounded">Salva assegnazioni</button>
    </form>
</div>
@endsection
{{-- Fine implementazione --}}
