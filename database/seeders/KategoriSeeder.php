<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $kategori = ['none', 'novel', 'sejarah', 'religi', 'biografi', 'komik'];

        $data = [];
        foreach ($kategori as $value) {
            $data[] = [
                'nama' => $value,
                'slug' => Str::slug($value),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('kategori')->insert($data);
    }
}
