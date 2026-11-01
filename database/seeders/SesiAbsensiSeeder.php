<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SesiAbsensiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('sesi_absensi')->insert([
            [
                'id_sesi'    => 1,
                'nama_sesi'  => 'Sesi Pagi (Masuk)',
                'jam_buka'   => '06:30:00',
                'jam_tutup'  => '08:00:00',
                'is_active'  => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_sesi'    => 2,
                'nama_sesi'  => 'Sesi Istirahat 1',
                'jam_buka'   => '09:30:00',
                'jam_tutup'  => '10:15:00',
                'is_active'  => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_sesi'    => 3,
                'nama_sesi'  => 'Sesi Istirahat 2',
                'jam_buka'   => '12:00:00',
                'jam_tutup'  => '13:00:00',
                'is_active'  => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}