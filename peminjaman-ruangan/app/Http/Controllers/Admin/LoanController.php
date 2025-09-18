<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking; // atau Loan jika kamu pakai model Loan
use App\Models\Room;
use App\Models\Notification;

class LoanController extends Controller
{
    public function index(Request $request)
    {
        $query = Booking::with(['room','user'])
            ->where('status', 'pending');

        // ====== Filter pencarian ======
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function($q) use ($search) {
                // cari di tabel users
                $q->whereHas('user', function($uq) use ($search) {
                    $uq->where(function($w) use ($search) {
                        $w->where('name', 'like', "%{$search}%")
                          ->orWhere('role', 'like', "%{$search}%");
                    });
                })
                // cari di tabel rooms
                ->orWhereHas('room', function($rq) use ($search) {
                    $rq->where('nama', 'like', "%{$search}%");
                })
                // cari di tabel bookings
                ->orWhere(function($bq) use ($search) {
                    $bq->where('created_at', 'like', "%{$search}%")
                       ->orWhere('tanggal', 'like', "%{$search}%")
                       ->orWhere('agenda', 'like', "%{$search}%")
                       ->orWhere('jumlah_peserta', 'like', "%{$search}%")
                       ->orWhere('jam', 'like', "%{$search}%")
                       ->orWhere('jam_selesai', 'like', "%{$search}%")
                       ->orWhere('list_kebutuhan', 'like', "%{$search}%");
                });
            });
        }

        // ====== Filter tambahan ======
        $roomId = $request->get('room');
        $month  = $request->get('month');
        $year   = $request->get('year');

        if ($roomId) {
            $query->where('room_id', $roomId);
        }

        if ($month) {
            $query->whereMonth('tanggal', $month);
        }

        if ($year) {
            $query->whereYear('tanggal', $year);
        }

        // ====== Ambil data ======
        $loans = $query->orderBy('created_at','desc')->get();

        // list ruangan untuk dropdown filter
        $rooms = Room::all();

        return view('admin.loans', compact('loans','rooms'));
    }

    public function approve(\App\Models\Booking $loan)
    {
        $loan->update(['status' => 'approved']);

        Notification::create([
            'user_id' => $loan->user_id,
            'message' => "Booking kamu untuk ruangan {$loan->room->nama} telah disetujui.",
        ]);

        return redirect()->route('admin.loans.index')->with('success', 'Pinjaman berhasil diterima');
    }

    public function reject(\App\Models\Booking $loan)
    {
        $loan->update(['status' => 'rejected']);

        Notification::create([
            'user_id' => $loan->user_id,
            'message' => "Booking kamu untuk ruangan {$loan->room->nama} ditolak.",
        ]);

        return redirect()->route('admin.loans.index')->with('success', 'Pinjaman berhasil ditolak');
    }
}
