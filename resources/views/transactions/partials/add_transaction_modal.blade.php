<div class="modal fade" id="addTransactionModal" tabindex="-1" aria-labelledby="addTransactionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="addTransactionModalLabel"><i class="bi bi-plus-circle"></i> Add New Transaction</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('transactions.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="searchProduct" class="form-label">🔍 Search Product</label>
                                        <input type="text" id="searchProduct" class="form-control" placeholder="Search product by name...">
                                    </div>

                                    <div class="mb-3">
                                        <label for="product_id" class="form-label">📦 Product</label>
                                        <select class="form-select" id="product_id" name="product_id" required>
                                            @foreach($products as $product)
                                                <option value="{{ $product->id }}" data-name="{{ strtolower($product->name) }}">{{ $product->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="type" class="form-label">🔄 Transaction Type</label>
                                        <select class="form-select" id="type" name="type" required onchange="toggleCustomerName()">
                                            <option value="in">📥 Stock In</option>
                                            <option value="out">📤 Stock Out</option>
                                        </select>
                                    </div>

                                    <!-- Customer Name Field -->
                                    <div id="customerNameField" class="mb-3" style="display: none;">
                                        <label for="customer_name" class="form-label">👤 Customer Name</label>
                                        <input type="text" class="form-control" id="customer_name" name="customer_name" placeholder="Enter customer name">
                                    </div>

                                    <div class="mb-3">
                                        <label for="quantity" class="form-label">📊 Quantity</label>
                                        <input type="number" class="form-control" id="quantity" name="quantity" required min="1">
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="note" class="form-label">📝 Note</label>
                                <textarea class="form-control" id="note" name="note" rows="2"></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"><i class="bi bi-x-circle"></i> Close</button>
                    <button type="submit" class="btn btn-primary"><i class="bi bi-check-circle"></i> Save Transaction</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- JavaScript untuk menampilkan input Customer Name -->
<script>
    function toggleCustomerName() {
        let transactionType = document.getElementById('type').value;
        let customerField = document.getElementById('customerNameField');

        if (transactionType === 'out') {
            customerField.style.display = "block"; // Menampilkan input
        } else {
            customerField.style.display = "none"; // Menyembunyikan input
        }
    }

    // Menjalankan fungsi saat modal dibuka untuk memastikan input dalam kondisi benar
    document.addEventListener('DOMContentLoaded', function () {
        let typeSelect = document.getElementById('type');
        typeSelect.addEventListener('change', toggleCustomerName);
    });
</script>
