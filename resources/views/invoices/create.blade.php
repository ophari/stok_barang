<!DOCTYPE html>
<html lang="en">
<head>
    <title>Create Invoice</title>
</head>
<body>
    <h1>Create Invoice</h1>
    <form action="{{ route('invoices.store') }}" method="POST">
        @csrf

        <label for="customer_name">Customer Name:</label>
        <input type="text" id="customer_name" name="customer_name"><br>

        <h2>Select Products</h2>
        @foreach($products as $product)
            <label>
                <input type="checkbox" name="products[{{ $product->id }}][id]" value="{{ $product->id }}">
                {{ $product->name }} (Stock: {{ $product->stock }}, Price: ${{ number_format($product->price, 2) }})
            </label>
            <input type="number" name="products[{{ $product->id }}][quantity]" min="1" placeholder="Quantity"><br>
        @endforeach

        <button type="submit">Create Invoice</button>
    </form>
</body>
</html>
