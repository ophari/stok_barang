<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Product</title>
    <script>
        function updateStock() {
            let currentStock = parseInt(document.getElementById('stock').value) || 0;
            let addedStock = parseInt(document.getElementById('added_stock').value) || 0;
            document.getElementById('stock').value = currentStock + addedStock;
        }
    </script>
</head>
<body>
    <h1>Edit Product</h1>
    <form action="{{ route('products.update', $product->id) }}" method="POST">
        @csrf
        @method('PUT')

        <label for="name">Product Name:</label>
        <input type="text" id="name" name="name" value="{{ $product->name }}" required><br>

        <label for="stock">Current Stock:</label>
        <input type="number" id="stock" name="stock" value="{{ $product->stock }}" required readonly><br>

        <label for="added_stock">Add Stock:</label>
        <input type="number" id="added_stock" name="added_stock" value="0" min="0" oninput="updateStock()"><br>

        <label for="price">Price:</label>
        <input type="number" step="0.01" id="price" name="price" value="{{ $product->price }}" required><br>

        <label for="description">Description:</label>
        <textarea id="description" name="description">{{ $product->description }}</textarea><br>

        <label for="category_id">Category:</label>
        <select id="category_id" name="category_id" required>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select><br>

        <button type="submit">Update Product</button>
    </form>
</body>
</html>
