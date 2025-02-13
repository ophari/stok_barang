@extends('layouts.app')

@section('content')
<div class="row">
    <div class="card mb-4 shadow-sm border-0 rounded"> <!-- Shadow & Border untuk tampilan modern -->
        <!-- Notifikasi Flash Message -->
        @if(session('success'))
          <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        @endif

        <!-- Navbar -->
       <!-- Navbar -->
      <nav class="navbar bg-body-tertiary p-3">
        <div class="container-fluid d-flex justify-content-between align-items-center">
          <h3 class="m-0 fw-bold">📦 Products</h3>
          
          <!-- Search Input -->
          <div class="input-group w-50"> 
              <span class="input-group-text"><i class="bi bi-search"></i></span>
              <input type="text" class="form-control" id="searchProduct" placeholder="Search product..." onkeyup="searchProduct()">
          </div>

          <!-- Button trigger modal -->
          <button type="button" class="btn btn-primary rounded-pill" data-bs-toggle="modal" data-bs-target="#addProductModal">
            <i class="bi bi-plus-circle"></i> Add Product
          </button>
        </div>
      </nav>


        <!-- Table Section -->
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-hover table-bordered align-middle text-center"> <!-- Tambahkan text-center -->
                <thead class="table-dark">
                    <tr>
                        <th style="width: 5%;">#</th>
                        <th>Name</th>
                        <th>Stock</th>
                        <th>Price</th>
                        <th style="width: 15%;">Actions</th> <!-- Lebarkan sedikit biar pas -->
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $index => $product)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $product->name }}</td>
                        <td><span class="badge bg-info">{{ $product->stock }}</span></td> <!-- Badge biar lebih clean -->
                        <td class="fw-bold">Rp{{ number_format($product->price, 2) }}</td>
                        <td>
                            <div class="d-flex justify-content-center gap-1">
                                <!-- View Button -->
                                <button class="btn btn-outline-info btn-sm rounded-circle" data-bs-toggle="modal" 
                                data-bs-target="#viewProductModal"
                                onclick="viewProduct('{{ $product->name }}', '{{ $product->category->name ?? 'No Category' }}', 
                                '{{ number_format($product->price, 2) }}', '{{ $product->stock }}', '{{ $product->description }}')">
                                <i class="bi bi-eye"></i>
                                </button>
        
                                <!-- Edit Button -->
                                <button class="btn btn-outline-warning btn-sm rounded-circle" data-bs-toggle="modal" 
                                data-bs-target="#editProductModal"
                                onclick="editProduct('{{ $product->id }}', '{{ $product->name }}', '{{ $product->category->name ?? 'No Category' }}', 
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
                                    <button type="submit" class="btn btn-outline-danger btn-sm rounded-circle" title="Delete" onclick="return confirm('Are you sure?')">
                                    <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
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

<script>
  function searchProduct() {
    let input = document.getElementById("searchProduct").value.toLowerCase();
    let rows = document.querySelectorAll("tbody tr");

    rows.forEach(row => {
      let name = row.cells[1].innerText.toLowerCase(); // Ambil kolom Nama Produk
      row.style.display = name.includes(input) ? "" : "none"; // Sembunyikan kalau tidak cocok
    });
  }
</script>




@endsection
