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
    // Test apakah admin bisa membuat buku baru
    public function test_admin_bisa_buat_buku()
    {
        Storage::fake('public'); // Simulasi penyimpanan file di disk 'public'

        // Menggunakan admin yang sudah ada di database
        $admin = User::where('role_id', 1)->first(); 
        $this->actingAs($admin); // Menjalankan test sebagai admin

        // Simulasi file gambar untuk sampul buku
        $file = UploadedFile::fake()->image('sampul.jpg'); 

        // Mengirim permintaan POST untuk menambahkan buku baru
        $response = $this->post(route('books.store'), [
            'judul' => 'Buku Baru',
            'penulis' => 'Penulis Test',
            'penerbit_id' => Penerbit::first()->id, // Ambil penerbit pertama dari database
            'kategori_id' => Kategori::first()->id, // Ambil kategori pertama dari database
            'rak_id' => Rak::first()->id, // Ambil rak pertama dari database
            'stok' => 10,
            'deskripsi' => 'Deskripsi buku.',
            'isbn' => '1234567890',
            'sampul' => $file, // Upload file sampul
        ]);

        // Memastikan setelah menyimpan buku, diarahkan ke halaman daftar buku
        $response->assertRedirect(route('books.index'));

        // Memastikan buku benar-benar tersimpan di database
        $this->assertDatabaseHas('buku', ['judul' => 'Buku Baru']);

        // Memastikan file sampul tersimpan di storage
        Storage::disk('public')->assertExists('sampul/' . $file->hashName());
    }

    // Test apakah admin bisa mengedit buku yang ada
    public function test_admin_bisa_edit_buku()
    {
        // Menggunakan admin yang sudah ada
        $admin = User::where('role_id', 1)->first();
        $this->actingAs($admin); // Menjalankan test sebagai admin

        // Membuat data buku baru menggunakan factory
        $buku = Buku::factory()->create();

        // Mengirim permintaan PUT untuk memperbarui data buku
        $response = $this->put(route('books.update', $buku->id), [
            'judul' => fake()->sentence(3), // Judul baru secara acak
            'penulis' => fake()->name(), // Penulis baru secara acak
            'penerbit_id' => Penerbit::inRandomOrder()->first()->id, // Penerbit acak
            'kategori_id' => Kategori::inRandomOrder()->first()->id, // Kategori acak
            'rak_id' => Rak::inRandomOrder()->first()->id, // Rak acak
            'stok' => fake()->numberBetween(1, 50), // Stok acak
            'deskripsi' => fake()->paragraph(), // Deskripsi acak
            'isbn' => fake()->isbn13(), // ISBN acak
        ]);

        // Memastikan setelah update diarahkan ke halaman daftar buku
        $response->assertRedirect(route('books.index'));

        // Memastikan data buku telah diperbarui di database
        $this->assertDatabaseHas('buku', ['id' => $buku->id]);
    }

    // Test apakah admin bisa menghapus buku
    public function test_admin_bisa_hapus_buku()
    {
        // Menggunakan admin yang sudah ada
        $admin = User::where('role_id', 1)->first();
        $this->actingAs($admin); // Menjalankan test sebagai admin

        // Membuat buku baru
        $buku = Buku::factory()->create();

        // Mengirim permintaan DELETE untuk menghapus buku
        $response = $this->delete(route('books.destroy', $buku->id));

        // Memastikan setelah penghapusan diarahkan ke halaman daftar buku
        $response->assertRedirect(route('books.index'));

        // Memastikan buku benar-benar terhapus dari database
        $this->assertDatabaseMissing('buku', ['id' => $buku->id]);
    }

    // Test apakah admin bisa melihat detail buku
    public function test_admin_bisa_lihat_detail_buku()
    {
        // Menggunakan admin yang sudah ada
        $admin = User::where('role_id', 1)->first();
        $this->actingAs($admin); // Menjalankan test sebagai admin

        // Membuat buku baru
        $buku = Buku::factory()->create();

        // Mengakses halaman detail buku berdasarkan slug buku
        $response = $this->get(route('books.show', $buku->slug));

        // Memastikan halaman dapat diakses dengan status 200 (OK)
        $response->assertStatus(200);

        // Memastikan judul buku muncul di halaman detail
        $response->assertSee($buku->judul);
    }
}

