{{-- Realizzato da: Luigi La Gioia --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $assignment->campaign->title }}</h1>
    <h3>Unit {{ $unit->order_index }}</h3>

    <div class="card mt-4">
        <div class="card-body">
            @if($unit->content_type === 'text')
                <div class="content-text">
                    {!! nl2br(e($unit->content_body)) !!}
                </div>
            @else
                <audio controls class="w-100">
                    <source src="{{ $unit->content_body }}" type="audio/mpeg">
                </audio>
            @endif
        </div>
    </div>

    <div class="mt-4">
        <form method="POST" action="{{ route('training.unit.complete', $unit) }}">
            @csrf
            <button type="submit" class="btn btn-success btn-lg">Completa Unit</button>
        </form>
    </div>
</div>
@endsection
