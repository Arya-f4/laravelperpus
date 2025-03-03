<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Rak;
use App\Models\Kategori;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RakTest extends TestCase
{
    public function test_admin_bisa_mengakses_halaman_rak()
    {
        $admin = User::factory()->create(['role_id' => 1]);
        $this->actingAs($admin);

        $response = $this->get(route('racks.index'));

        $response->assertStatus(200);
    }

    public function test_user_biasa_tidak_bisa_mengakses_halaman_rak()
    {
        $user = User::factory()->create(['role_id' => 2]);
        $this->actingAs($user);

        $response = $this->get(route('racks.index'));

        $response->assertStatus(403);
    }

    public function test_guest_tidak_bisa_mengakses_halaman_rak()
    {
        $response = $this->get(route('racks.index'));

        $response->assertRedirect(route('login'));
    }

    public function test_admin_bisa_menambah_rak()
    {
        $admin = User::factory()->create(['role_id' => 1]);
        $this->actingAs($admin);

        $kategori = Kategori::factory()->create([
            'nama' => 'Elektronik',
            'slug' => 'elektronik'
        ]);

        $response = $this->post(route('racks.store'), [
            'rak' => 'Rak A',
            'baris' => 3,
            'kategori_id' => $kategori->id, 
            'slug' => 'rak-a'
        ]);

        $response->assertRedirect(route('racks.index'));
        $this->assertDatabaseHas('rak', ['rak' => 'Rak A']);
    }


    public function test_admin_tidak_bisa_menambah_rak_dengan_nama_kosong()
    {
        $admin = User::factory()->create(['role_id' => 1]);
        $this->actingAs($admin);

        $response = $this->post(route('racks.store'), [
            'rak' => '',
            'baris' => 3,
            'slug' => 'rak-a',
        ]);

        $response->assertSessionHasErrors(['rak']);
    }

    public function test_admin_bisa_mengupdate_rak()
    {
        $admin = User::factory()->create(['role_id' => 1]);
        $this->actingAs($admin);

        $kategori = new Kategori();
        $kategori->nama = 'Elektronik';
        $kategori->slug = 'elektronik';
        $kategori->save();

        $rak = new Rak();
        $rak->rak = 'Rak A';
        $rak->baris = 3;
        $rak->slug = 'rak-a';
        $rak->kategori_id = $kategori->id;
        $rak->save();

        $response = $this->put(route('racks.update', $rak->id), [
            'rak' => 'Rak B',
            'baris' => 4,
            'kategori_id' => $kategori->id,
            'slug' => 'rak-b',
        ]);

        $response->assertRedirect(route('racks.index'));
        $this->assertDatabaseHas('rak', ['rak' => 'Rak B']);
    }

    public function test_admin_bisa_menghapus_rak()
    {
        $admin = User::factory()->create(['role_id' => 1]);
        $this->actingAs($admin);

        $kategori = new Kategori();
        $kategori->nama = 'Elektronik';
        $kategori->slug = 'Elektronik';
        $kategori->save();

        $rak = new Rak();
        $rak->rak = 'Rak A';
        $rak->baris = 3;
        $rak->slug = 'rak-a';
        $rak->kategori_id = $kategori->id;
        $rak->save();

        $response = $this->delete(route('racks.destroy', $rak->id));

        $response->assertRedirect(route('racks.index'));
        $this->assertDatabaseMissing('rak', ['id' => $rak->id]);
    }
}
