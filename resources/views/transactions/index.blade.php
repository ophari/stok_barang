<!DOCTYPE html>
<html lang="en">
<head>
    <title>Transaction List</title>
</head>
<body>
    <h1>Transactions</h1>
    <a href="{{ route('transactions.create') }}">Add Transaction</a>

    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    <ul>
        @foreach ($transactions as $transaction)
            <li>
                Product: {{ $transaction->product->name }} | 
                Type: {{ $transaction->type }} | 
                Quantity: {{ $transaction->quantity }} | 
                User: {{ $transaction->user->name }} | 
                Date: {{ $transaction->created_at->format('Y-m-d H:i') }}
            </li>
        @endforeach
    </ul>
</body>
</html>
