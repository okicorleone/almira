<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Ruangan;
use App\Models\Booking;
use App\Models\Room;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Ambil pemakaian ruangan bulan ini
        $roomUsage = Booking::select('room_id',DB::raw('COUNT(*) as total'))
        ->whereMonth('created_at', now()->month)
        ->groupBy('room_id')
        ->with('room')
        ->get();

        // Label = nama ruangan, Data = jumlah pemakaian
        $labels = $roomUsage->pluck('room.nama');
        $data   = $roomUsage->pluck('total');

        // Ambil 5 peminjaman terbaru
        $recentBookings = Booking::with(['user', 'room'])
            ->latest()
            ->take(6)
            ->get();

        // Jadwal hari ini
        $todayBookings = Booking::with('room')
            ->whereDate('created_at', today())
            ->orderBy('jam', 'asc')
            ->get();

        $todayCount = Booking::whereDate('created_at', Carbon::today())->count();
        $monthCount = Booking::whereMonth('tanggal', Carbon::now()->month)->count();
        $availableRooms = Room::where('status', 'tersedia')->count();
        $pendingRequests = Booking::where('status', 'pending')->count();

        // KPI (contoh hitungan sederhana)
        // $kpi = [
        //     'today'    => Booking::whereDate('created_at', Carbon::today())->count(),
        //     'month'    => Booking::whereMonth('created_at', Carbon::now()->month)->count(),
        //     'rooms'    => Room::count(),

        //     'pending'  => Booking::where('status', 'pending')->count(),
        // ];
        return view('admin.dashboard', compact('recentBookings', 'pendingRequests','todayBookings','todayCount','monthCount','availableRooms', 'labels', 'data'));
    }
}
