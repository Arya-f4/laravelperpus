<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Penerbit;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PublisherTest extends TestCase
{
    public function test_admin_bisa_mengakses_halaman_publisher()
    {
        // Inisialisasi user admin
        $admin = User::factory()->create(['role_id' => 1]);

        // Login sebagai admin
        $this->actingAs($admin);

        // Akses halaman publisher
        $response = $this->get(route('publishers.index'));

        // Pastikan statusnya 200 OK
        $response->assertStatus(200);
    }

    public function user_biasa_tidak_bisa_mengakses_halaman_publisher()
    {
        // Inisialisasi user biasa
        $user = User::factory()->create(['role_id' => 2]);

        // Login sebagai user biasa
        $this->actingAs($user);

        // Akses halaman publisher
        $response = $this->get(route('publishers.index'));

        // Harusnya diarahkan ke halaman lain (403 Forbidden atau Redirect)
        $response->assertStatus(403);
    }

    public function guest_tidak_bisa_mengakses_halaman_publisher()
    {
        // Tanpa login
        $response = $this->get(route('publishers.index'));

        // Harus redirect ke halaman login
        $response->assertRedirect(route('login'));
    }

    public function test_admin_bisa_menambah_publisher()
    {
        // Inisialisasi admin
        $admin = User::factory()->create(['role_id' => 1]);

        // Login sebagai admin
        $this->actingAs($admin);

        // Simpan publisher baru
        $response = $this->post(route('publishers.store'), [
            'nama' => 'Tech Books',
        ]);

        // Harus redirect ke halaman index
        $response->assertRedirect(route('publishers.index'));

        // Pastikan publisher tersimpan di database
        $this->assertDatabaseHas('penerbit', ['nama' => 'Tech Books']);
    }

    public function test_admin_tidak_bisa_menambah_publisher_dengan_nama_kosong()
    {
        // Inisialisasi admin
        $admin = User::factory()->create(['role_id' => 1]);

        // Login sebagai admin
        $this->actingAs($admin);

        // Simpan publisher baru tanpa nama
        $response = $this->post(route('publishers.store'), [
            'nama' => '',
        ]);

        // Pastikan validasi gagal
        $response->assertSessionHasErrors(['nama']);
    }

    public function test_admin_bisa_mengupdate_publisher()
    {
        // Inisialisasi admin dan publisher
        $admin = User::factory()->create(['role_id' => 1]);
        $publisher = Penerbit::create([
            'nama' => 'Lorem Ipsum',
            'slug' => 'lorem_ipsum'
        ]);

        // Login sebagai admin
        $this->actingAs($admin);

        // Update publisher
        $response = $this->put(route('publishers.update', $publisher->id), [
            'nama' => 'New Name',
        ]);

        // Harus redirect ke index
        $response->assertRedirect(route('publishers.index'));

        // Pastikan nama berubah
        $this->assertDatabaseHas('penerbit', ['nama' => 'New Name']);
    }

    public function test_admin_bisa_menghapus_publisher()
    {
        // Inisialisasi admin dan publisher
        $admin = User::factory()->create(['role_id' => 1]);
        $publisher = Penerbit::create([
            'nama' => 'Lorem Ipsum',
            'slug' => 'lorem_ipsum'
        ]);

        // Login sebagai admin
        $this->actingAs($admin);

        // Hapus publisher
        $response = $this->delete(route('publishers.destroy', $publisher->id));

        // Harus redirect ke index
        $response->assertRedirect(route('publishers.index'));

        // Pastikan publisher dihapus dari database
        $this->assertDatabaseMissing('penerbit', ['id' => $publisher->id]);
    }
}
