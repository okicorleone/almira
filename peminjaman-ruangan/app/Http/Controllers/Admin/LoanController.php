<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking; // atau Loan jika kamu pakai model Loan
use App\Models\Room;


class LoanController extends Controller
{
    public function index(Request $request)
    {
        $query = Booking::with(['room','user'])
            ->where('status', 'pending');
        // filter pencarian
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function($q) use ($search) {
            // cari di tabel users (nama user)
            $q->whereHas('user', function($uq) use ($search) {
                $uq->where(function($w) use ($search) {
                    $w->where('name', 'like', "%{$search}%")
                    ->orWhere('role', 'like', "%{$search}%");
                });
            })
            // cari di tabel rooms (nama, lantai, deskripsi ruangan)
            ->orWhereHas('room', function($rq) use ($search) {
                $rq->where('nama', 'like', "%{$search}%");
            })
            // cari di tabel bookings langsung
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
        
        $rooms = $query->get();

        $loans = $query
        ->with(['user','room'])
        ->orderBy('created_at','desc')
        ->get();

        return view('admin.loans', compact('loans','rooms'));

    }

    public function approve(\App\Models\Booking $loan)
    {
        $loan->update(['status' => 'approved']);
        return redirect()->route('admin.loans.index')->with('success', 'Pinjaman berhasil diterima');
    }

    public function reject(\App\Models\Booking $loan)
    {
        $loan->update(['status' => 'rejected']);
        return redirect()->route('admin.loans.index')->with('success', 'Pinjaman berhasil ditolak');
    }


    // public function update(Request $request, Room $room ,Booking $loan)
    // {
    //     $request->validate([
    //         'nama' => 'required|string|max:255',
    //         'lantai' => 'required|integer',
    //         'deskripsi' => 'nullable|string',
    //     ]);

    //     $room->update($request->only(['nama','lantai','deskripsi']));

    //     return redirect()->route('admin.rooms.index')->with('success', 'Ruangan berhasil diperbarui');
    // }
}
