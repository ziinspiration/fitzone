<?php

namespace App\Services;

use Midtrans\Config;
use Midtrans\Snap;
use Illuminate\Support\Facades\Log;

class MidtransService
{
    public function __construct()
    {
        Log::info('Midtrans Config:', [
            'server_key' => config('midtrans.server_key'),
            'is_production' => config('midtrans.is_production')
        ]);

        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized', true);
        Config::$is3ds = config('midtrans.is_3ds', true);

        if (empty(Config::$serverKey)) {
            throw new \Exception('Midtrans Server Key is not configured');
        }
    }

    public function createTransaction($order)
    {
        try {
            $transaction_details = [
                'order_id' => (string) $order->order_number,
                'gross_amount' => (int) $order->total_amount,
            ];

            $customer_details = [
                'first_name' => (string) $order->address->first_name,
                'last_name' => (string) $order->address->last_name,
                'email' => (string) $order->user->email,
                'phone' => (string) $order->address->phone,
                'shipping_address' => [
                    'first_name' => (string) $order->address->first_name,
                    'last_name' => (string) $order->address->last_name,
                    'phone' => (string) $order->address->phone,
                    'address' => (string) $order->address->street_address,
                    'city' => (string) $order->address->city_name,
                    'postal_code' => (string) $order->address->postal_code,
                ]
            ];

            $transaction_data = [
                'transaction_details' => $transaction_details,
                'customer_details' => $customer_details,
            ];

            Log::info('Transaction Data:', $transaction_data);

            $snapToken = Snap::getSnapToken($transaction_data);
            Log::info('Snap Token Generated:', ['token' => $snapToken]);

            return $snapToken;
        } catch (\Exception $e) {
            Log::error('Midtrans Error:', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            throw $e;
        }
    }
}
