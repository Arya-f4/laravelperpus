<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role; // Tambahkan ini
use Tests\TestCase;

class UsersTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        // Jalankan migrate fresh dan seed sebelum setiap test
        $this->artisan('migrate:fresh --seed');
    }

    public function test_dapat_menampilkan_halaman_daftar_pengguna()
    {
        // Pastikan role admin tidak dibuat dua kali
        $role = Role::where('name', 'admin')->where('guard_name', 'web')->first();
        if (!$role) {
            $role = Role::create(['name' => 'admin', 'guard_name' => 'web']);
        }

        // Buat pengguna admin
        $admin = User::factory()->create([
            'role_id' => $role->id,
        ]);
        $admin->assignRole('admin');

        // Login sebagai admin
        $this->actingAs($admin);

        // Akses halaman daftar pengguna
        $response = $this->get('/admin/users/all');

        // Pastikan halaman bisa diakses (HTTP 200)
        $response->assertStatus(200);
    }


    public function test_dapat_menambah_pengguna_baru()
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'role_id' => 2
        ]);

        // Periksa apakah ada error validasi
        $response->assertSessionHasNoErrors();

        // Pastikan pengguna terautentikasi
        $this->assertAuthenticated();
    }

    public function test_dapat_mengupdate_pengguna()
    {
        // Buat user dengan role admin
        $admin = User::factory()->create(['role_id' => 1]);

        // Buat user lain yang akan diupdate
        $user = User::factory()->create();

        // Login sebagai admin
        $this->actingAs($admin);

        // Data update
        $updateData = [
            'name' => 'Nama Baru',
            'email' => 'newemail@example.com',
            'role_id' => $user->role_id, // Tambahkan ini
        ];        

        // Kirim request PUT ke route update
        $response = $this->put(route('users.update', ['id' => $user->id]), $updateData);

        // Pastikan user yang diupdate memiliki nama baru
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Nama Baru',
        ]);

        // Pastikan respons redirect
        $response->assertRedirect();
    }
    
    public function test_dapat_menghapus_pengguna()
    {
        // Buat pengguna admin (pastikan memiliki role)
        $admin = User::factory()->create(['role_id' => 1]);
        $user = User::factory()->create();

        // Login sebagai admin
        $this->actingAs($admin);

        // Kirim request DELETE
        $response = $this->delete(route('users.destroy', $user->id));

        // Pastikan pengguna telah dihapus dari database
        $this->assertDatabaseMissing('users', ['id' => $user->id]);

        // Pastikan respons mengarah ke halaman sebelumnya
        $response->assertRedirect();
    }
}
