<div class="modal-header bg-primary text-white">
    <h5 class="modal-title" id="transactionModalLabel">Transaction Details</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
    <p><strong>Product:</strong> {{ $transaction->product->name }}</p>
    <p><strong>Type:</strong> 
        <span class="badge {{ $transaction->type == 'in' ? 'bg-success' : 'bg-danger' }}">
            {{ ucfirst($transaction->type) }}
        </span>
    </p>
    <p><strong>Quantity:</strong> {{ $transaction->quantity }}</p>
    <p><strong>Note:</strong> {{ $transaction->note ?? 'N/A' }}</p>
    <p><strong>Date:</strong> {{ $transaction->created_at->format('d M Y, H:i') }}</p>
    <p><strong>Address:</strong> {{ $transaction->invoice->address ?? '-' }}</p>

    <!-- Jika transaksi stok keluar, tampilkan Customer -->
    @if($transaction->type == 'out')
        <p><strong>Customer:</strong> {{ $transaction->invoice->customer_name ?? '-' }}</p>
    @endif

    <!-- Jika transaksi stok masuk, tampilkan Receiver -->
    @if($transaction->type == 'in')
        <p><strong>Receiver:</strong> {{ $transaction->invoice->receiver_name ?? '-' }}</p>
    @endif

    <!-- Tombol Download Invoice jika ada -->
    @if($transaction->invoice_id)
        <a href="{{ route('transactions.generatePdf', $transaction->invoice_id) }}" 
           class="btn btn-outline-primary">
            <i class="bi bi-file-earmark-pdf"></i> Download Invoice
        </a>
    @endif
</div>
