<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ $invoice->invoice_number }}</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 800px; margin: auto; padding: 20px; }
        .invoice-box { border: 1px solid #ddd; padding: 20px; }
        .header { text-align: center; }
        .details, .items, .total { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .details td, .items td, .items th, .total td { border: 1px solid #ddd; padding: 10px; }
        .items th { background-color: #f4f4f4; }
        .text-right { text-align: right; }
        .actions { margin-top: 20px; text-align: center; }
        button { padding: 10px 15px; margin: 5px; cursor: pointer; border: none; }
        .btn-print { background: #28a745; color: white; }
        .btn-download { background: #007bff; color: white; }
    </style>
</head>
<body>

    <div class="invoice-box">
        <div class="header">
            <h2>Invoice</h2>
            <p>Date: {{ \Carbon\Carbon::parse($invoice->date)->format('Y-m-d') }}</p>
            <p>Invoice #{{ $invoice->invoice_number }}</p>
        </div>

        <table class="details">
            <tr>
                <td>
                    <strong>From:</strong> <br>
                    {{ env('COMPANY_NAME', 'Your Company Name') }} <br>
                    {{ env('COMPANY_EMAIL', 'company@example.com') }} <br>
                    {{ env('COMPANY_ADDRESS', 'Company Address') }} <br>
                    {{ env('COMPANY_PHONE', '123-456-7890') }}
                </td>
                <td>
                    <strong>To:</strong> <br>
                    {{ $invoice->customer_name }} <br>
                    {{ $invoice->customer_email ?? 'No Email' }} <br>
                    {{ $invoice->customer_address ?? 'No Address' }}
                </td>
            </tr>
        </table>

        <table class="items">
            <thead>
                <tr>
                    <th>Description</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($invoice->invoiceDetails as $detail)
                <tr>
                    <td>{{ $detail->product->name }}</td>
                    <td class="text-right">{{ $detail->quantity }}</td>
                    <td class="text-right">${{ number_format($detail->price, 2) }}</td>
                    <td class="text-right">${{ number_format($detail->subtotal, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <table class="total">
            <tr>
                <td class="text-right"><strong>Subtotal:</strong></td>
                <td class="text-right">${{ number_format($invoice->subtotal, 2) }}</td>
            </tr>
            <tr>
                <td class="text-right"><strong>Tax:</strong></td>
                <td class="text-right">${{ number_format($invoice->tax, 2) }}</td>
            </tr>
            <tr>
                <td class="text-right"><strong>Total:</strong></td>
                <td class="text-right">${{ number_format($invoice->total_amount, 2) }}</td>
            </tr>
        </table>

        <p><strong>Notes:</strong> {{ $invoice->notes ?? 'No notes available.' }}</p>

        <div class="actions">
            <button class="btn-print" onclick="window.print()">Print Invoice</button>
            <a href="{{ route('invoices.generatePdf', $invoice->id) }}">
                <button class="btn-download">Download PDF</button>
            </a>
        </div>
    </div>

</body>
</html>
