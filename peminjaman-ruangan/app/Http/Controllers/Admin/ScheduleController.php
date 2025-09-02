<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;   // model booking (kalau tabelnya ada)
use App\Models\Room;      // model ruangan
use Carbon\Carbon;

class ScheduleController extends Controller
{
    public function index(Request $request)
    {
        // ambil filter
        $roomId = $request->get('room');
        $month  = $request->get('month');
        $year   = $request->get('year');

        // query dasar
        $query = Booking::with('room');

        if ($roomId) {
            $query->where('room_id', $roomId);
        }
        if ($month) {
            $query->whereMonth('tanggal', $month);
        }
        if ($year) {
            $query->whereYear('tanggal', $year);
        }

        // ambil data
        $schedules = $query->orderBy('tanggal', 'asc')->get();

        // list ruangan untuk filter
        $rooms = Room::all();

        return view('admin.schedule', compact('schedules', 'rooms'));
    }
}
