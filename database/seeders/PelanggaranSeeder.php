<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class PelanggaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kendaraan = ['Motor', 'Mobil'];
        for ($i = 1; $i <= 100; $i++) {
            DB::table('pelanggaran')->insert([
                'jenis_kendaraan'   => $kendaraan[array_rand($kendaraan)],
                'image'             => 'uploads/dummy_' . Str::random(6) . '.jpg',
                'created_at'        => now(),
                'updated_at'        => now(),
            ]);
        }
    }
}
