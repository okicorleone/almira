<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Models\Booking; // contoh, sesuaikan dengan model notif kamu
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Ruangan;
use App\Models\Room;

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
    
    public function latest()
    {
        // ==== hitung unread count ====
        $unreadCount = Notification::where('user_id', Auth::id())
            ->whereNull('read_at')
            ->count();

        // ==== ambil data permintaan terbaru (contoh) ====
        $latestRequest = Booking::latest()->first();
        $latestData = null;
        if ($latestRequest) {
            $latestData = [
                'pemohon' => $latestRequest->user->name ?? 'User',
                'ruangan' => $latestRequest->room->nama ?? '-',
                'agenda'  => $latestRequest->agenda ?? '-',
                'waktu'   => Carbon::parse($latestRequest->created_at)->diffForHumans(),
            ];
        }

        // ==== ambil jadwal terdekat (contoh) ====
        $nearestSchedule = Booking::with('room')
            ->where('status', 'approved')
            ->where('tanggal', Carbon::today())
            ->where('jam', '>=', Carbon::now()->format('H:i:s'))
            ->orderBy('jam', 'asc')
            ->first();

        $nearestData = null;
        if ($nearestSchedule) {
            $nearestData = [
                'ruangan'   => $nearestSchedule->room->nama ?? '-',
                'agenda'    => $nearestSchedule->agenda ?? '-',
                'countdown' => Carbon::parse($nearestSchedule->jam)->diffForHumans(),
            ];
        }

        return response()->json([
            'latestRequest'   => $latestData,
            'nearestSchedule' => $nearestData,
            'unreadCount'     => $unreadCount,
        ]);
    }
}
