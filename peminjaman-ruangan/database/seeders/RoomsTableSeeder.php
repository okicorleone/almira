<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoomsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('rooms')->insert([
            [
                'nama' => 'Ruang Rapat 1',
                'lantai' => 1,
                'deskripsi' => 'Kapasitas 20 orang, dilengkapi proyektor dan AC',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Ruang Seminar',
                'lantai' => 2,
                'deskripsi' => 'Kapasitas 100 orang, dilengkapi sound system dan kursi lipat',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Ruang Kelas 3A',
                'lantai' => 3,
                'deskripsi' => 'Kapasitas 40 orang, whiteboard dan AC',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
