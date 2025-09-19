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
        $day  = $request->query('DD');   // YYYY-MM-DD (opsional)
        $month = $request->query('month');  // 1..12
        $year  = $request->query('year');   // YYYY

$query = Booking::query();

if ($request->filled('day')) {
    $query->whereDay('tanggal', $request->day);
}

if ($request->filled('month')) {
    $query->whereMonth('tanggal', $request->month);
}

if ($request->filled('year')) {
    $query->whereYear('tanggal', $request->year);
}

$bookings = $query->get();


        $rooms = Room::query()
            ->orderBy('id', 'asc')
            ->get();
      
        $room = $request->input('room');
        // siapkan labels & data untuk chart
        $query = Room::query()
            ->select('rooms.id as room_id', DB::raw('COUNT(bookings.id) as total'))
            ->leftJoin('bookings', function ($join) use ($year, $month) {
                $join->on('rooms.id', '=', 'bookings.room_id')
                    ->where('bookings.status', 'approved');

                if ($year) {
                    $join->whereYear('bookings.tanggal', $year);
                }

                if ($month) {
                    $join->whereMonth('bookings.tanggal', $month);
                }
            })
            ->when($room, fn($q) => $q->where('rooms.id', $room))
            ->groupBy('rooms.id')
            ->orderBy('rooms.id');
        
        $result = $query->get();
            // fallback contoh ketika belum ada data
            $labels = $rooms->map(fn($row) => $row->nama ?? 'Unknown');
            $data   = $result->pluck('total');

            
        

        return view('admin.stats', compact('labels', 'data', 'query', 'month', 'year', 'room','rooms'));
    }
}
