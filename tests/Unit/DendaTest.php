<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Denda;
use App\Models\Peminjaman;
use App\Models\Buku;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;


class DendaTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
public function user_can_view_fine_details()
    {
       
        $user = User::factory()->create();

       
        $buku = Buku::factory()->create();

        $peminjaman = Peminjaman::factory()->create([
            'user_id' => $user->id,
            'buku_id' => $buku->id,
        ]);

        $denda = Denda::factory()->create([
            'peminjaman_id' => $peminjaman->id,
            'jumlah_denda' => 5000,
            'status_pembayaran' => 'pending',
        ]);

        $response = $this->actingAs($user)->get(route('denda.index'));

        $response->assertStatus(200);

        $response->assertSee('Rp 5.000');
    }

    /** @test */
    public function user_can_pay_fine()
    {
        $user = User::factory()->create();
        $denda = Denda::factory()->create([
            'peminjaman_id' => Peminjaman::factory()->create(['user_id' => $user->id])->id,
            'jumlah_denda' => 10000,
            'status_pembayaran' => 'pending',
        ]);

        $response = $this->actingAs($user)->post(route('denda.pay', $denda));

        $this->assertDatabaseHas('dendas', [
            'id' => $denda->id,
            'status_pembayaran' => 'paid',
        ]);

        $response->assertRedirect(route('denda.index'));
    }
}
