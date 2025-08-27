<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Ambil 5 peminjaman terbaru
        $recentBookings = Booking::with(['user', 'room'])
            ->latest()
            ->take(5)
            ->get();

        // Jadwal hari ini
        $todayBookings = Booking::with('room')
            ->whereDate('created_at', Carbon::today())
            ->get();

        // KPI (contoh hitungan sederhana)
        $kpi = [
            'today'    => Booking::whereDate('created_at', Carbon::today())->count(),
            'month'    => Booking::whereMonth('created_at', Carbon::now()->month)->count(),
            'rooms'    => Room::count(),
            'pending'  => Booking::where('status', 'pending')->count(),
        ];

        return view('admin.dashboard', compact('recentBookings', 'todayBookings', 'kpi'));
    }
}
