<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    public function index()
    {
        $books = Buku::with(['kategori', 'penerbit', 'rak'])->paginate(10);
        return view('books.index', compact('books'));
    }

    public function create()
    {
        return view('books.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|max:255',
            'penerbit_id' => 'required|exists:penerbit,id',
            'kategori_id' => 'required|exists:kategori,id',
            'rak_id' => 'required|exists:rak,id',
            'stok' => 'required|integer|min:0',
            'penulis' => 'required|max:255',
        ]);

        Buku::create($validated);
        return redirect()->route('books.index')->with('success', 'Book added successfully');
    }

    public function edit(Buku $book)
    {
        return view('books.edit', compact('book'));
    }

    public function update(Request $request, Buku $book)
    {
        $validated = $request->validate([
            'judul' => 'required|max:255',
            'penerbit_id' => 'required|exists:penerbit,id',
            'kategori_id' => 'required|exists:kategori,id',
            'rak_id' => 'required|exists:rak,id',
            'stok' => 'required|integer|min:0',
            'penulis' => 'required|max:255',
        ]);

        $book->update($validated);
        return redirect()->route('books.index')->with('success', 'Book updated successfully');
    }

    public function destroy(Buku $book)
    {
        $book->delete();
        return redirect()->route('books.index')->with('success', 'Book deleted successfully');
    }
}
