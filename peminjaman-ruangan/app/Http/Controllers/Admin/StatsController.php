<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Room;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class StatsController extends Controller
{
    public function index(Request $request)
    {
        $date  = $request->query('date');   // YYYY-MM-DD (opsional)
        $month = $request->query('month');  // 1..12
        $year  = $request->query('year');   // YYYY

        $q = Booking::query()->select('room_id', DB::raw('COUNT(*) as total'))
                ->with('room');

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

        $rows = $q->groupBy('room_id')
                  ->orderBy('room_id')
                  ->get();

        // siapkan labels & data untuk chart
        if ($rows->isNotEmpty()) {
            $labels = $rows->map(fn($r) => optional($r->room)->nama ?? "Room #{$r->room_id}")->values();
            $data   = $rows->map(fn($r) => (int)$r->total)->values();
        } else {
            // fallback contoh ketika belum ada data
            $labels = ['Ruangan 1','Ruangan 2','Ruangan 3','Ruangan 4','Ruangan 5','Ruangan 6'];
            $data   = [4,24,29,22,13,50];
        }

        return view('admin.stats', compact('labels', 'data'));
    }
}
