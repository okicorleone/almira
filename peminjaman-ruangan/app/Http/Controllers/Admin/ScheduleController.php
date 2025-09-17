<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Room;

class ScheduleController extends Controller
{
    public function index(Request $request)
    {
        // ambil filter
        $roomId = $request->get('room');
        $month  = $request->get('month');
        $year   = $request->get('year');

        // query dasar: hanya ambil booking yg approved
        $query = Booking::with(['room','user'])
            ->where('status', 'approved');

        // filter ruangan
        if ($roomId) {
            $query->where('room_id', $roomId);
        }

        // filter bulan
        if ($month) {
            $query->whereMonth('tanggal', $month);
        }

        // filter tahun
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
