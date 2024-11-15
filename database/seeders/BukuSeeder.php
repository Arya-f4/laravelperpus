<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BukuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'judul' => 'bintang',
                'slug' => Str::slug('bintang'),
                'sampul' => 'buku/images.jpeg',
                'penulis' => 'tere liye',
                'penerbit_id' => 2,
                'kategori_id' => 2,
                'rak_id' => 2,
                'stok' => 10,
            ],
            [
                'judul' => 'matahari',
                'slug' => Str::slug('matahari'),
                'sampul' => 'buku/images.jpeg',
                'penulis' => 'tere liye',
                'penerbit_id' => 3,
                'kategori_id' => 2,
                'rak_id' => 3,
                'stok' => 10,
            ],
            [
                'judul' => 'tentang kamu',
                'slug' => Str::slug('tentang-kamu'),
                'sampul' => 'buku/images.jpeg',
                'penulis' => 'tere liye',
                'penerbit_id' => 2,
                'kategori_id' => 2,
                'rak_id' => 4,
                'stok' => 10,
            ],
            [
                'judul' => 'gusdur',
                'slug' => Str::slug('gusdur'),
                'sampul' => 'buku/images.jpeg',
                'penulis' => 'greg borton',
                'penerbit_id' => 2,
                'kategori_id' => 3,
                'rak_id' => 7,
                'stok' => 10,
            ],
            [
                'judul' => 'habibie',
                'slug' => Str::slug('habibie'),
                'sampul' => 'buku/images.jpeg',
                'penulis' => 'raden toto sugiharto',
                'penerbit_id' => 2,
                'kategori_id' => 3,
                'rak_id' => 8,
                'stok' => 10,
            ],
            [
                'judul' => 'naruto volume 58',
                'slug' => Str::slug('naruto-volume-58'),
                'sampul' => 'buku/images.jpeg',
                'penulis' => 'masashi kishimoto',
                'penerbit_id' => 3,
                'kategori_id' => 6,
                'rak_id' => 12,
                'stok' => 10,
            ],
            [
                'judul' => 'naruto volume 71',
                'slug' => Str::slug('naruto-volume-71'),
                'sampul' => 'buku/images.jpeg',
                'penulis' => 'masashi kishimoto',
                'penerbit_id' => 3,
                'kategori_id' => 6,
                'rak_id' => 13,
                'stok' => 10,
            ]
        ];

        DB::table('buku')->insert($data);
    }
}
