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

        $validated = [
            'nama' => $request->nama,
            'slug' => $request->nama
        ];

        Kategori::create($validated);
        return redirect()->route('categories.index')->with('success', 'Category created successfully');
    }

    public function edit($category)
    {
        $category = Kategori::find($category);
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request,  $category)
    {
        $category = Kategori::find($category);
        $category->nama = $request->nama;
        $category->slug = $request->nama;

        $category->save();
        return redirect()->route('categories.index')->with('success', 'Category updated successfully');
    }

    public function destroy($category)
    {
        $category = Kategori::find($category);
        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Category deleted successfully');
    }
}
