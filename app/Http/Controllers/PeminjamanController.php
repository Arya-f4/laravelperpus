<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PeminjamanController extends Controller
{
    public function userIndex()
    {
        $borrowings = Peminjaman::where('peminjam_id', Auth::id())
            ->with('bukus')
            ->orderBy('id', 'DESC')  // Assuming 'bukus' is the name of the relationship in Peminjaman model
            ->get();
        // return $borrowings;
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

    public function removeFromCart($buku)
    {
        $cart = session()->get('cart', []);

        // Periksa apakah item ada di keranjang
        if (isset($cart[$buku])) {
            unset($cart[$buku]);
            session()->put('cart', $cart);
            return redirect()->back()->with('success', 'Book removed from cart successfully.');
        }

        return redirect()->back()->with('success', 'Book removed from cart successfully.');
    }

    public function checkout()
    {
        $cartItems = Buku::whereIn('id', session()->get('cart', []))->get();

        // Create a new peminjaman record
        $peminjaman = Peminjaman::create([
            'user_id' => Auth::id(),
            'kode_pinjam' => 'AUTO_GENERATE_CODE',  // Add your code logic if needed
            'tanggal_pinjam' => now(),
            'tanggal_kembali' => now()->addDays(14),
            'status' => 1,
        ]);

        // Insert details into detail_peminjaman table for each cart item
        foreach ($cartItems as $item) {
            DB::table('detail_peminjaman')->insert([
                'peminjaman_id' => Auth::id(),  // Reference the newly created peminjaman ID
                'buku_id' => $item->id,  // Reference the book ID
            ]);
        }

        // Clear the cart session
        session()->forget('cart');

        // Redirect to the peminjaman page with a success message
        return redirect()->route('peminjaman.user-index')->with('success', 'Books borrowed successfully.');
    }


    public function index()
    {
        $peminjaman = Peminjaman::with(['user', 'buku'])
            ->orderBy('created_at', 'desc') // You can change this to your desired column
            ->paginate(10);

        return view('peminjaman.index', compact('peminjaman'));
    }

    public function show($peminjaman)
    {
        $peminjaman = Peminjaman::find($peminjaman);
        // return $peminjaman;
        return view('peminjaman.show', compact('peminjaman'));
    }

    public function requestBorrow(Request $request)
    {
        $userId = Auth::id();
        $kodePinjam = 'PJM-' . Str::random(8);
        $tanggalPinjam = now();
        $tanggalKembali = now()->addDays(14);

        // Prepare the peminjaman record data
        $peminjamanData = [
            'peminjam_id' => $userId,
            'kode_pinjam' => $kodePinjam,
            'tanggal_pinjam' => $tanggalPinjam,
            'tanggal_kembali' => $tanggalKembali,
            'status' => 0, // assuming 'menunggu konfirmasi' means 0 status
        ];

        // Save the peminjaman record and get the latest ID
        $peminjaman = Peminjaman::create($peminjamanData);
        $peminjamanId = $peminjaman->id;  // Get the ID of the newly created peminjaman

        // Prepare the detail_peminjaman records
        $detailPeminjamanData = [];
        foreach ($request->cart_ids as $bukuId) {
            $detailPeminjamanData[] = [
                'peminjaman_id' => $peminjamanId,  // Use the newly created peminjaman ID
                'buku_id' => $bukuId,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Optionally, you can return the result as JSON to inspect before saving:
        $result = [
            'peminjaman' => $peminjamanData,
            'detail_peminjaman' => $detailPeminjamanData,
        ];

        // Uncomment to check the JSON result
        // return response()->json($result);

        // Insert the detail_peminjaman records into the database
        DB::table('detail_peminjaman')->insert($detailPeminjamanData);

        session()->forget('cart');

        // Return a success message and redirect
        return redirect()->route('peminjaman.user-index')->with('success', 'Permintaan peminjaman buku berhasil diajukan.');
    }




    public function confirmBorrow($peminjaman)
    {
        // Find the peminjaman record and update the status
        $peminjaman = Peminjaman::find($peminjaman);
        $peminjaman->update(['status' => 1]);

        return redirect()->route('peminjaman.index')->with('success', 'Peminjaman buku berhasil dikonfirmasi.');
    }


    public function rejectBorrow(Peminjaman $peminjaman)
    {
        $peminjaman->update(['status' => 'ditolak']);

        return redirect()->route('peminjaman.index')->with('success', 'Peminjaman buku ditolak.');
    }

    public function returnBook($peminjaman)
    {
        $peminjaman = Peminjaman::find($peminjaman);
        $peminjaman->update(['status' => '3']);

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
