<?php

namespace Tests\Feature;

use App\Models\Buku;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;


    test('user can create book', function () {
        $this->actingAs($this->user);

        $data = Buku::factory()->make()->toArray();
        
        $response = $this->post(route('books.store'), $data);
        
        $response->assertRedirect(route('books.index'));
        $this->assertDatabaseHas('buku', ['judul' => $data['judul']]);
    });

    test('user can update book', function () {
        $this->actingAs($this->user);

        $book = Buku::factory()->create();
        $data = ['judul' => 'Updated Title'];
        
        $response = $this->put(route('books.update', $book->id), $data);
        
        $response->assertRedirect(route('books.index'));
        $this->assertDatabaseHas('buku', ['id' => $book->id, 'judul' => 'Updated Title']);
    });

    test('user can delete book', function () {
        $this->actingAs($this->user);

        $book = Buku::factory()->create();
        
        $response = $this->delete(route('books.destroy', $book->id));
        
        $response->assertRedirect(route('books.index'));
        $this->assertDatabaseMissing('buku', ['id' => $book->id]);
    });

