<?php

namespace Database\Factories;

use App\Models\Buku;
use App\Models\Kategori;
use App\Models\Penerbit;
use App\Models\Rak;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Buku>
 */
class BukuFactory extends Factory
{
    protected $model = Buku::class;

    public function definition()
    {
        Storage::fake('public'); // Gunakan storage palsu untuk testing
        $file = UploadedFile::fake()->image('sampul.jpg'); // Buat file gambar palsu

        return [
            'judul' => $this->faker->sentence(3),
            'penulis' => $this->faker->name(),
            'penerbit_id' => Penerbit::inRandomOrder()->first()?->id ?? Penerbit::factory(),
            'kategori_id' => Kategori::inRandomOrder()->first()?->id ?? Kategori::factory(),
            'rak_id' => Rak::inRandomOrder()->first()?->id ?? Rak::factory(),
            'stok' => $this->faker->numberBetween(1, 50),
            'deskripsi' => $this->faker->paragraph(),
            'isbn' => $this->faker->isbn10(),
            'sampul' => $file->store('sampul', 'public'),
            'slug' => fn (array $attributes) => Str::slug($attributes['judul']),
        ];
    }
}
