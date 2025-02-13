<!DOCTYPE html>
<html lang="en">
<head>
    <title>Invoice List</title>
</head>
<body>
    <h1>Invoices</h1>
    <a href="{{ route('invoices.create') }}">Create Invoice</a>

    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    <ul>
        @foreach ($invoices as $invoice)
            <li>
                Invoice #: {{ $invoice->invoice_number }} | 
                Customer: {{ $invoice->customer_name ?? 'N/A' }} | 
                Total: ${{ number_format($invoice->total_amount, 2) }} | 
                Date: {{ $invoice->date->format('Y-m-d H:i') }}
                <a href="{{ route('invoices.show', $invoice->id) }}">View</a>
                <a href="{{ route('invoices.generatePdf', $invoice->id) }}">Download PDF</a>
            </li>
        @endforeach
    </ul>
</body>
</html>
