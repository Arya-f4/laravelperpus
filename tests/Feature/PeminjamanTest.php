<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Buku;
use App\Models\Peminjaman;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PeminjamanTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_request_book_loan()
    {
        $user = User::factory()->create();
        $buku = Buku::factory()->create();

        $response = $this->actingAs($user)->post('/peminjaman/request', [
            'buku_id' => $buku->id,
            'tanggal_pinjam' => now()->toDateString(),
            'tanggal_kembali' => now()->addDays(7)->toDateString(),
        ]);

        $response->assertRedirect('/my-borrowings');
        $this->assertDatabaseHas('peminjaman', [
            'user_id' => $user->id,
            'buku_id' => $buku->id,
            'status' => 0,
        ]);
    }

    /** @test */
    public function admin_can_approve_loan_request()
    {
        $admin = User::factory()->create(['idrole' => 1]); 
        $peminjaman = Peminjaman::factory()->create(['status' => 0]); 

        $response = $this->actingAs($admin)->put("/peminjaman/{$peminjaman->id}/approve");

        $response->assertRedirect();
        $this->assertDatabaseHas('peminjaman', [
            'id' => $peminjaman->id,
            'status' => 1, 
        ]);
    }

    /** @test */
    public function user_can_cancel_loan_request()
    {
        $user = User::factory()->create();
        $peminjaman = Peminjaman::factory()->create([
            'user_id' => $user->id,
            'status' => 0, 
        ]);

        $response = $this->actingAs($user)->delete("/peminjaman/{$peminjaman->id}/cancel");

        $response->assertRedirect();
        $this->assertDatabaseHas('peminjaman', [
            'id' => $peminjaman->id,
            'status' => 4, 
        ]);
    }

    /** @test */
    public function user_can_return_a_book()
    {
        $user = User::factory()->create();
        $peminjaman = Peminjaman::factory()->create([
            'user_id' => $user->id,
            'status' => 1, 
        ]);

        $response = $this->actingAs($user)->get("/peminjaman/{$peminjaman->id}/return");

        $response->assertRedirect();
        $this->assertDatabaseHas('peminjaman', [
            'id' => $peminjaman->id,
            'status' => 3, 
        ]);
    }

    /** @test */
    public function admin_can_mark_fine_as_paid()
    {
        $admin = User::factory()->create(['idrole' => 1]); 
        $peminjaman = Peminjaman::factory()->create(['status' => 2]); 
        $response = $this->actingAs($admin)->post("/denda/{$peminjaman->id}/mark-as-paid");

        $response->assertRedirect();
        $this->assertDatabaseHas('peminjaman', [
            'id' => $peminjaman->id,
            'status' => 5, 
        ]);
    }
}
