<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Order #{{ $order->order_number }}</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            background-color: #f7f7f7; /* Light gray background */
            color: #333; /* Dark gray text for better readability */
        }
        .container {
            width: 85%; /* Slightly narrower for better readability */
            max-width: 960px; /* Increased max width */
            margin: 40px auto; /* Added vertical margin */
            background-color: #fff; /* White background for content */
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08); /* Subtle shadow */
            border-radius: 12px; /* Rounded corners */
            overflow: hidden;
        }
        .header {
            background-color: #2c3e50; /* Darker header */
            color: #fff;
            padding: 30px 40px;
            border-bottom: 4px solid #34495e; /* Slightly darker border */
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
         .header .logo-container {
            margin: 0; /* Remove margin for logo container */
        }
        .logo {
            max-width: 160px;
            height: auto;
        }
        .order-title {
            font-size: 28px;
            font-weight: 600;
            margin: 0;
        }
        .content {
            padding: 40px;
        }
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            margin-bottom: 40px;
        }
        .info-card {
            background-color: #f9f9f9;
            border-radius: 10px;
            padding: 20px;
            border: 1px solid #eee;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        }
        .info-card h3 {
            font-size: 18px;
            margin-bottom: 15px;
            color: #444;
        }
        .info-card p {
            margin: 8px 0;
            color: #555;
        }
        .info-card strong {
            color: #2c3e50;
            font-weight: 500;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 40px;
            background-color: #fff;
            border: 1px solid #eee;
        }
        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }
        th {
            background-color: #f2f2f2;
            color: #2c3e50;
            font-weight: 600;
        }
        .status-badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 500;
            text-transform: uppercase;
            white-space: nowrap;
        }
        .status-pending { background-color: #fff2cc; color: #a26710; }
        .status-processing { background-color: #f9e7b1; color: #93590a; }
        .status-shipped { background-color: #c8f7c5; color: #227020; }
        .status-delivered { background-color: #c8f7c5; color: #227020; }
        .status-cancelled { background-color: #f7c4c4; color: #8a2121; }
        .address-section, .summary-section {
            background-color: #f9f9f9;
            padding: 25px;
            border-radius: 10px;
            margin-bottom: 30px;
            border: 1px solid #eee;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        }
        .address-section h3, .summary-section h3 {
            font-size: 18px;
            margin-bottom: 15px;
            color: #444;
        }
        .total-row {
            border-top: 2px solid #ddd;
            padding-top: 15px;
            margin-top: 15px;
            font-weight: 700;
            font-size: 20px;
        }
         .footer {
            text-align: center;
            padding: 30px;
            color: #777;
            font-size: 13px;
            border-top: 1px solid #eee;
            margin-top: 50px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
             <div class="logo-container">
                 <img src="{{ public_path('images/fitzone-logo.png') }}" alt="Fitzone Logo" class="logo">
            </div>
            <h1 class="order-title">Invoice #{{ $order->order_number }}</h1>
        </div>

        <div class="content">
            <div class="info-grid">
                <div class="info-card">
                    <h3>Order Information</h3>
                    <p><strong>Customer:</strong> {{ auth()->user()->full_name }}</p>
                    <p><strong>Order Date:</strong> {{ \Carbon\Carbon::parse($order->created_at)->format('d M Y H:i:s') }}</p>
                    <p><strong>Order Status:</strong>
                        <span class="status-badge status-{{ $order->status }}">{{ ucfirst($order->status) }}</span>
                    </p>
                </div>
                <div class="info-card">
                    <h3>Payment Information</h3>
                    <p><strong>Payment Method:</strong> {{ str_replace('_', ' ', $order->payment_method) }}</p>
                    <p><strong>Payment Status:</strong>
                        <span class="status-badge status-{{ $order->payment_status }}">{{ ucfirst($order->payment_status) }}</span>
                    </p>
                    <p><strong>Shipping Via:</strong> {{ str_replace('_', ' ', $order->shipping_service) }}</p>
                </div>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->orderItems as $item)
                    <tr>
                        <td>{{ $item->product->name }}</td>
                        <td>{{ Number::currency($item->unit_price, 'IDR') }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ Number::currency($item->total_price, 'IDR') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="info-grid">
                 <div class="address-section">
                    <h3>Shipping Address</h3>
                    <p><strong>{{ $address->full_name }}</strong></p>
                    <p>{{ $address->phone }}</p>
                    <p>{{ $address->street_address }}</p>
                    <p>{{ $address->district }}, {{ $address->province_name }}</p>
                    <p>{{ $address->city_name }}, {{ $address->postal_code }}</p>
                </div>

                <div class="summary-section">
                    <h3>Order Summary</h3>
                    <p><strong>Subtotal:</strong> {{ Number::currency($order->subtotal, 'IDR') }}</p>
                    <p><strong>Shipping:</strong> {{ Number::currency($order->shipping_cost, 'IDR') }}</p>
                    <p><strong>Tax:</strong> {{ Number::currency($order->tax_amount, 'IDR') }}</p>
                    <div class="total-row">
                        <strong>Total:</strong> {{ Number::currency($order->total_amount, 'IDR') }}
                    </div>
                </div>
            </div>
        </div>

        <div class="footer">
            <p>Thank you for shopping at Fitzone!</p>
            <p>For any questions, please contact our customer service.</p>
        </div>
    </div>
</body>
</html>
