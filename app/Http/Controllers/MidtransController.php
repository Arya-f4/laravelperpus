<?php
namespace App\Http\Controllers;
use Midtrans\Notification;


use App\Models\Denda;
use Illuminate\Http\Request;
use App\Models\Peminjaman;

class MidtransController extends Controller {

public function handleNotification(Request $request)
{
    $notification = new Notification();
    $status = $notification->transaction_status;
    $orderId = $notification->order_id;
    $grossAmount = $notification->gross_amount;
    $peminjamantable = Peminjaman::findOrFail($denda->peminjaman_id);

    // Retrieve the payment data from the database based on the order_id
    $denda = Denda::where('order_id', $orderId)->first();

    if (!$denda) {
        return response()->json(['status' => 'error', 'message' => 'Order not found.'], 404);
    }

    // Handle different transaction statuses
    switch ($status) {
        case 'capture':
            // Payment is captured, update the status
            if ($notification->fraud_status == 'accept') {
                // The payment is successfully processed
                $denda->update(['is_paid' => 1]);
                $peminjamantable->update(['status' => '3']);
                return response()->json(['status' => 'success', 'message' => 'Payment successful.']);
            } else {
                // Fraud detected
                return response()->json(['status' => 'failed', 'message' => 'Payment fraud detected.']);
            }
        case 'settlement':
            // Payment is successful, update the status
            $denda->update(['is_paid' => 1]);
            return response()->json(['status' => 'success', 'message' => 'Payment successful.']);
        case 'pending':
            // Payment is pending
            return response()->json(['status' => 'pending', 'message' => 'Payment pending.']);
        case 'deny':
            // Payment was denied
            return response()->json(['status' => 'failed', 'message' => 'Payment failed.']);
        default:
            return response()->json(['status' => 'error', 'message' => 'Unknown status.']);
    }
}
}
