<!DOCTYPE html>
<html lang="en">
<head>
    <title>Add Transaction</title>
</head>
<body>
    <h1>Add Transaction</h1>
    <form action="{{ route('transactions.store') }}" method="POST">
        @csrf

        <label for="product_id">Product:</label>
        <select id="product_id" name="product_id" required>
            @foreach($products as $product)
                <option value="{{ $product->id }}">{{ $product->name }} (Stock: {{ $product->stock }})</option>
            @endforeach
        </select><br>

        <label for="type">Transaction Type:</label>
        <select id="type" name="type" required>
            <option value="in">Stock In</option>
            <option value="out">Stock Out</option>
        </select><br>

        <label for="quantity">Quantity:</label>
        <input type="number" id="quantity" name="quantity" required><br>

        <label for="note">Note:</label>
        <textarea id="note" name="note"></textarea><br>

        <button type="submit">Save Transaction</button>
    </form>
</body>
</html>
