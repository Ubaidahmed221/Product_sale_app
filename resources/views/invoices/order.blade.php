<!DOCTYPE html>
<html>

<head>
    <title>Invoice #{{ $order->id }}</title>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 14px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .section {
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }

        .table-no-border td {
            border: none;
            padding: 4px 8px;
        }
    </style>
</head>

<body>
    @php
        $currency = $order->currency === 'pkr' ? 'Rs' : '$';
    @endphp

    <div class="header">
        <h2>Invoice #{{ $order->id }}</h2>
        <p>Date: {{ $order->created_at->format('d M Y') }}</p>
    </div>
    <hr>

    <!-- Seller & Customer Info -->
    <table class="table-no-border">
        <tr>
            <td width="50%">
                <strong>From (Seller):</strong><br>
                Your Company Name<br>
                support@yourcompany.com<br>
                +91-XXXXXXXXXX
            </td>
            <td width="50%">
                <strong>To (Customer):</strong><br>
                {{ $order->user->name }}<br>
                {{ $order->user->email }}<br>
                {{ $order->user->country_code.' '.$order->user->phone_number }}
            </td>
        </tr>
    </table>

    <!-- Billing & Shipping Address -->
    <table class="table-no-border" style="margin-top: 20px;">
        <tr>
            <td width="50%">
                <strong>Billing Address:</strong><br>
                {{ $order->billing_address['first_name'] ?? '' }} {{ $order->billing_address['last_name'] ?? '' }}<br>
                {{ $order->billing_address['address_1'] ?? '' }}<br>
                {{ $order->billing_address['city'] ?? '' }}, {{ $order->billing_address['state'] ?? '' }}<br>
                {{ $order->billing_address['country'] ?? '' }} - {{ $order->billing_address['zip'] ?? '' }}
            </td>
            @if ($order->shipping_address)
                <td width="50%">
                    <strong>Shipping Address:</strong><br>
                    {{ $order->shipping_address['first_name'] ?? '' }}
                    {{ $order->shipping_address['last_name'] ?? '' }}<br>
                    {{ $order->shipping_address['address_1'] ?? '' }}<br>
                    {{ $order->shipping_address['city'] ?? '' }}, {{ $order->shipping_address['state'] ?? '' }}<br>
                    {{ $order->shipping_address['country'] ?? '' }} - {{ $order->shipping_address['zip'] ?? '' }}
                </td>
            @endif
        </tr>
    </table>
    <hr>

    <!-- Payment Info -->
    <div class="section">
        <strong>Payment Details:</strong><br>
        Method: {{ ucfirst($order->payment_method) }}<br>
        Status: {{ ucfirst($order->payment_status) }}<br>
        @if ($order->transaction_id)
            Transaction ID: {{ $order->transaction_id }}
        @endif
    </div>

    <!-- Order Items -->
    <div class="section">
        <strong>Order Items:</strong>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Product</th>
                    <th>Qty</th>
                    <th>Price</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->items as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->product_title ?? 'N/A' }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ $currency }}{{ number_format($item->price, 2) }}</td>
                        <td>{{ $currency }}{{ number_format($item->price * $item->quantity, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Totals -->
    <div class="section">
        <strong>Subtotal:</strong> {{ $currency }}{{ number_format($order->subtotal, 2) }} <br>
        <strong>Shipping:</strong> {{ $currency }}{{ number_format($order->shipping_amount, 2) }} <br>
        <strong>Total:</strong> <strong>{{ $currency }}{{ number_format($order->total, 2) }}</strong>
    </div>
</body>

</html>