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

                <!-- Search Form (Compact & Modern) -->
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

                <button type="button" class="btn btn-primary rounded-pill" data-bs-toggle="modal" data-bs-target="#addProductModal">
                    <i class="bi bi-plus-circle"></i> Add Product
                </button>
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
                            <th>Actions</th>
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
                            <td>
                                <button class="btn btn-outline-warning btn-sm rounded-circle" data-bs-toggle="modal" 
                                    data-bs-target="#editProductModal-{{ $product->id }}">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                                
                                <button class="btn btn-outline-success btn-sm rounded-circle" data-bs-toggle="modal" 
                                    data-bs-target="#supplyProductModal-{{ $product->id }}">
                                    <i class="bi bi-plus-circle"></i>
                                </button>

                                <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm rounded-circle" onclick="return confirm('Are you sure?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>

                        <!-- Include Modals -->
                        @include('products.partials.edit-product-modal', ['product' => $product])
                        @include('products.partials.supply-product-modal', ['product' => $product])

                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">No products found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center">
                {{ $products->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>

<!-- Include Modal -->
@include('products.partials.product-modal')

<!-- Include View Modal -->
@include('products.partials.view-product-modal')

<!-- Include Edit Modal -->
@include('products.partials.edit-product-modal')

<!-- Include Supply Modal -->
@include('products.partials.supply-product-modal')





<script>
  function viewProduct(name, category, price, stock, description) {
      document.getElementById("productName").innerText = name;
      document.getElementById("productCategory").innerText = category;
      document.getElementById("productPrice").innerText = "Rp " + price;
      document.getElementById("productStock").innerText = stock;
      document.getElementById("productDescription").innerText = description;
  }
</script>

<script>
  function editProduct(id, name, category, price, stock, description) {
      document.getElementById("editProductForm").action = "/products/" + id;
      document.getElementById("editName").value = name;
      document.getElementById("editCategory").value = category;
      document.getElementById("editPrice").value = new Intl.NumberFormat("id-ID").format(price); // Format harga ke "Rp" saat modal dibuka
      document.getElementById("editStock").value = stock;
      document.getElementById("editDescription").value = description;
  }
  </script>
  
  

<script>
  function supplyProduct(id, name, stock) {
      document.getElementById("supplyProductForm").action = "/products/supply/" + id;
      document.getElementById("supplyProductName").value = name;
      document.getElementById("currentStock").value = stock;
      document.getElementById("addStock").value = ""; // Reset input
  }
</script>

@endsection
