<?php

namespace Database\Seeders;
use App\Models\Booking;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class BookingSeeder extends Seeder
{
    public function run(): void
    {
        // contoh isi data dummy
        Booking::factory()->count(10)->create([
            'tanggal' => Carbon::today(),
        ]);

        Booking::factory()->count(5)->create([
            'tanggal' => Carbon::today()->subDays(2),
        ]);

        Booking::factory()->count(3)->create([
            'tanggal' => Carbon::today()->subMonth(),
        ]);
    }
}
