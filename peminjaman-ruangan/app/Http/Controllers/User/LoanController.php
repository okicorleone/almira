<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Loan;
use App\Models\Room;

class LoanController extends Controller
{
    public function create()
    {
        $rooms = Room::orderBy('nama')->get();
        return view('user.loans.create', compact('rooms'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'room_id' => ['required','exists:rooms,id'],
            'start'   => ['required','date'],
            'end'     => ['required','date','after:start'],
            'note'    => ['nullable','string','max:255'],
        ]);

        $data['user_id'] = auth()->id();
        $data['status']  = 'pending';

        Loan::create($data);

        return redirect()->route('loans.mine')->with('ok','Pengajuan berhasil dibuat.');
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
