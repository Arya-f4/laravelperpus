<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Kategori;
use App\Models\Penerbit;
use App\Models\Rak;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;
class BukuController extends Controller
{
    public function index(Request $request)
    {
        $query = Buku::with(['kategori', 'penerbit', 'rak']);

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhere('penulis', 'like', "%{$search}%");
            });
        }

        // Category filter
        if ($request->filled('kategori')) {
            $query->where('kategori_id', $request->kategori);
        }

        // Publisher filter
        if ($request->filled('penerbit')) {
            $query->where('penerbit_id', $request->penerbit);
        }

        $books = $query->paginate(12);
        $categories = Kategori::all();
        $publishers = Penerbit::all();

        // Get most borrowed books
        $mostBorrowedBooks = Buku::select('buku.*')
            ->join('detail_peminjaman', 'buku.id', '=', 'detail_peminjaman.buku_id')
            ->groupBy('buku.id')
            ->orderByRaw('COUNT(detail_peminjaman.id) DESC')
            ->limit(4)
            ->get();

        // Get latest books
        $latestBooks = Buku::latest()->limit(4)->get();

        // Use 'home' view for the root route, 'books.index' for other cases
        $view = $request->routeIs('home') ? 'home' : 'books.index';

        return view($view, compact('books', 'categories', 'publishers', 'mostBorrowedBooks', 'latestBooks'));
    }

    public function show($slug)
    {
        $book = Buku::with(['kategori', 'penerbit', 'rak'])->where('slug', $slug)->firstOrFail();
        return view('books.show', compact('book'));
    }
    public function data()
    {
        $books = Buku::with(['kategori', 'penerbit', 'rak']);

        return DataTables::of($books)
            ->addColumn('kategori', function ($book) {
                return $book->kategori->nama;
            })
            ->addColumn('rak', function ($book) {
                return $book->rak->nama . ' (Row: ' . $book->rak->baris . ')';
            })
            ->addColumn('actions', function ($book) {
                $actions = '<a href="' . route('books.show', $book) . '" class="text-indigo-600 hover:text-indigo-900 mr-2">View</a>';

                if (auth()->user()->can('update', $book)) {
                    $actions .= '<a href="' . route('books.edit', $book) . '" class="text-yellow-600 hover:text-yellow-900 mr-2">Edit</a>';
                }

                if (auth()->user()->can('delete', $book)) {
                    $actions .= '<form action="' . route('books.destroy', $book) . '" method="POST" class="inline">
                        ' . csrf_field() . '
                        ' . method_field('DELETE') . '
                        <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm(\'Are you sure you want to delete this book?\')">Delete</button>
                    </form>';
                }

                return $actions;
            })
            ->rawColumns(['actions'])
            ->make(true);
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
        $request->validate([
            'judul' => 'required|string|max:255',
            'penulis' => 'required|string|max:255',
            'penerbit_id' => 'required|exists:penerbit,id',
            'kategori_id' => 'required|exists:kategori,id',
            'rak_id' => 'required|exists:rak,id',
            'stok' => 'required|integer|min:0',
            'deskripsi' => 'required|string',
            'isbn' => 'required|string',
            'sampul' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'slug' => Str::slug($request->input('judul')),
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->judul);

        if ($request->hasFile('sampul')) {
            $sampulPath = $request->file('sampul')->store('sampul', 'public');
            $data['sampul'] = $sampulPath;
        }

        Buku::create($data);

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

    public function update(Request $request, Buku $buku)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'penulis' => 'required|string|max:255',
            'penerbit_id' => 'required|exists:penerbit,id',
            'kategori_id' => 'required|exists:kategori,id',
            'deskripsi' => 'required|string',
            'isbn' => 'required|string',
            'rak_id' => 'required|exists:rak,id',
            'stok' => 'required|integer|min:0',
            'sampul' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->except(['_token', '_method']);

        $data['slug'] = Str::slug($request->judul);

        if ($request->hasFile('sampul')) {
            $sampulPath = $request->file('sampul')->store('sampul', 'public');
            $data['sampul'] = $sampulPath;
        }
        $id = $request->id;
        $book = Buku::find($id);
        if ($book) {
            $book->update($data);
            return redirect()->route('books.index')->with('success', 'Book updated successfully.');
        } else {
            return redirect()->route('books.index')->with('error', 'Book not found.');
        }
     }

    public function destroy($book)
    {
        $book = Buku::find($book);
        $book->delete();
        return redirect()->route('books.index')->with('success', 'Book deleted successfully.');
    }


}
