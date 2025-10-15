<?php
<<<<<<< Updated upstream
<<<<<<< Updated upstream
<<<<<<< Updated upstream
<<<<<<< Updated upstream
// Implementato da: Luigi La Gioia
=======

//REALIZZATO DA: Luigi La Gioia

>>>>>>> Stashed changes
=======

//REALIZZATO DA: Luigi La Gioia

>>>>>>> Stashed changes
=======

//REALIZZATO DA: Luigi La Gioia

>>>>>>> Stashed changes
=======

//REALIZZATO DA: Luigi La Gioia

>>>>>>> Stashed changes
namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

<<<<<<< Updated upstream
<<<<<<< Updated upstream
<<<<<<< Updated upstream
<<<<<<< Updated upstream
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
=======
=======
>>>>>>> Stashed changes
=======
>>>>>>> Stashed changes
=======
>>>>>>> Stashed changes
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class NotificationController extends Controller
{
    use AuthorizesRequests;
    public function index()
    {
        $user = Auth::user();
        $notifications = Notification::where('user_id',$user->id)->orderByDesc('id')->get();

        // Vista minimale con bottone POST per "Segna come letta"
        return view('user/notifications/index', compact('notifications'));
    }

    public function read(Notification $notification)
    {
        $this->authorize('update', $notification); // opzionale se usi policy
        if ($notification->user_id !== Auth::id()) abort(403);

        $notification->markAsRead();

        return back()->with('status','Notifica segnata come letta');
<<<<<<< Updated upstream
<<<<<<< Updated upstream
<<<<<<< Updated upstream
>>>>>>> Stashed changes
=======
>>>>>>> Stashed changes
=======
>>>>>>> Stashed changes
=======
>>>>>>> Stashed changes
    }
}
