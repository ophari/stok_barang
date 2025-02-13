<!-- Modal Supply Product -->
<div class="modal fade" id="supplyProductModal" tabindex="-1" aria-labelledby="supplyProductModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="supplyProductModalLabel"><i class="bi bi-plus-circle"></i> Supply Product</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="supplyProductForm" action="" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="supplyProductName" class="form-label"><i class="bi bi-box"></i> Product Name</label>
                        <input type="text" class="form-control" id="supplyProductName" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="currentStock" class="form-label"><i class="bi bi-box-seam"></i> Current Stock</label>
                        <input type="number" class="form-control" id="currentStock" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="addStock" class="form-label"><i class="bi bi-plus"></i> Add Stock</label>
                        <input type="number" class="form-control" id="addStock" name="add_stock" required min="1" placeholder="Enter additional stock">
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"><i class="bi bi-x-circle"></i> Close</button>
                    <button type="submit" class="btn btn-success"><i class="bi bi-check-circle"></i> Update Stock</button>
                </div>
            </form>
        </div>
    </div>
</div>
