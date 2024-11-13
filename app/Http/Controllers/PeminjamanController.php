<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Buku;
use App\Models\Denda;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;

class PeminjamanController extends Controller
{
    public function index()
    {
        $peminjaman = Peminjaman::with(['user', 'buku'])->paginate(10);
        return view('peminjaman.index', compact('peminjaman'));
    }

    public function create()
    {
        $books = Buku::where('stok', '>', 0)->get();
        return view('peminjaman.create', compact('books'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'buku_id' => 'required|exists:buku,id',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'required|date|after:tanggal_pinjam',
        ]);

        $validated['users_id'] = auth()->id();
        $validated['kode_pinjam'] = 'PJM-' . Str::random(8);
        $validated['status'] = 'dipinjam';

        $peminjaman = Peminjaman::create($validated);

        // Decrease book stock
        $book = Buku::find($validated['buku_id']);
        $book->decrement('stok');

        return redirect()->route('peminjaman.index')->with('success', 'Book borrowed successfully');
    }

    public function show(Peminjaman $peminjaman)
    {
        return view('peminjaman.show', compact('peminjaman'));
    }

    public function update(Request $request, Peminjaman $peminjaman)
    {
        if ($request->has('return')) {
            $peminjaman->update(['status' => 'dikembalikan']);

            // Increase book stock
            $peminjaman->buku->increment('stok');

            // Check for late return
            $dueDate = Carbon::parse($peminjaman->tanggal_kembali);
            $returnDate = Carbon::now();

            if ($returnDate->gt($dueDate)) {
                $daysLate = $returnDate->diffInDays($dueDate);
                $finePerDay = 1000; // Rp. 1,000 per day
                $totalFine = $daysLate * $finePerDay;

                Denda::create([
                    'peminjaman_id' => $peminjaman->id,
                    'jumlah_hari' => $daysLate,
                    'total_denda' => $totalFine,
                ]);

                return redirect()->route('peminjaman.index')
                    ->with('warning', "Book returned late. Fine: Rp. {$totalFine}");
            }

            return redirect()->route('peminjaman.index')
                ->with('success', 'Book returned successfully');
        }

        // Handle other updates if needed
    }

    public function payFine(Denda $denda)
    {
        $denda->update(['is_paid' => true]);
        return redirect()->route('peminjaman.index')
            ->with('success', 'Fine paid successfully');
    }
}
