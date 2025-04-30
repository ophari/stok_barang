<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ $invoice->invoice_number }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #007bff;
            color: white;
            padding: 15px;
            border-radius: 8px 8px 0 0;
        }
        .logo {
        max-height: 50px;
        width: 50px;
        border-radius: 50%;
        object-fit: cover;
    }

        .invoice-number {
            font-size: 20px;
            font-weight: bold;
        }
        .details {
            margin: 20px 0;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 5px;
        }
        .details p {
            margin: 5px 0;
        }
        .items {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .items th {
            background: #007bff;
            color: white;
            padding: 10px;
            text-align: left;
        }
        .items td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }
        .total-section {
            margin-top: 20px;
            text-align: right;
        }
        .total-section p {
            font-size: 18px;
            font-weight: bold;
        }
        .paid-badge {
            background: #28a745;
            color: white;
            padding: 10px 15px;
            font-size: 16px;
            font-weight: bold;
            border-radius: 5px;
            display: inline-block;
            margin-top: 10px;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            color: #777;
            font-size: 14px;
        }
    </style>
</head>
<body>

    <div class="invoice-box">
        <div class="header">
            <img src="{{ public_path('img/logohero.jpeg') }}" alt="Company Logo" class="logo">

            <div class="invoice-number">Invoice #{{ $invoice->invoice_number }}</div>
        </div>

        <div class="details">
            <p><strong>Billed To:</strong> {{ $invoice->customer_name }}</p>
            <p><strong>Address:</strong> {{ $transaction->address ?? 'No Address' }}</p>
            <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($invoice->date)->format('Y-m-d') }}</p>
        </div>

        <table class="items">
            <thead>
                <tr>
                    <th>Description</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th class="text-right">Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($invoice->invoiceDetails as $detail)
                <tr>
                    <td>{{ $detail->product->name }}</td>
                    <td>{{ $detail->quantity }}</td>
                    <td>Rp{{ number_format($detail->price, 2) }}</td>
                    <td class="text-right">Rp{{ number_format($detail->subtotal, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="total-section">
            <p><strong>Total: Rp{{ number_format($invoice->total_amount, 2) }}</strong></p>
        </div>

        <div class="footer">
            <p>THANK YOU </p>
        </div>
    </div>

</body>
</html>
