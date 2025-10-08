<?php
// Implementato da: Luigi La Gioia
namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    // Lista notifiche utente - Luigi La Gioia
    public function index()
    {
        $user = Auth::user();

        $notifications = Notification::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        $unreadCount = $notifications->where('isVisualized', false)->count();

        return view('notifications.index', compact('notifications', 'unreadCount'));
    }

    // Segna notifica come letta - Luigi La Gioia
    public function markAsRead(Notification $notification)
    {
        $this->authorize('update', $notification);

        $notification->update(['isVisualized' => true]);

        return response()->json([
            'success' => true,
            'message' => 'Notifica segnata come letta'
        ]);
    }

    // Segna tutte come lette - Luigi La Gioia
    public function markAllAsRead()
    {
        $user = Auth::user();

        Notification::where('user_id', $user->id)
            ->where('isVisualized', false)
            ->update(['isVisualized' => true]);

        return redirect()->back()
            ->with('success', 'Tutte le notifiche sono state lette');
    }
}
