<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\Setting;
use App\Models\Denda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\User;
use App\Models\DetailPeminjaman;
class PeminjamanController extends Controller
{
    public function index()
{
    $peminjaman = Peminjaman::with(['user', 'denda', 'detailPeminjaman'])
        ->orderBy('created_at', 'DESC')
        ->get();

    return view('peminjaman.index', compact('peminjaman'));
}



    public function userIndex()
    {
        $borrowings = Peminjaman::where('peminjam_id', Auth::id())
            ->with('bukus')
            ->orderBy('created_at', 'DESC')
            ->get();
        return view('peminjaman.user-index', compact('borrowings'));
    }
    public function addToCart(Request $request, $bookId)
    {
        $user = Auth::user();
        $activeBorrowings = Peminjaman::where('peminjam_id', $user->id)
            ->whereIn('status', [0, 1])
            ->count();

        if ($activeBorrowings >= 2) {
            return redirect()->back()->with('error', 'You have already borrowed two books!');
        }

        $cart = session()->get('cart', []);
        $cart[$bookId] = $bookId;
        session()->put('cart', $cart);

        return redirect()->route('peminjaman.cart')->with('success', 'Borrowing request rejected successfully.');

    }

    public function viewCart()
    {
        $cartItems = Buku::whereIn('id', session()->get('cart', []))->get();
        return view('peminjaman.cart', compact('cartItems'));
    }

    public function removeFromCart($bookId)
    {
        $cart = session()->get('cart', []);
        if (isset($cart[$bookId])) {
            unset($cart[$bookId]);
            session()->put('cart', $cart);
        }
        return redirect()->back()->with('success', 'Book removed from cart successfully.');
    }

