<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PenerbitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $penerbit = ['none', 'gramedia', 'erlangga'];

        $data = [];
        foreach ($penerbit as $value) {
            $data[] = [
                'nama' => $value,
                'slug' => Str::slug($value),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('penerbit')->insert($data);
    }
}
