<?php

namespace Tests\Feature;

use App\Models\Buku;
use App\Models\Kategori;
use App\Models\Penerbit;
use App\Models\Rak;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Spatie\Permission\Models\Role;

class BookTest extends TestCase
{

    protected function setUp(): void
    {
        parent::setUp(); 
        
        $this->artisan('migrate:fresh --seed');
    }

    public function test_admin_bisa_buat_buku()
    {
        Storage::fake('public');

        $admin = User::where('role_id', 1)->first(); // Gunakan admin yang ada

        $this->actingAs($admin);

        $file = UploadedFile::fake()->image('sampul.jpg'); // Simulasi file gambar

        $response = $this->post(route('books.store'), [
            'judul' => 'Buku Baru',
            'penulis' => 'Penulis Test',
            'penerbit_id' => Penerbit::first()->id,
            'kategori_id' => Kategori::first()->id,
            'rak_id' => Rak::first()->id,
            'stok' => 10,
            'deskripsi' => 'Deskripsi buku.',
            'isbn' => '1234567890',
            'sampul' => $file, // Pastikan ini berupa file
        ]);

        $response->assertRedirect(route('books.index'));
        $this->assertDatabaseHas('buku', ['judul' => 'Buku Baru']);
        Storage::disk('public')->assertExists('sampul/' . $file->hashName());
    }

    public function test_admin_bisa_edit_buku()
    {
        $admin = User::where('role_id', 1)->first(); // Gunakan admin yang ada
        $this->actingAs($admin);

        $buku = Buku::factory()->create();

        $response = $this->put(route('books.update', $buku->id), [
            'judul' => fake()->sentence(3),
            'penulis' => fake()->name(),
            'penerbit_id' => Penerbit::inRandomOrder()->first()->id,
            'kategori_id' => Kategori::inRandomOrder()->first()->id,
            'rak_id' => Rak::inRandomOrder()->first()->id,
            'stok' => fake()->numberBetween(1, 50),
            'deskripsi' => fake()->paragraph(),
            'isbn' => fake()->isbn13(),
        ]);

        $response->assertRedirect(route('books.index'));
        $this->assertDatabaseHas('buku', ['id' => $buku->id]);
    }

    public function test_admin_bisa_hapus_buku()
    {
        $admin = User::where('role_id', 1)->first();
        $this->actingAs($admin);

        $buku = Buku::factory()->create();

        $response = $this->delete(route('books.destroy', $buku->id));

        $response->assertRedirect(route('books.index'));
        $this->assertDatabaseMissing('buku', ['id' => $buku->id]);
    }

    public function test_admin_bisa_lihat_detail_buku()
    {
        $admin = User::where('role_id', 1)->first();
        $this->actingAs($admin);

        $buku = Buku::factory()->create();

        $response = $this->get(route('books.show', $buku->slug));

        $response->assertStatus(200);
        $response->assertSee($buku->judul);
    }
}
