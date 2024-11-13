<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RakSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Initial entry
        DB::table('rak')->insert([
            'rak' => 0,
            'baris' => 0,
            'kategori_id' => 1,
            'slug' => '0',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Entries for rak 1
        $data = [];
        for ($i = 1; $i <= 5; $i++) {
            $data[] = [
                'rak' => 1,
                'baris' => $i,
                'kategori_id' => 2,
                'slug' => '1-' . $i,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        DB::table('rak')->insert($data);

        // Entries for rak 2
        $data = [];
        for ($i = 1; $i <= 5; $i++) {
            $data[] = [
                'rak' => 2,
                'baris' => $i,
                'kategori_id' => 3,
                'slug' => '2-' . $i,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        DB::table('rak')->insert($data);

        // Entries for rak 3
        $data = [];
        for ($i = 1; $i <= 5; $i++) {
            $data[] = [
                'rak' => 3,
                'baris' => $i,
                'kategori_id' => 6,
                'slug' => '3-' . $i,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        DB::table('rak')->insert($data);
    }
}
