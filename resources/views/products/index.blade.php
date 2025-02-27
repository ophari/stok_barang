@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card shadow-sm border-0 rounded">
        @if(session('success'))
          <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        @endif

        <!-- Navbar -->
        <nav class="navbar bg-body-tertiary p-3">
            <div class="container-fluid d-flex justify-content-between align-items-center">
                <h3 class="m-0 fw-bold">📦 Products</h3>

                <!-- Search Form -->
                <div class="col-md-6 text-end">
                    <form action="{{ route('products.index') }}" method="GET" class="d-flex align-items-center">
                        <div class="input-group input-group-sm">
                            <input type="text" name="search" class="form-control rounded-pill"
                                   placeholder="🔍 Search product..." value="{{ request('search') }}">
                            <button type="submit" class="btn btn-secondary rounded-pill ms-2">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Hanya Supervisor Bisa Menambah Produk -->
                @if(auth()->user()->role === 'supervisor')
                <button type="button" class="btn btn-primary rounded-pill" data-bs-toggle="modal" data-bs-target="#addProductModal">
                    <i class="bi bi-plus-circle"></i> Add Product
                </button>
                @endif
            </div>
        </nav>

        <!-- Table Section -->
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-bordered align-middle text-center">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Stock</th>
                            <th>Price</th>
                            <th>Category</th>
                            @if(auth()->user()->role === 'supervisor')
                            <th>Actions</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($products as $index => $product)
                        <tr>
                            <td>{{ $products->firstItem() + $index }}</td>
                            <td>{{ $product->name }}</td>
                            <td><span class="badge bg-info">{{ $product->stock }}</span></td>
                            <td class="fw-bold">Rp{{ number_format($product->price, 2) }}</td>
                            <td>{{ $product->category->name ?? '-' }}</td>
                            @if(auth()->user()->role === 'supervisor')
                            <td>
                                <!-- View Button (Bisa Diakses Semua User) -->
                                <button class="btn btn-outline-primary btn-sm rounded-circle" data-bs-toggle="modal"
                                    data-bs-target="#viewProductModal"
                                    onclick="viewProduct('{{ $product->name }}', '{{ $product->category->name ?? '-' }}',
                                    '{{ number_format($product->price, 2) }}', '{{ $product->stock }}', '{{ $product->description }}')">
                                    <i class="bi bi-eye"></i>
                                </button>

                                <!-- Edit Button -->
                                <button class="btn btn-outline-warning btn-sm rounded-circle" data-bs-toggle="modal"
                                    data-bs-target="#editProductModal"
                                    onclick="editProduct('{{ $product->id }}', '{{ $product->name }}', '{{ $product->category->id ?? '' }}',
                                    '{{ $product->price }}', '{{ $product->stock }}', '{{ $product->description }}')">
                                    <i class="bi bi-pencil-square"></i>
                                </button>

                                <!-- Supply Button -->
                                <button class="btn btn-outline-success btn-sm rounded-circle" data-bs-toggle="modal"
                                    data-bs-target="#supplyProductModal"
                                    onclick="supplyProduct('{{ $product->id }}', '{{ $product->name }}', '{{ $product->stock }}')">
                                    <i class="bi bi-plus-circle"></i>
                                </button>

                                <!-- Delete Button -->
                                <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm rounded-circle" onclick="return confirm('Are you sure?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                            @endif
                        </tr>

                        @empty
                        <tr>
                            <td colspan="{{ auth()->user()->role === 'supervisor' ? '6' : '5' }}" class="text-center text-muted">
                                No products found.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            {{ $products->links('pagination::bootstrap-5') }}

        </div>
    </div>
</div>

<!-- Include Modals -->
@include('products.partials.product-modal')
@include('products.partials.view-product-modal')
@include('products.partials.edit-product-modal')
@include('products.partials.supply-product-modal')

<script>
    function viewProduct(name, category, price, stock, description) {
        document.getElementById("productName").innerText = name;
        document.getElementById("productCategory").innerText = category;
        document.getElementById("productPrice").innerText = "Rp " + price;
        document.getElementById("productStock").innerText = stock;
        document.getElementById("productDescription").innerText = description;
    }

    function editProduct(id, name, category, price, stock, description) {
        let form = document.getElementById("editProductForm");
        form.action = "/products/" + id;
        document.getElementById("editName").value = name;
        document.getElementById("editCategory").value = category;
        document.getElementById("editPrice").value = price;
        document.getElementById("editStock").value = stock;
        document.getElementById("editDescription").value = description;
    }

    function supplyProduct(id, name, stock) {
        document.getElementById("supplyProductForm").action = "/products/supply/" + id;
        document.getElementById("supplyProductName").value = name;
        document.getElementById("currentStock").value = stock;
    }
</script>

@endsection
