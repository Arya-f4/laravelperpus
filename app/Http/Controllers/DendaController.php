<?php

namespace App\Http\Controllers;

use App\Models\Denda;
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;

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
        $dendas = Denda::with('peminjaman')->where('is_paid', false)->get();
        return view('denda.index', compact('dendas'));
    }

    public function pay(Denda $denda)
    {
        $orderId = 'DENDA-' . $denda->id . '-' . time();

        $transactionDetails = [
            'order_id' => $orderId,
            'gross_amount' => $denda->total_denda
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
            $paymentUrl = Snap::createTransaction($transactionData)->redirect_url;

            $denda->update([
                'payment_url' => $paymentUrl,
                'order_id' => $orderId,
            ]);

            return redirect($paymentUrl);
        } catch (\Exception $e) {
            return back()->with('error', 'Payment processing failed: ' . $e->getMessage());
        }
    }

    public function handleCallback(Request $request)
    {
        $denda = Denda::where('order_id', $request->order_id)->firstOrFail();

        if ($request->transaction_status === 'settlement') {
            $denda->update(['is_paid' => true]);
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

