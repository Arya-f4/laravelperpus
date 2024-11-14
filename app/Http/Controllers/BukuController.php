<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Kategori;
use App\Models\Penerbit;
use App\Models\Rak;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BukuController extends Controller
{
    public function index()
    {
        $books = Buku::with(['kategori', 'penerbit', 'rak'])->paginate(10);
        return view('books.index', compact('books'));
    }

    public function create()
    {
        $categories = Kategori::all();
        $publishers = Penerbit::all();
        $racks = Rak::all();
        return view('books.create', compact('categories', 'publishers', 'racks'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|max:255',
            'penulis' => 'required|max:255',
            'penerbit_id' => 'required|exists:penerbit,id',
            'kategori_id' => 'required|exists:kategori,id',
            'rak_id' => 'required|exists:rak,id',
            'stok' => 'required|integer|min:0',
            'sampul' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $sampulPath = $request->file('sampul')->store('sampul', 'public');
        $validated['sampul'] = $sampulPath;
        $validated['slug'] = Str::slug($validated['judul']);

        Buku::create($validated);

        return redirect()->route('books.index')->with('success', 'Book created successfully.');
    }

    public function edit(Buku $book)
    {
        $categories = Kategori::all();
        $publishers = Penerbit::all();
        $racks = Rak::all();
        return view('books.edit', compact('book', 'categories', 'publishers', 'racks'));
    }

    public function update(Request $request, Buku $book)
    {
        $validated = $request->validate([
            'judul' => 'required|max:255',
            'penulis' => 'required|max:255',
            'penerbit_id' => 'required|exists:penerbit,id',
            'kategori_id' => 'required|exists:kategori,id',
            'rak_id' => 'required|exists:rak,id',
            'stok' => 'required|integer|min:0',
            'sampul' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('sampul')) {
            $sampulPath = $request->file('sampul')->store('sampul', 'public');
            $validated['sampul'] = $sampulPath;
        }

        $validated['slug'] = Str::slug($validated['judul']);

        $book->update($validated);

        return redirect()->route('books.index')->with('success', 'Book updated successfully.');
    }

    public function destroy(Buku $book)
    {
        $book->delete();
        return redirect()->route('books.index')->with('success', 'Book deleted successfully.');
    }

    public function show($slug)
    {
        $book = Buku::where('slug', $slug)->firstOrFail();
        return view('books.show', compact('book'));
    }
}
