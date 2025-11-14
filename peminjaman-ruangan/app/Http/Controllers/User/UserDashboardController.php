<?php
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\Loan; // asumsi tabel peminjaman ruangan
use Carbon\Carbon;
use Illuminate\Http\Request;

class UserDashboardController extends Controller
{
    public function index(Request $request)
    {
        $month = $request->input('month', now()->month);
        $year = $request->input('year', now()->year);
        $roomId = $request->input('room_id');

        // ambil semua ruangan
        $rooms = Room::all();


        $loans = Loan::where('status', 'approved')
            ->orderBy('tanggal', 'asc')
            ->whereYear('tanggal', $year)
            ->whereMonth('tanggal', $month)
            ->when($roomId, fn($q) => $q->where('room_id', $roomId))
            ->get();

        return view('user.dashboard', [
            'rooms' => $rooms,
            'loans' => $loans,
            'month' => $month,
            'year' => $year
        ]);
    }
}