    public function checkout(Request $request)
    {
        $user = Auth::user();
        $selectedBooks = $request->input('selected_books', []);

        if (empty($selectedBooks)) {
            return redirect()->back()->with('error', 'Please select at least one book to borrow.');
        }

        $cartItems = Buku::whereIn('id', $selectedBooks)->get();

        $activeBorrowings = Peminjaman::where('peminjam_id', $user->id)
            ->whereIn('status', [0, 1])
            ->count();

        if ($activeBorrowings + $cartItems->count() > 2) {
            return redirect()->back()->with('error', 'You can only borrow up to 2 books at a time.');
        }

        $kodePinjam = 'PJM-' . Str::random(8);
        $tanggalPinjam = now();
        $tanggalKembali = now()->addDays(14);

        $peminjaman = Peminjaman::create([
            'peminjam_id' => $user->id,
            'kode_pinjam' => $kodePinjam,
            'tanggal_pinjam' => $tanggalPinjam,
            'tanggal_kembali' => $tanggalKembali,
            'status' => 0,
        ]);

        foreach ($cartItems as $item) {
            DB::table('detail_peminjaman')->insert([
                'peminjaman_id' => $peminjaman->id,
                'buku_id' => $item->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Remove borrowed books from the cart
        $cart = session()->get('cart', []);
        foreach ($selectedBooks as $bookId) {
            unset($cart[$bookId]);
        }
        session()->put('cart', $cart);

        return redirect()->route('peminjaman.user-index')->with('success', 'Books borrowed successfully.');
    }






    public function approve($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        if ($peminjaman->status != 0) {
            return redirect()->back()->with('error', 'This request cannot be approved.');
        }

        $peminjaman->update([
            'status' => 1,
            'tanggal_pinjam' => now(),
            'tanggal_kembali' => now()->addDays(14)
        ]);

        return redirect()->route('peminjaman.index')->with('success', 'Borrowing request approved successfully.');
    }

    public function cancel($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        if ($peminjaman->status != 0) {
            return redirect()->back()->with('error', 'This request cannot be cancelled.');
        }

        $peminjaman->update(['status' => 4]); // Set status to rejected instead of deleting
        return redirect()->route('peminjaman.user-index')->with('success', 'Borrowing request rejected successfully.');
    }
    public function show($id)
    {
        $peminjaman = Peminjaman::with(['user', 'buku', 'denda'])
            ->findOrFail($id);

        // Get staff names
        $petugasPinjam = User::find($peminjaman->petugas_pinjam);
        $petugasKembali = User::find($peminjaman->petugas_kembali);

        return view('peminjaman.show', compact('peminjaman', 'petugasPinjam', 'petugasKembali'));
    }


    public function requestBorrow(Request $request)
    {
        $user = Auth::user();

        $activeBorrowings = Peminjaman::where('peminjam_id', $user->id)
            ->whereIn('status', [0, 1])
            ->count();

        $bookId = $request->input('book_id');

        if ($activeBorrowings >= 2) {
            return redirect()->back()->with('error', 'You have already borrowed two books. Please return a book before borrowing another.');
        }

        if (!$bookId) {
            return redirect()->back()->with('error', 'No book selected for borrowing.');
        }

        $kodePinjam = 'PJM-' . Str::random(8);
        $tanggalPinjam = now();
        $tanggalKembali = now()->addDays(14);

        $peminjaman = Peminjaman::create([
            'peminjam_id' => $user->id,
            'kode_pinjam' => $kodePinjam,
            'tanggal_pinjam' => $tanggalPinjam,
            'tanggal_kembali' => $tanggalKembali,
            'status' => 0,
        ]);

        DB::table('detail_peminjaman')->insert([
            'peminjaman_id' => $peminjaman->id,
            'buku_id' => $bookId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('peminjaman.user-index')->with('success', 'Borrowing request submitted successfully.');
    }



    public function cancelRequest($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        if ($peminjaman->peminjam_id != Auth::id() || $peminjaman->status != 0) {
            return redirect()->back()->with('error', 'You cannot cancel this borrowing request.');
        }

        $peminjaman->delete();
        return redirect()->route('peminjaman.user-index')->with('success', 'Borrowing request cancelled successfully.');
    }




    public function confirmBorrow($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $peminjaman->update(['status' => 1]);

        return redirect()->route('peminjaman.index')->with('success', 'Borrowing request approved.');
    }


    public function rejectBorrow(Peminjaman $peminjaman)
    {
        $peminjaman->update(['status' => 'ditolak']);

        return redirect()->route('peminjaman.index')->with('success', 'Peminjaman buku ditolak.');
    }

public function returnBook($id)
{
    $peminjaman = Peminjaman::findOrFail($id);

    if ($peminjaman->status != 1) {
        return redirect()->back()->with('error', 'This book cannot be returned.');
    }

    // Calculate days late
    $dueDate = Carbon::parse($peminjaman->tanggal_kembali);
    $today = Carbon::now();
    $daysLate = max(0, $today->diffInDays($dueDate, false));

    // Update peminjaman
    $peminjaman->update([
        'status' => 3, // Returned
        'tanggal_pengembalian' => $today,
        'petugas_kembali' => auth()->id(), // Track returning staff
    ]);

    // Create fine if returned late
    if ($daysLate > 0) {
        Denda::create([
            'peminjaman_id' => $peminjaman->id,
            'jumlah_hari' => $daysLate,
            'total_denda' => $daysLate * 1000, // Rp. 1000 per day
            'is_paid' => 0, // 0 for false (unpaid)
        ]);
    }

    return redirect()->route('peminjaman.index')
        ->with('success', 'Book has been returned successfully.' .
            ($daysLate > 0 ? ' Fine has been created for ' . $daysLate . ' days late.' : ''));
}



    public function showDenda($id)
    {
        $denda = Denda::findOrFail($id);
        return view('peminjaman.show-denda', compact('denda'));
    }

    public function destroy(Peminjaman $peminjaman)
    {
        $peminjaman->delete();
        return redirect()->route('peminjaman.index')->with('success', 'Data peminjaman berhasil dihapus.');
    }

    public function payFine(Denda $denda)
    {
        // Check if the fine is already paid
        if ($denda->is_paid == 1) {
            return redirect()->back()->with('error', 'This fine has already been paid.');
        }

        $peminjamantable = Peminjaman::findOrFail($denda->peminjaman_id);
        $user = User::findOrFail($peminjamantable->peminjam_id);

        // Load Midtrans configuration
        \Midtrans\Config::$serverKey = config('services.midtrans.server_key');
        \Midtrans\Config::$isProduction = config('services.midtrans.is_production');
        \Midtrans\Config::$isSanitized = config('services.midtrans.is_sanitized');
        \Midtrans\Config::$is3ds = config('services.midtrans.is_3ds');

        // Round the total_denda to the nearest whole number
        $roundedAmount = round($denda->total_denda);

        // Create a transaction payload
        $transactionDetails = [
            'order_id' => 'FINE-' . uniqid(),
            'gross_amount' => $roundedAmount,
        ];

        $itemDetails = [
            [
                'id' => 'FINE-' . $denda->id,
                'price' => $roundedAmount,
                'quantity' => 1,
                'name' => 'Library Fine Payment',
            ],
        ];

        $customerDetails = [
            'first_name' => $user->name,
            'email' => $user->email,
        ];

        $transactionPayload = [
            'transaction_details' => $transactionDetails,
            'item_details' => $itemDetails,
            'customer_details' => $customerDetails,
        ];

        try {
            // Generate a payment URL
            $snapToken = \Midtrans\Snap::getSnapToken($transactionPayload);

            return view('payment.pay', compact('snapToken', 'denda'));
        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('Midtrans Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to process payment. Please try again later.');
        }
    }

    public function updateFineStatus(Request $request, Denda $denda)
{
    // Check if the fine is already paid
    if ($denda->is_paid == 1) {
        return response()->json(['message' => 'Fine already paid.'], 400);
    }

    // Check transaction status (optional, depending on how Midtrans returns it)
    if ($request->status == 'paid') {
        // Update the fine to 'paid'
        $denda->update(['is_paid' => 1]);

        // Update the associated peminjaman status if necessary
        $peminjaman = Peminjaman::findOrFail($denda->peminjaman_id);
        $peminjaman->update([
            'status' => 3, // or whatever status you want to set for paid fines
        ]);

        return response()->json(['message' => 'Fine paid and status updated successfully.'], 200);
    }

    return response()->json(['message' => 'Payment status is not valid.'], 400);
}






}

