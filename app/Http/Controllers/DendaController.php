<?php

namespace App\Http\Controllers;

use App\Models\Denda;
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;
use App\Models\Peminjaman;
use Carbon\Carbon;
class DendaController extends Controller
{
    public function __construct()
    {
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.is_production');
        Config::$isSanitized = config('services.midtrans.is_sanitized');
        Config::$is3ds = config('services.midtrans.is_3ds');
    }

    public function index()
    {
        // Check for overdue books and create/update fines
        $activeBorrowings = Peminjaman::where('status', 1)->get();
        $now = Carbon::now();

        foreach ($activeBorrowings as $borrowing) {
            $dueDate = Carbon::parse($borrowing->tanggal_pinjam)->addDays(14);
            if ($now->gt($dueDate)) {
                $daysLate = abs($now->diffInDays($dueDate));
                $totalFine = $daysLate * 1000; // Assuming 1000 per day

                Denda::updateOrCreate(
                    ['peminjaman_id' => $borrowing->id],
                    [
                        'jumlah_hari' => $daysLate,
                        'total_denda' => $totalFine,
                        'is_paid' => 0
                    ]
                );



            }
        }

        // Fetch all unpaid fines
        $dendas = Denda::with('peminjaman.user')
                       ->with('peminjaman.detailPeminjaman.buku')->get();

        return view('denda.index', compact('dendas'));
    }

    public function pay(Denda $denda)
    {
        if ($denda->is_paid) {
            return redirect()->back()->with('error', 'This fine has already been paid.');
        }

        $orderId = 'DENDA-' . $denda->id . '-' . time();

        $transactionDetails = [
            'order_id' => $orderId,
            'gross_amount' => (int) $denda->total_denda
        ];

        $userData = [
            'first_name' => auth()->user()->name,
            'email' => auth()->user()->email,
        ];

        $transactionData = [
            'transaction_details' => $transactionDetails,
            'customer_details' => $userData
        ];

        try {
            $snapToken = Snap::getSnapToken($transactionData);

            $denda->update([
                'order_id' => $orderId,
            ]);

            return view('payment.pay', compact('snapToken', 'denda'));
        } catch (\Exception $e) {
            return back()->with('error', 'Payment processing failed: ' . $e->getMessage());
        }
    }

    public function handleCallback(Request $request)
    {
        $orderId = $request->order_id;
        $transactionStatus = $request->transaction_status;
        $fraudStatus = $request->fraud_status;

        $denda = Denda::where('order_id', $orderId)->firstOrFail();

        if ($transactionStatus == 'capture') {
            if ($fraudStatus == 'challenge') {
                $denda->update(['payment_status' => 'challenge']);
            } else if ($fraudStatus == 'accept') {
                $denda->update(['is_paid' => true, 'payment_status' => 'success']);
            }
        } else if ($transactionStatus == 'settlement') {
            $denda->update(['is_paid' => true, 'payment_status' => 'success']);
        } else if ($transactionStatus == 'cancel' || $transactionStatus == 'deny' || $transactionStatus == 'expire') {
            $denda->update(['payment_status' => 'failed']);
        } else if ($transactionStatus == 'pending') {
            $denda->update(['payment_status' => 'pending']);
        }

        return response()->json(['status' => 'success']);
    }

    public function markAsPaid($id)
    {
        $denda = Denda::findOrFail($id);
        $denda->update(['is_paid' => true]);
        return redirect()->route('peminjaman.index')->with('success', 'Denda has been marked as paid.');
    }
}

