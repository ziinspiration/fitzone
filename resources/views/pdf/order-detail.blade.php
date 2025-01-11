<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice #{{ $order->order_number }}</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            color: #333;
            background-color: #ffffff; /* White background for PDF */
        }
        .container {
            width: 100%;
            max-width: 800px;
            margin: auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 10px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header img {
            max-width: 150px;
            margin-bottom: 10px;
        }
        .header h1 {
            font-size: 24px;
            margin: 5px 0;
        }
        .header p {
            font-size: 14px;
            color: #555;
        }
        .info-grid {
            display: table;
            width: 100%;
            margin-bottom: 20px;
            border-spacing: 10px;
        }
        .info-card {
            display: table-cell;
            vertical-align: top;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: #f9f9f9;
        }
        .info-card h3 {
            font-size: 16px;
            margin-bottom: 8px;
            color: #444;
        }
        .info-card p {
            margin: 5px 0;
            font-size: 14px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }
        th {
            background-color: #f4f4f4;
            font-size: 14px;
            color: #555;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .summary-section {
            margin-top: 20px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: #f9f9f9;
        }
        .summary-section h3 {
            font-size: 16px;
            margin-bottom: 10px;
        }
        .summary-section p {
            font-size: 14px;
            margin: 5px 0;
        }
        .summary-section .total {
            font-size: 16px;
            font-weight: bold;
            margin-top: 10px;
            padding-top: 10px;
            border-top: 2px solid #ddd;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <img src="{{ public_path('images/fitzone-logo.png') }}" alt="Fitzone Logo">
            <h1>Invoice #{{ $order->order_number }}</h1>
            <p>Thank you for shopping with us!</p>
        </div>

        <!-- Order Information -->
        <div class="info-grid">
            <div class="info-card">
                <h3>Order Details</h3>
                <p style="text-transform: capitalize"><strong>Customer:</strong> {{ auth()->user()->full_name }}</p>
                <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($order->created_at)->format('d M Y H:i:s') }}</p>
                <p style="text-transform: capitalize"><strong>Status:</strong> {{ ucfirst($order->status) }}</p>
            </div>
            <div class="info-card">
                <h3>Payment Information</h3>
                <p><strong>Method:</strong> <span style="text-transform: uppercase">{{ str_replace('_', ' ', $order->payment_method) }}</span></p>
                <p style="text-transform: capitalize"><strong>Status:</strong> {{ ucfirst($order->payment_status) }}</p>
                <p><strong>Shipping:</strong> <span style="text-transform: uppercase">{{ str_replace('_', ' ', $order->shipping_service) }}</span></p>
            </div>
        </div>

        <!-- Product Table -->
        <table>
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Size</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->orderItems as $item)
                <tr>
                    <td>{{ $item->product->name }}</td>
                    <td>{{ $item->size }}</td>
                    <td>{{ Number::currency($item->unit_price, 'IDR') }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ Number::currency($item->total_price, 'IDR') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Shipping Address and Summary -->
        <div class="info-grid">
            <div class="info-card">
                <h3>Shipping Address</h3>
                <p style="text-transform: capitalize"><strong>{{ $address->full_name }}</strong></p>
                <p>{{ $address->phone }}</p>
                <p style="text-transform: capitalize">{{ $address->street_address }}</p>
                <p style="text-transform: capitalize">{{ $address->district }}, {{ $address->province_name }}</p>
                <p style="text-transform: capitalize">{{ $address->city_name }}, {{ $address->postal_code }}</p>
            </div>
            <div class="summary-section">
                <h3>Order Summary</h3>
                <p><strong>Subtotal:</strong> {{ Number::currency($order->subtotal, 'IDR') }}</p>
                <p><strong>Shipping:</strong> {{ Number::currency($order->shipping_cost, 'IDR') }}</p>
                <p><strong>Tax:</strong> {{ Number::currency($order->tax_amount, 'IDR') }}</p>
                <p class="total"><strong>Total:</strong> {{ Number::currency($order->total_amount, 'IDR') }}</p>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>For any questions, please contact our customer support team.</p>
        </div>
    </div>
</body>
</html>
