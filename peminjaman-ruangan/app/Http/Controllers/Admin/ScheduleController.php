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
        // query dasar: hanya ambil booking yg approved
        $query = Booking::with(['room','user']);


        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function($q) use ($search) {
                // cari di tabel users
                $q->whereHas('user', function($uq) use ($search) {
                    $uq->where(function($w) use ($search) {
                        $w->where('name', 'like', "%{$search}%");
                    });
                })
                // cari di tabel rooms
                ->orWhereHas('room', function($rq) use ($search) {
                    $rq->where('nama', 'like', "%{$search}%");
                })
                // cari di tabel bookings
                ->orWhere(function($bq) use ($search) {
                    $bq->where('tanggal', 'like', "%{$search}%")
                       ->orWhere('agenda', 'like', "%{$search}%")
                       ->orWhere('jumlah_peserta', 'like', "%{$search}%")
                       ->orWhere('jam', 'like', "%{$search}%")
                       ->orWhere('jam_selesai', 'like', "%{$search}%")
                       ->orWhere('list_kebutuhan', 'like', "%{$search}%");
                });

                        // ==== tambahan khusus untuk status ====
                if (strtolower($search) === 'ditolak') {
                    $q->orWhere('status', 'rejected');
                } elseif (strtolower($search) === 'diterima') {
                    $q->orWhere('status', 'approved');
                } elseif (strtolower($search) === 'menunggu') {
                    $q->orWhere('status', 'pending');
                } else {
                    $q->orWhere('status', 'like', "%{$search}%");
                }
            });
        }


        // ambil filter
        $roomId = $request->get('room');
        $month  = $request->get('month');
        $year   = $request->get('year');


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
public function exportCsv(Request $request)
{
    $fileName = 'jadwal.csv';
    
    $schedules = Booking::with(['room','user'])
->when($request->search, function($q) use ($request) {
    $search = $request->search;
    $q->where(function($q2) use ($search) {
        $q2->whereHas('user', function($uq) use ($search) {
            $uq->where('name', 'like', "%{$search}%");
        })
        ->orWhereHas('room', function($rq) use ($search) {
            $rq->where('nama', 'like', "%{$search}%");
        })
        ->orWhere(function($bq) use ($search) {
            $bq->where('tanggal', 'like', "%{$search}%")
               ->orWhere('agenda', 'like', "%{$search}%")
               ->orWhere('jumlah_peserta', 'like', "%{$search}%")
               ->orWhere('jam', 'like', "%{$search}%")
               ->orWhere('jam_selesai', 'like', "%{$search}%")
               ->orWhere('list_kebutuhan', 'like', "%{$search}%");
        });

        // tambahan status
        if (strtolower($search) === 'ditolak') {
            $q2->orWhere('status', 'rejected');
        } elseif (strtolower($search) === 'diterima') {
            $q2->orWhere('status', 'approved');
        } elseif (strtolower($search) === 'menunggu') {
            $q2->orWhere('status', 'pending');
        } else {
            $q2->orWhere('status', 'like', "%{$search}%");
        }
    });
})

    // Filter Ruangan
    ->when($request->room, fn($q) => $q->where('room_id', $request->room))
    // Filter Bulan
    ->when($request->month, fn($q) => $q->whereMonth('tanggal', $request->month))
    // Filter Tahun
    ->when($request->year, fn($q) => $q->whereYear('tanggal', $request->year))
    ->orderBy('tanggal', 'asc') // optional: sama dengan di index()


        ->get();

    $headers = [
        "Content-type"        => "text/csv",
        "Content-Disposition" => "attachment; filename={$fileName}",
        "Pragma"              => "no-cache",
        "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
        "Expires"             => "0",
    ];

    $columns = ['Tanggal','Ruangan','Pemohon','Agenda','Peserta','Mulai','Selesai','Kebutuhan','Status'];

    $callback = function() use ($schedules, $columns) {
        $file = fopen('php://output', 'w');
        fputcsv($file, $columns, ';');

        foreach ($schedules as $s) {
            fputcsv($file, [
                $s->tanggal ? \Carbon\Carbon::parse($s->tanggal)->format('Y-m-d')  .'"' : '-',
                $s->room->nama ?? '-',
                $s->user->name ?? '-',
                $s->agenda ?? '-',
                $s->jumlah_peserta ?? '-',
                $s->jam ? \Carbon\Carbon::parse($s->jam)->format('H:i') : '-',
                $s->jam_selesai ? \Carbon\Carbon::parse($s->jam_selesai)->format('H:i') : '-',
                $s->list_kebutuhan ?? '-',
                ucfirst($s->status ?? '-')
            ], ';');
        }

        fclose($file);
    };

    return response()->stream($callback, 200, $headers);
}


}
