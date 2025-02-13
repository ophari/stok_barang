<!DOCTYPE html>
<html lang="en">
<head>
    <title>Product Details</title>
</head>
<body>
    <h1>Product Details</h1>
    <p><strong>Name:</strong> {{ $product->name }}</p>
    <p><strong>Stock:</strong> {{ $product->stock }}</p>
    <p><strong>Price:</strong> ${{ $product->price }}</p>
    <p><strong>Description:</strong> {{ $product->description }}</p>
    <p><strong>Category:</strong> {{ $product->category->name ?? 'No Category' }}</p>
    
    <a href="{{ route('products.index') }}">Back to Products</a>
</body>
</html>
