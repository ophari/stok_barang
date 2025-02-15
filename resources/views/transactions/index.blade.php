@extends('layouts.app')

@section('title', 'Transactions')

@section('content')
<div class="container">
    <div class="row mb-4 align-items-center">
        <div class="col-md-6">
            <h3 class="mb-0"><i class="bi bi-cart-check"></i> Transactions</h3>
        </div>
        <div class="col-md-6 text-end">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTransactionModal">
                <i class="bi bi-plus-lg"></i> Add Transaction
            </button>
        </div>
    </div>

    <!-- Filter -->
    <div class="row mb-3">
        <div class="col-md-4">
            <input type="text" id="searchTransaction" class="form-control" placeholder="🔍 Search transactions...">
        </div>
        <div class="col-md-4">
            <select id="filterType" class="form-select">
                <option value="">📂 All Types</option>
                <option value="in">📥 Stock In</option>
                <option value="out">📤 Stock Out</option>
            </select>
        </div>
    </div>

    <!-- Transactions List -->
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        @foreach($transactions as $transaction)
        <div class="col transaction-card" data-type="{{ $transaction->type }}">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h5 class="card-title text-primary">
                        <i class="bi bi-box-seam"></i> {{ $transaction->product->name }}
                    </h5> 

                    <p class="card-text">
                        <strong>Type:</strong> 
                        <span class="badge {{ $transaction->type == 'in' ? 'bg-success' : 'bg-danger' }}">
                            {{ ucfirst($transaction->type) }}
                        </span>
                    </p>
                    
                    <p class="card-text"><strong>Quantity:</strong> {{ $transaction->quantity }}</p>
                    <p class="card-text"><strong>Note:</strong> {{ $transaction->note ?? 'N/A' }}</p>
                    <p class="card-text text-muted">
                        <small><i class="bi bi-clock"></i> {{ $transaction->created_at->format('d M Y, H:i') }}</small>
                    </p>

                   <!-- Tombol Download Invoice jika Stock Out -->
                   @if($transaction->type == 'out' && $transaction->invoice_id)
                   <p><strong>Customer:</strong> {{ $transaction->invoice->customer_name }}</p>
                   <a href="{{ route('transactions.generatePdf', $transaction->invoice_id) }}" 
                      class="btn btn-sm btn-outline-primary" 
                      target="_blank" 
                      rel="noopener noreferrer">
                       <i class="bi bi-file-earmark-pdf"></i> Download Invoice
                   </a>
                   @else
                       <span class="text-muted">No Invoice</span>
                   @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
    
    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-3">
        {{ $transactions->links('pagination::simple-bootstrap-5') }}

    </div>
</div>

<!-- Modal Add Transaction -->
@include('transactions.partials.add_transaction_modal')

<!-- JavaScript for Filtering Transactions -->
<script>
    function filterTransactions() {
        let searchText = document.getElementById('searchTransaction').value.toLowerCase().trim();
        let selectedType = document.getElementById('filterType').value.trim().toLowerCase();
        let cards = document.querySelectorAll('.transaction-card');

        cards.forEach(card => {
            let productName = card.querySelector('.card-title').innerText.toLowerCase();
            let typeBadge = card.dataset.type.toLowerCase().trim();
            let matchSearch = searchText === "" || productName.includes(searchText);
            let matchType = selectedType === "" || typeBadge === selectedType;
            card.style.display = matchSearch && matchType ? '' : 'none';
        });
    }

    document.getElementById('searchTransaction').addEventListener('input', filterTransactions);
    document.getElementById('filterType').addEventListener('change', filterTransactions);

    // JavaScript for Searching Products
    document.getElementById('searchProduct').addEventListener('input', function () {
        let searchText = this.value.toLowerCase();
        let options = document.querySelectorAll('#product_id option');

        options.forEach(option => {
            let productName = option.dataset.name;
            option.style.display = productName.includes(searchText) ? "" : "none";
        });
    });
</script>
@endsection
