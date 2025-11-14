<?php

namespace App\Console\Commands;

use App\Models\Loan;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ReleaseBookedRooms extends Command
{
    /**
     * Nama perintah yang akan dipanggil di scheduler
     */
    protected $signature = 'rooms:release-booked';

    /**
     * Deskripsi perintah
     */
    protected $description = 'Ubah status ruangan menjadi tersedia kembali setelah jam peminjaman selesai';

    /**
     * Jalankan perintah
     */
    public function handle()
    {
        // Ambil semua loan yang sudah selesai tapi ruangan masih booked
        $now = Carbon::now();

        $expiredLoans = Loan::where('status', 'approved')
            ->where('tanggal', '<=', $now->toDateString())
            ->where('jam_selesai', '<=', $now->format('H:i:s'))
            ->get();

        $count = 0;

        foreach ($expiredLoans as $loan) {
            $room = $loan->room;
            if ($room && $room->status === 'booked') {
                $room->update(['status' => 'tersedia']);
                $count++;
            }
        }

        $this->info("✅ {$count} ruangan berhasil diubah menjadi tersedia kembali.");

        return 0;
    }
}