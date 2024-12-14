<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PeminjamanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create('id_ID');

        for ($i = 0; $i < 100; $i++) {
            // Generate dates for borrowing, due, and return
            $tanggal_pinjam = $faker->dateTimeBetween('-6 months', '-2 week');
            $tanggal_kembali = Carbon::parse($tanggal_pinjam)->addDays(10);
            $tanggal_pengembalian = Carbon::parse($tanggal_pinjam)->addDays(9);

            // Insert new user (peminjam)
            $userId = DB::table('users')->insertGetId([
                'name' => $faker->name(),
                'email' => $faker->email(),
                'password' => Hash::make('123123123'),
                'role_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Insert peminjaman record
            $peminjamanId = DB::table('peminjaman')->insertGetId([
                'kode_pinjam' => random_int(100000000, 999999999),
                'peminjam_id' => $userId,
                'petugas_pinjam' => random_int(1, 2),
                'petugas_kembali' => random_int(1, 2),
                'denda' => 0,
                'status' => 3,
                'tanggal_pinjam' => $tanggal_pinjam,
                'tanggal_kembali' => $tanggal_kembali,
                'tanggal_pengembalian' => $tanggal_pengembalian,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Insert detail peminjaman record
            DB::table('detail_peminjaman')->insert([
                'peminjaman_id' => $peminjamanId,
                'buku_id' => random_int(1, 7),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
