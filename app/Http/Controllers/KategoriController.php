<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class KategoriController extends Controller
{
    public function index()
    {
        $categories = Kategori::paginate(10);
        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|unique:kategori|max:255',
        ]);

        $validated['slug'] = Str::slug($validated['nama']);

        Kategori::create($validated);
        return redirect()->route('categories.index')->with('success', 'Category created successfully');
    }

    public function edit(Kategori $category)
    {
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, Kategori $category)
    {
        $validated = $request->validate([
            'nama' => 'required|unique:kategori,nama,' . $category->id . '|max:255',
        ]);

        $validated['slug'] = Str::slug($validated['nama']);

        $category->update($validated);
        return redirect()->route('categories.index')->with('success', 'Category updated successfully');
    }

    public function destroy(Kategori $category)
    {
        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Category deleted successfully');
    }
}
