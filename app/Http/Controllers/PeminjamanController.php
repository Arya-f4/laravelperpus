<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PeminjamanController extends Controller
{
    public function userIndex()
    {
        $borrowings = Peminjaman::where('id', auth()->id())->with('buku')->get();
        return view('peminjaman.user-index', compact('borrowings'));
    }

    public function addToCart(Buku $buku)
    {
        $cartLimit = Setting::where('key', 'cart_limit')->first()->value ?? 2;
        $cartCount = session()->get('cart', []);

        if (count($cartCount) >= $cartLimit) {
            return redirect()->back()->with('error', "You can only borrow up to {$cartLimit} books at a time.");
        }

        $cart = session()->get('cart', []);
        $cart[$buku->id] = $buku->id;
        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Book added to cart successfully.');
    }

    public function viewCart()
    {
        $cartItems = Buku::whereIn('id', session()->get('cart', []))->get();
        return view('peminjaman.cart', compact('cartItems'));
    }

    public function removeFromCart(Buku $buku)
    {
        $cart = session()->get('cart', []);
        unset($cart[$buku->id]);
        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Book removed from cart successfully.');
    }

    public function checkout()
    {
        $cartItems = Buku::whereIn('id', session()->get('cart', []))->get();

        foreach ($cartItems as $item) {
            Peminjaman::create([
                'user_id' => auth()->id(),
                'buku_id' => $item->id,
                'tanggal_pinjam' => now(),
                'tanggal_kembali' => now()->addDays(14),
                'status' => 'dipinjam',
            ]);
        }

        session()->forget('cart');

        return redirect()->route('peminjaman.user-index')->with('success', 'Books borrowed successfully.');
    }

    public function index()
    {
        $peminjaman = Peminjaman::with(['user', 'buku'])->paginate(10);
        return view('peminjaman.index', compact('peminjaman'));
    }

    public function show(Peminjaman $peminjaman)
    {
        return view('peminjaman.show', compact('peminjaman'));
    }

    public function requestBorrow(Request $request, Buku $book)
    {
        $peminjaman = Peminjaman::create([
            'user_id' => auth()->id(),
            'buku_id' => $book->id,
            'kode_pinjam' => 'PJM-' . Str::random(8),
            'tanggal_pinjam' => now(),
            'tanggal_kembali' => now()->addDays(14),
            'status' => 'menunggu konfirmasi'
        ]);

        return redirect()->route('peminjaman.user-index')->with('success', 'Permintaan peminjaman buku berhasil diajukan.');
    }

    public function confirmBorrow(Peminjaman $peminjaman)
    {
        $peminjaman->update(['status' => 'dipinjam']);
        $peminjaman->buku->decrement('stok');

        return redirect()->route('peminjaman.index')->with('success', 'Peminjaman buku berhasil dikonfirmasi.');
    }

    public function rejectBorrow(Peminjaman $peminjaman)
    {
        $peminjaman->update(['status' => 'ditolak']);

        return redirect()->route('peminjaman.index')->with('success', 'Peminjaman buku ditolak.');
    }

    public function returnBook(Peminjaman $peminjaman)
    {
        $peminjaman->update(['status' => 'dikembalikan']);
        $peminjaman->buku->increment('stok');

        // Calculate fine if returned late
        $dueDate = $peminjaman->tanggal_kembali;
        $returnDate = now();
        if ($returnDate->gt($dueDate)) {
            $daysLate = $returnDate->diffInDays($dueDate);
            $finePerDay = 1000; // Rp. 1,000 per day
            $totalFine = $daysLate * $finePerDay;

            $peminjaman->denda()->create([
                'jumlah_hari' => $daysLate,
                'total_denda' => $totalFine,
            ]);

            return redirect()->route('peminjaman.index')->with('warning', "Buku dikembalikan terlambat. Denda: Rp. {$totalFine}");
        }

        return redirect()->route('peminjaman.index')->with('success', 'Buku berhasil dikembalikan.');
    }

    public function destroy(Peminjaman $peminjaman)
    {
        $peminjaman->delete();
        return redirect()->route('peminjaman.index')->with('success', 'Data peminjaman berhasil dihapus.');
    }

    public function payFine(Request $request, Denda $denda)
    {
        $denda->update(['is_paid' => true]);
        return redirect()->route('peminjaman.index')->with('success', 'Denda berhasil dibayar.');
    }
}
