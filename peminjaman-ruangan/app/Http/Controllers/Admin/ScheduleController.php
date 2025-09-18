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
}
