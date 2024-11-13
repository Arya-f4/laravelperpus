<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TransaksiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Data 1: Insert peminjaman and detail peminjaman records
        $peminjamanId1 = DB::table('peminjaman')->insertGetId([
            'kode_pinjam' => random_int(100000000, 999999999),
            'peminjam_id' => 3,
            'petugas_pinjam' => 1,
            'petugas_kembali' => 1,
            'status' => 3,
            'denda' => 0,
            'tanggal_pinjam' => now()->subDays(20),
            'tanggal_kembali' => now()->subDays(10),
            'tanggal_pengembalian' => now()->subDays(11),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('detail_peminjaman')->insert([
            [
                'peminjaman_id' => $peminjamanId1,
                'buku_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'peminjaman_id' => $peminjamanId1,
                'buku_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Data 2
        $peminjamanId2 = DB::table('peminjaman')->insertGetId([
            'kode_pinjam' => random_int(100000000, 999999999),
            'peminjam_id' => 3,
            'petugas_pinjam' => 2,
            'status' => 2,
            'tanggal_pinjam' => now(),
            'tanggal_kembali' => now()->addDays(10),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('detail_peminjaman')->insert([
            [
                'peminjaman_id' => $peminjamanId2,
                'buku_id' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'peminjaman_id' => $peminjamanId2,
                'buku_id' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Data 3
        $peminjamanId3 = DB::table('peminjaman')->insertGetId([
            'kode_pinjam' => random_int(100000000, 999999999),
            'peminjam_id' => 4,
            'status' => 1,
            'tanggal_pinjam' => now()->addDays(10),
            'tanggal_kembali' => now()->addDays(20),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('detail_peminjaman')->insert([
            [
                'peminjaman_id' => $peminjamanId3,
                'buku_id' => 6,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'peminjaman_id' => $peminjamanId3,
                'buku_id' => 7,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Data 4
        $peminjamanId4 = DB::table('peminjaman')->insertGetId([
            'kode_pinjam' => random_int(100000000, 999999999),
            'peminjam_id' => 5,
            'status' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('detail_peminjaman')->insert([
            'peminjaman_id' => $peminjamanId4,
            'buku_id' => 3,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
