<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Midtrans\Notification;

class PaymentController extends Controller
{
    public function notification(Request $request)
    {
        $notification = new Notification();

        $order = Order::where('order_number', $notification->order_id)->first();

        if ($order) {
            $transaction = $notification->transaction_status;
            $type = $notification->payment_type;
            $fraud = $notification->fraud_status;

            if ($transaction == 'capture') {
                if ($type == 'credit_card') {
                    if ($fraud == 'challenge') {
                        $order->payment_status = 'challenge';
                    } else {
                        $order->payment_status = 'success';
                        $order->status = 'Processing';
                    }
                }
            } else if ($transaction == 'settlement') {
                $order->payment_status = 'success';
                $order->status = 'Processing';
                $order->paid_at = now();
            } else if ($transaction == 'pending') {
                $order->payment_status = 'pending';
            } else if ($transaction == 'deny') {
                $order->payment_status = 'failed';
            } else if ($transaction == 'expire') {
                $order->payment_status = 'expired';
            } else if ($transaction == 'cancel') {
                $order->payment_status = 'failed';
            }

            $order->payment_method = $type;
            $order->save();
        }

        return response()->json(['status' => 'success']);
    }
}
