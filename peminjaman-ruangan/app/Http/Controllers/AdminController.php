<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Room;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $recentBookings = Booking::with(['user','room','role'])
            ->latest()
            ->take(6)
            ->get();

        $todayBookings = Booking::with('room')
            ->whereDate('created_at', today())
            ->orderBy('jam', 'asc')
            ->get();

        

        // KPI array
        $kpi = [
            'today'   => Booking::whereDate('created_at', today())->count(),
            'month'   => Booking::whereMonth('created_at', now()->month)->count(),
            'rooms'   => Room::count(),
            'pending' => Booking::where('status', 'pending')->count(),
        ];

        // return view('admin.dashboard', compact(
        //     'recentBookings',
        //     'todayBookings',
        //     'kpi'
        // ));
    }
}
