<!-- Modal Create Product -->
<div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg"> <!-- Tambahkan modal-lg biar lebih luas -->
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="addProductModalLabel"><i class="bi bi-plus-circle"></i> Add New Product</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('products.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <div class="row">
                                <!-- Left Column -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="name" class="form-label"><i class="bi bi-box"></i> Product Name</label>
                                        <input type="text" class="form-control" id="name" name="name" required placeholder="Enter product name">
                                    </div>
                                    <div class="mb-3">
                                        <label for="category_id" class="form-label"><i class="bi bi-tag"></i> Category</label>
                                        <select class="form-select" id="category_id" name="category_id" required>
                                            <option value="">Select Category</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <!-- Right Column -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="price" class="form-label">Price</label>
                                        <div class="input-group">
                                            <span class="input-group-text">Rp</span>
                                            <input type="text" class="form-control" id="price" name="price" required placeholder="0" 
                                                oninput="formatRupiah(this)" onblur="removeFormat(this)">
                                        </div>
                                    </div>
                                    
                                    
                                    
                                    <div class="mb-3">
                                        <label for="stock" class="form-label"><i class="bi bi-box-seam"></i> Stock</label>
                                        <input type="number" class="form-control" id="stock" name="stock" required min="0" placeholder="Enter stock amount">
                                    </div>
                                </div>
                            </div>

                            <!-- Full Width Description -->
                            <div class="row mt-3">
                                <div class="col-12">
                                    <label for="description" class="form-label"><i class="bi bi-card-text"></i> Description</label>
                                    <textarea class="form-control" id="description" name="description" rows="3" placeholder="Write product description..."></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"><i class="bi bi-x-circle"></i> Close</button>
                    <button type="submit" class="btn btn-primary"><i class="bi bi-check-circle"></i> Save Product</button>
                </div>
            </form>
        </div>
    </div>
</div>


<script>
    function formatRupiah(input) {
        let value = input.value.replace(/\D/g, ""); // Hapus semua karakter non-numeric
        value = new Intl.NumberFormat("id-ID").format(value); // Format ke Rupiah (Indonesia)
        input.value = value;
    }
    
    function removeFormat(input) {
        input.value = input.value.replace(/\./g, ''); // Hapus titik ribuan sebelum submit
    }
    </script>
    
    