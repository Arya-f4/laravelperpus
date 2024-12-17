<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Denda;
use App\Models\Peminjaman;
use Illuminate\Support\Facades\DB;

class Dendaseeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $peminjamanIds = Peminjaman::pluck('id')->toArray();
        $dendas = [];
        

        foreach ($peminjamanIds as $peminjamanId) {
            $isPaid = rand(0, 1);
            $totalDenda = Peminjaman::find($peminjamanId)->total_denda;

            $dendas[] = [
                'peminjaman_id' => $peminjamanId,
                'jumlah_hari' => $totalDenda,
                'total_denda' => $totalDenda,
                'is_paid' => $isPaid,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('denda')->insert($dendas);
    }
}
