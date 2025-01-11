<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Midtrans\Notification;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    public function notification(Request $request)
    {
        try {
            Log::info('Midtrans Notification Received', ['request' => $request->all()]);

            $notification = new Notification();
            $order = Order::where('order_number', $notification->order_id)->first();

            if ($order) {
                $transaction = $notification->transaction_status;
                $type = $notification->payment_type;
                $fraud = $notification->fraud_status;

                Log::info('Transaction Data', [
                    'order_number' => $notification->order_id,
                    'transaction_status' => $transaction,
                    'payment_type' => $type,
                    'fraud_status' => $fraud,
                ]);

                if ($transaction == 'capture') {
                    if ($type == 'credit_card') {
                        if ($fraud == 'challenge') {
                            $order->payment_status = 'challenge';
                        } else {
                            $order->payment_status = 'success';
                            $order->status = 'Processing';
                            $order->paid_at = now();
                        }
                    }
                } elseif ($transaction == 'settlement') {
                    $order->payment_status = 'success';
                    $order->status = 'Processing';
                    $order->paid_at = now();
                } elseif ($transaction == 'pending') {
                    $order->payment_status = 'pending';
                } elseif ($transaction == 'deny') {
                    $order->payment_status = 'failed';
                } elseif ($transaction == 'expire') {
                    $order->payment_status = 'expired';
                } elseif ($transaction == 'cancel') {
                    $order->payment_status = 'failed';
                }

                $order->payment_method = $type;
                $order->save();

                Log::info('Payment notification processed for order ' . $order->order_number, [
                    'transaction_status' => $transaction,
                    'payment_type' => $type,
                    'fraud_status' => $fraud,
                    'order_status' => $order->status,
                    'payment_status' => $order->payment_status,
                    'paid_at' => $order->paid_at,
                ]);
            } else {
                Log::error('Order not found for notification order_id: ' . $notification->order_id);
            }

            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            Log::error('Error processing payment notification: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }
}
