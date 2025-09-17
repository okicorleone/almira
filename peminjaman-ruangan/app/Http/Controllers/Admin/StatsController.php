<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Room;
use App\Models\Ruangan;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class StatsController extends Controller
{
    public function index(Request $request)
    {
        $date  = $request->query('date');   // YYYY-MM-DD (opsional)
        $month = $request->query('month');  // 1..12
        $year  = $request->query('year');   // YYYY



        // filter tanggal spesifik
        if ($date) {
            $q->whereDate('tanggal', $date);
        }
        if ($month) {
            $q->whereMonth('tanggal', $month);
        }
        if ($year) {
            $q->whereYear('tanggal', $year);
        }

        $rooms = Room::all();
        $room = $request->input('room');
        // siapkan labels & data untuk chart
        $query = Booking::query()
            ->select('room_id', DB::raw('COUNT(*) as total'))
            ->when($year, fn($q) => $q->whereYear('tanggal', $year))
            ->when($month, fn($q) => $q->whereMonth('tanggal', $month))
            ->when($room, fn($q) => $q->where('room_id', $room))
            ->groupBy('room_id')
            ->with('room')
            ->orderBy('room_id');
        
        $result = $query->get();
            // fallback contoh ketika belum ada data
            $labels = $rooms->map(fn($row) => $row->rooms->nama ?? 'Unknown');
            $data   = $result->pluck('total');
        

        return view('admin.stats', compact('labels', 'data', 'query', 'month', 'year', 'room','rooms'));
    }
}
