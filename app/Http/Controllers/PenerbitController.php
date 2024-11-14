<?php

namespace App\Http\Controllers;

use App\Models\Penerbit;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PenerbitController extends Controller
{
    public function index()
    {
        $publishers = Penerbit::paginate(10);
        return view('publishers.index', compact('publishers'));
    }

    public function create()
    {
        return view('publishers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        $validated['slug'] = Str::slug($validated['nama']);

        Penerbit::create($validated);

        return redirect()->route('publishers.index')->with('success', 'Publisher created successfully.');
    }

    public function edit(Penerbit $publisher)
    {
        return view('publishers.edit', compact('publisher'));
    }

    public function update(Request $request, Penerbit $publisher)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        $validated['slug'] = Str::slug($validated['nama']);

        $publisher->update($validated);

        return redirect()->route('publishers.index')->with('success', 'Publisher updated successfully.');
    }

    public function destroy(Penerbit $publisher)
    {
        $publisher->delete();
        return redirect()->route('publishers.index')->with('success', 'Publisher deleted successfully.');
    }
}
