<div class="modal fade" id="addTransactionModal" tabindex="-1" aria-labelledby="addTransactionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="addTransactionModalLabel">
                    <i class="bi bi-plus-circle"></i> Add New Transaction
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Form Start -->
            <form action="{{ route('transactions.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <div class="row">
                                <!-- Left Section -->
                                <div class="col-md-6">
                                    <!-- 🔍 Search & Select Product -->
                                    <div class="mb-3">
                                        <label for="searchProduct" class="form-label">🔍 Select Product</label>
                                        <div class="dropdown">
                                            <button class="btn btn-light dropdown-toggle w-100" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                                Select a Product
                                            </button>
                                            <ul class="dropdown-menu w-100" id="productDropdown">
                                                <li>
                                                    <input type="text" class="form-control mx-2 my-2" placeholder="Search product..." id="searchProduct" onkeyup="filterProducts()">
                                                </li>
                                                @foreach($products as $product)
                                                    <li>
                                                        <a class="dropdown-item product-item" href="#" data-value="{{ $product->id }}">
                                                            {{ $product->name }}
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                            <input type="hidden" name="product_id" id="selectedProduct">
                                        </div>
                                    </div>

                                    <!-- 📍 Address -->
                                    <div class="mb-3">
                                        <label for="address" class="form-label">📍 Address</label>
                                        <textarea class="form-control" id="address" name="address" rows="2" required placeholder="Enter address"></textarea>
                                    </div>
                                </div>

                                <!-- Right Section -->
                                <div class="col-md-6">
                                    <!-- 🔄 Transaction Type -->
                                    <div class="mb-3">
                                        <label for="type" class="form-label">🔄 Transaction Type</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-arrow-left-right"></i></span>
                                            <select class="form-select" id="type" name="type" required onchange="toggleTransactionFields()">
                                                <option value="in" selected>📥 Stock In</option>
                                                <option value="out">📤 Stock Out</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- 👤 Customer Name (Untuk Stock Out) -->
                                    <div class="mb-3 d-none" id="customerNameField">
                                        <label for="customer_name" class="form-label">👤 Customer Name</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-person"></i></span>
                                            <input type="text" class="form-control" id="customer_name" name="customer_name" placeholder="Enter customer name">
                                        </div>
                                    </div>

                                    <!-- 📥 Receiver Name (Untuk Stock In) -->
                                    <div class="mb-3 d-none" id="receiverNameField">
                                        <label for="receiver_name" class="form-label">📥 Receiver Name</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-person-check"></i></span>
                                            <input type="text" class="form-control" id="receiver_name" name="receiver_name" placeholder="Enter receiver name">
                                        </div>
                                    </div>

                                    <!-- 📊 Quantity -->
                                    <div class="mb-3">
                                        <label for="quantity" class="form-label">📊 Quantity</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-plus-slash-minus"></i></span>
                                            <input type="number" class="form-control" id="quantity" name="quantity" required min="1">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- 📝 Note -->
                            <div class="mb-3">
                                <label for="note" class="form-label">📝 Note</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-sticky"></i></span>
                                    <textarea class="form-control" id="note" name="note" rows="2" placeholder="Additional notes (optional)"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle"></i> Close
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle"></i> Save Transaction
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- JavaScript untuk Menampilkan Input Customer Name atau Receiver Name -->
<script>
    function toggleTransactionFields() {
        let transactionType = document.getElementById('type').value;
        let customerField = document.getElementById('customer_name');
        let receiverField = document.getElementById('receiver_name');

        if (transactionType === 'out') {
            document.getElementById('customerNameField').classList.remove("d-none");
            document.getElementById('receiverNameField').classList.add("d-none");
            receiverField.value = ''; // Reset receiver_name jika transaksi keluar
        } else {
            document.getElementById('receiverNameField').classList.remove("d-none");
            document.getElementById('customerNameField').classList.add("d-none");
            customerField.value = ''; // Reset customer_name jika transaksi masuk
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        toggleTransactionFields();
        document.getElementById('type').addEventListener('change', toggleTransactionFields);
    });

    // ✅ Fungsi untuk Filter Produk di Dropdown
    function filterProducts() {
        let input = document.getElementById("searchProduct").value.toLowerCase();
        let items = document.querySelectorAll("#productDropdown .product-item");

        items.forEach(item => {
            let text = item.textContent.toLowerCase();
            if (text.includes(input)) {
                item.style.display = "";
            } else {
                item.style.display = "none";
            }
        });
    }

    // ✅ Menyimpan Produk yang Dipilih
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll(".product-item").forEach(item => {
            item.addEventListener("click", function (e) {
                e.preventDefault();
                document.getElementById("dropdownMenuButton").textContent = this.textContent;
                document.getElementById("selectedProduct").value = this.dataset.value;
            });
        });
    });
</script>
