<!-- Modal Edit Product -->
<div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="editProductModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title" id="editProductModalLabel"><i class="bi bi-pencil-square"></i> Edit Product</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editProductForm" action="" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <div class="row">
                                <!-- Left Side -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="editName" class="form-label">Product Name</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-box"></i></span>
                                            <input type="text" class="form-control" id="editName" name="name" required>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="editCategory" class="form-label">Category</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-tag"></i></span>
                                            <select class="form-select" id="editCategory" name="category_id" required>
                                                @foreach($categories as $category)
                                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <!-- Right Side -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="editPrice" class="form-label">Price</label>
                                        <div class="input-group">
                                            <span class="input-group-text">Rp</span>
                                            <input type="text" class="form-control" id="editPrice" name="price" required 
                                                oninput="formatRupiah(this)">
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="editStock" class="form-label">Stock</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-boxes"></i></span>
                                            <input type="number" class="form-control" id="editStock" name="stock" required min="0">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Full Width for Description -->
                            <div class="mb-3">
                                <label for="editDescription" class="form-label">Description</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-card-text"></i></span>
                                    <textarea class="form-control" id="editDescription" name="description" rows="3"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"><i class="bi bi-x-circle"></i> Close</button>
                    <button type="submit" class="btn btn-warning"><i class="bi bi-check-circle"></i> Update Product</button>
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
    
    
</script>
