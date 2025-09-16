<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($notifications);
    }

    public function markAsRead(Request $request)
    {
        $user = auth()->user();

        if ($user) {
            $user->unreadNotifications()
                ->where('id', $request->id)
                ->update(['read_at' => now()]);
            
            return response()->json(['status' => 'success']);
        }

        return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 401);
    }
    public function markAllRead()
    {
        Notification::where('user_id', auth()->id())
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return response()->json(['success' => true]);
    }
}
