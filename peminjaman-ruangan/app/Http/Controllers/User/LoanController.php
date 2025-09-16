<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Loan;
use App\Models\Room;

class LoanController extends Controller{
    public function create()
    {
        $rooms = Room::all();
        return view('user.loans.create', compact('rooms'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'room_id' => 'required|exists:rooms,id',
            'agenda' => 'required|string|max:255',
            'jumlah_peserta' => 'required|integer|min:1',
            'jam' => 'required',
            'jam_selesai' => 'required',
            'list_kebutuhan' => 'nullable|string',
        ]);

        $loan= Loan::create([
            'user_id'    => auth()->id(),
            'room_id'    => $request->room_id,
            'tanggal'    => $request->tanggal,
            'agenda'     => $request->agenda,
            'jumlah_peserta'     => $request->jumlah_peserta,
            'jam'  => $request->jam,
            'jam_selesai'=> $request->jam_selesai,
            'list_kebutuhan'  => $request->list_kebutuhan,
        ]);

        $loan->load('room');

        // === Buat notifikasi untuk semua admin ===
        $admins = \App\Models\User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            \App\Models\Notification::create([
                'user_id' => $admin->id,
                'message' => "Pengajuan pinjaman baru oleh ".auth()->user()->name.
                            " untuk ruangan ".$loan->room->nama.
                            " pada ".$loan->tanggal." (".$loan->jam." - ".$loan->jam_selesai.")",
            ]);
    }

        return redirect()->route('loans.mine')->with('ok', 'Pengajuan berhasil dikirim.');
    }

    public function mine()
    {
        $loans = Loan::with('room')
                     ->where('user_id', auth()->id())
                     ->latest()
                     ->get();

        return view('user.loans.mine', compact('loans'));
    }
}