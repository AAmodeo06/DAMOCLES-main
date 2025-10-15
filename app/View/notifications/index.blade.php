{{-- Realizzato da: Luigi La Gioia --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Notifiche</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="list-group">
        @forelse($notifications as $notification)
            <div class="list-group-item {{ $notification->isRead() ? '' : 'list-group-item-info' }}">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="mb-1">{{ $notification->message }}</p>
                        <small>{{ $notification->created_at->diffForHumans() }}</small>
                    </div>

                    @if(!$notification->isRead())
                        <form method="POST" action="{{ route('notifications.read', $notification) }}">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-outline-primary">Segna come letta</button>
                        </form>
                    @endif
                </div>
            </div>
        @empty
            <p>Nessuna notifica disponibile.</p>
        @endforelse
    </div>
</div>
@endsection
