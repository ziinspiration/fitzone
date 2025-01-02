<?php

return [
    'merchant_id' => env('MIDTRANS_MERCHANT_ID'),
    'server_key' => env('MIDTRANS_SERVER_KEY'),
    'client_key' => env('MIDTRANS_CLIENT_KEY'),
    'is_production' => env('MIDTRANS_IS_PRODUCTION', false),
    'payment_url' => env('MIDTRANS_PAYMENT_URL', 'https://app.sandbox.midtrans.com/snap/v1/transactions'),
    'is_sanitized' => true,
    'is_3ds' => true
];
