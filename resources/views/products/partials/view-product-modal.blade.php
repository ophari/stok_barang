<!-- Modal View Product -->
<div class="modal fade" id="viewProductModal" tabindex="-1" aria-labelledby="viewProductModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg"> <!-- Tambahkan modal-lg biar lebih luas -->
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="viewProductModalLabel"><i class="bi bi-eye"></i> Product Details</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <!-- Product Name -->
                        <h4 id="productName" class="text-dark fw-bold"></h4>
                        <p class="text-muted"><i class="bi bi-tag"></i> <span id="productCategory" class="badge bg-secondary"></span></p>
                        <hr>

                        <!-- Product Details -->
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong><i class="bi bi-cash-stack"></i> Price:</strong> <span id="productPrice" class="badge bg-success text-white"></span></p>
                            </div>
                            <div class="col-md-6">
                                <p><strong><i class="bi bi-box-seam"></i> Stock:</strong> <span id="productStock" class="badge bg-info text-white"></span></p>
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="mt-3">
                            <p><strong><i class="bi bi-card-text"></i> Description:</strong></p>
                            <p id="productDescription" class="text-muted"></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"><i class="bi bi-x-circle"></i> Close</button>
            </div>
        </div>
    </div>
</div>
