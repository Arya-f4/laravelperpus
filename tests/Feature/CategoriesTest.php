<?php

namespace Tests\Feature;

use App\Models\Kategori;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoriesTest extends TestCase
{

    public function test_admin_bisa_lihat_halaman_kategori()
    {
        // Cek apakah ada admin, jika tidak buat admin baru
        $admin = User::where('role_id', 1)->first();
        if (!$admin) {
            $admin = User::factory()->create(['role_id' => 1]);
        }
    
        $this->actingAs($admin);
    
        $response = $this->get(route('categories.index'));
        $response->assertStatus(200);
    }
    

    public function test_admin_bisa_buat_kategori()
    {
        $admin = User::where('role_id', 1)->first(); // Gunakan admin yang ada
        $this->actingAs($admin);

        $kategoriData = Kategori::factory()->make()->toArray();

        $response = $this->post(route('categories.store'), $kategoriData);
        
        $response->assertRedirect(route('categories.index'));
        $this->assertDatabaseHas('kategori', ['nama' => $kategoriData['nama']]);
    }

    public function test_admin_bisa_edit_kategori()
    {
        $admin = User::where('role_id', 1)->first(); // Gunakan admin yang ada
        $this->actingAs($admin);

        $kategori = Kategori::factory()->create();

        $response = $this->get(route('categories.edit', $kategori->id));
        
        $response->assertStatus(200);
    }

    public function test_admin_bisa_hapus_kategori()
    {
        $admin = User::where('role_id', 1)->first(); // Gunakan admin yang ada
        $this->actingAs($admin);

        $kategori = Kategori::factory()->create();

        $response = $this->delete(route('categories.destroy', $kategori->id));
        
        $response->assertRedirect(route('categories.index'));
        $this->assertDatabaseMissing('kategori', ['id' => $kategori->id]);
    }
}
