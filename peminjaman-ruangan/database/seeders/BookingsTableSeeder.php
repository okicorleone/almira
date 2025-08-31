<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BookingsTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('bookings')->insert([
            [
                'tanggal' => now()->toDateString(),
                'user_id' => 3,
                'room_id' => 1,
                'agenda' => 'Rapat Proyek A',
                'jam' => '10:00:00',
                'status' => 'approved',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tanggal' => now()->toDateString(),
                'user_id' => 4,
                'room_id' => 4,
                'agenda' => 'Presentasi Produk',
                'jam' => '14:00:00',
                'status' => 'pending',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tanggal' => now()->toDateString(),
                'user_id' => 3,
                'room_id' => 1,
                'agenda' => 'Rapat Proyek A',
                'jam' => '10:00:00',
                'status' => 'approved',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tanggal' => now()->toDateString(),
                'user_id' => 4,
                'room_id' => 4,
                'agenda' => 'Presentasi Produk',
                'jam' => '14:00:00',
                'status' => 'pending',
                'created_at' => now(),
                'updated_at' => now(),
            ],            
            [
                'tanggal' => now()->toDateString(),
                'user_id' => 3,
                'room_id' => 1,
                'agenda' => 'Rapat Proyek A',
                'jam' => '10:00:00',
                'status' => 'approved',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tanggal' => now()->toDateString(),
                'user_id' => 4,
                'room_id' => 4,
                'agenda' => 'Presentasi Produk',
                'jam' => '14:00:00',
                'status' => 'pending',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
