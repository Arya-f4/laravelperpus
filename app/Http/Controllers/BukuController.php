<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Kategori;
use App\Models\Penerbit;
use App\Models\Rak;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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
        // Proses file sampul
        $sampulPath = $request->file('sampul')->store('sampul', 'public');

        // Data untuk disimpan
        $data = [
            'judul' => $request->input('judul'),
            'penulis' => $request->input('penulis'),
            'penerbit_id' => $request->input('penerbit_id'),
            'kategori_id' => $request->input('kategori_id'),
            'rak_id' => $request->input('rak_id'),
            'stok' => $request->input('stok'),
            'sampul' => $sampulPath,
            'slug' => Str::slug($request->input('judul')),
        ];

        // Simpan data ke database
        Buku::create($data);

        // Redirect ke halaman index buku dengan pesan sukses
        return redirect()->route('books.index')->with('success', 'Book created successfully.');
    }

    public function edit($id)
    {
        $categories = Kategori::all();
        $publishers = Penerbit::all();
        $racks = Rak::all();
        $book = Buku::find($id);
        return view('books.edit', compact('book', 'categories', 'publishers', 'racks'));
    }

    public function update(Request $request, $book)
    {
        // Pastikan $book adalah instance model
    $book = Buku::findOrFail($book);

        // Data untuk diupdate
        $data = [
            'judul' => $request->input('judul'),
            'penulis' => $request->input('penulis'),
            'penerbit_id' => $request->input('penerbit_id'),
            'kategori_id' => $request->input('kategori_id'),
            'rak_id' => $request->input('rak_id'),
            'stok' => $request->input('stok'),
        ];

        // Proses file sampul jika diunggah
        if ($request->hasFile('sampul')) {
            // Hapus sampul lama jika ada
            if ($book->sampul && Storage::exists('public/' . $book->sampul)) {
                Storage::delete('public/' . $book->sampul);
            }

            $sampulPath = $request->file('sampul')->store('sampul', 'public');
            $data['sampul'] = $sampulPath;
        }

        // Generate slug
        $data['slug'] = Str::slug($request->input('judul'));

        // Update data ke database
        $book->update($data);

        // Redirect ke halaman index buku dengan pesan sukses
        return redirect()->route('books.index')->with('success', 'Book updated successfully.');
    }

    public function destroy($book)
    {
        $book = Buku::find($book);
        $book->delete();
        return redirect()->route('books.index')->with('success', 'Book deleted successfully.');
    }

    public function show($slug)
    {
        $book = Buku::where('slug', $slug)->firstOrFail();
        return view('books.show', compact('book'));
    }
}
