<?php

namespace App\Http\Controllers;

use App\Models\Rak;
use App\Models\Kategori;
use Illuminate\Http\Request;

class RakController extends Controller
{
    public function index()
    {
        $racks = Rak::with('kategori')->paginate(10);

        return view('racks.index', compact('racks'));
    }

    public function create()
    {
        $categories = Kategori::all();
        return view('racks.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'rak' => 'required|string|max:255',
            'baris' => 'required|integer|min:1',
            'slug' => 'required|string|unique:rak,slug',
            'kategori_id' => 'required|exists:kategori,id',
        ]);        

        Rak::create($validated);

        return redirect()->route('racks.index')->with('success', 'Rack created successfully.');
    }

    public function edit($id)
    {
        $rack = Rak::findOrFail($id);
        $categories= Kategori::all();
        return view('racks.edit', compact('rack','categories'));
    }

    public function update(Request $request, Rak $rack)
    {
        $validated = $request->validate([
            'rak' => 'required|string|max:255',
            'baris' => 'required|integer|min:1',
            'kategori_id'=> 'required|exists:kategori,id',
            'slug' => 'required|string|unique:rak,slug,' . $rack->id,
        ]);

        $rack->update($validated);

        return redirect()->route('racks.index')->with('success', 'Rack updated successfully.');
    }

    public function destroy(Rak $rack)
    {
        $rack->delete();
        return redirect()->route('racks.index')->with('success', 'Rack deleted successfully.');
    }
}
