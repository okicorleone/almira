<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Ruangan;
use App\Models\Booking;
use App\Models\Room;
use Carbon\Carbon;


class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $year = $request->input('year');
        $month = $request->input('month');
        $room = $request->input('room');
        
        $rooms = Room::query()
            ->orderBy('id', 'asc')
            ->get();
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

        // Ambil 5 peminjaman terbaru
        $recentBookings = Booking::with(['user', 'room'])
            ->latest()
            ->take(5)
            ->get();

        // Jadwal hari ini
        $todayBookings = Booking::with('room')
            ->whereDate('tanggal', today())
            ->orderBy('jam', 'asc')
            ->get();

        $todayCount = Booking::whereDate('created_at', Carbon::today())->count();
        $monthCount = Booking::whereMonth('tanggal', Carbon::now()->month)->count();
        $pendingRequests = Booking::where('status', 'pending')->count();
        $rooms = Room::all();
        $availableRoomList = Room::where('status', 'tersedia')->pluck('nama')->toArray();
        $bookedRoomList = Room::where('status', 'booked')->pluck('nama')->toArray();
        $bookedToday = Booking::whereDate('tanggal', today())
            ->where('status', 'approved')
            ->pluck('room_id');

        $availableRooms = Room::where('status', 'tersedia')
            ->whereNotIn('id', $bookedToday)
            ->count();

        return view('admin.dashboard', compact('recentBookings', 'pendingRequests',
        'todayBookings', 'todayCount', 'monthCount', 'availableRooms', 'labels', 'data', 'query','month', 'year', 'room','rooms', 'availableRoomList', 'bookedRoomList', 'bookedToday'));
    }

    
    public function latestNotifications()
    {
        // Permintaan terbaru (status pending)
        $latestRequest = Booking::with(['user','room'])
            ->where('status', 'pending')
            ->latest()
            ->first();

        // Jadwal terdekat (setelah waktu sekarang)
        $nearestSchedule = Booking::with('room')
            ->where('status', 'approved')
            ->where('tanggal', Carbon::today())
            ->where('jam', '>=', Carbon::now()->format('H:i:s'))
            ->orderBy('jam', 'asc')
            ->first();

        // Helper: hitung selisih waktu
        // if ($latestRequest && $latestRequest->booking) {
        //     $timeDiff = \Carbon\Carbon::parse($latestRequest->booking->created_at)
        //                 ->diffForHumans(); // atau format('d M Y H:i')
        // } else {
        //     $timeDiff = null;
        // }


        return response()->json([
            'latestRequest' => $latestRequest ? [
                'pemohon' => $latestRequest->user->name ?? 'Unknown',
                'ruangan' => $latestRequest->room->nama ?? 'Unknown',
                'agenda'  => $latestRequest->agenda,
                'waktu'   => Carbon::parse($latestRequest->created_at)->diffForHumans(),
            ] : null,

            'nearestSchedule' => $nearestSchedule ? [
                'ruangan' => $nearestSchedule->room->nama ?? 'Unknown',
                'agenda'  => $nearestSchedule->agenda,
                'countdown' => Carbon::parse($nearestSchedule->jam)->diffForHumans(),
            ] : null,
        ]);
    }
}

        // KPI (contoh hitungan sederhana)
        // $kpi = [
        //     'today'    => Booking::whereDate('created_at', Carbon::today())->count(),
        //     'month'    => Booking::whereMonth('created_at', Carbon::now()->month)->count(),
        //     'rooms'    => Room::count(),

        //     'pending'  => Booking::where('status', 'pending')->count(), test
        // ];

                // // Ambil pemakaian ruangan bulan ini
        // $roomUsage = Booking::select('room_id',DB::raw('COUNT(*) as total'))
        // ->whereMonth('created_at', now()->month)
        // ->groupBy('room_id')
        // ->with('room')
        // ->get();