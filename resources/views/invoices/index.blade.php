@extends('layouts.app')

@section('title', 'Invoices')

@section('content')
<div class="container">
    <div class="row mb-4 align-items-center">
        <div class="col-md-6">
            <h3 class="mb-0"><i class="bi bi-receipt"></i> Invoices</h3>
        </div>

        <!-- Form Search -->
        <div class="col-md-6 text-end">
            <form action="{{ route('invoices.index') }}" method="GET" class="d-flex align-items-center">
                <div class="input-group input-group-sm">
                    <input type="text" name="search" class="form-control rounded-pill"
                           placeholder="🔍 Search invoice..." value="{{ request('search') }}">
                    <button type="submit" class="btn btn-secondary rounded-pill ms-2">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabs untuk Memisahkan Invoice Masuk & Keluar -->
    <ul class="nav nav-tabs" id="invoiceTabs">
        <li class="nav-item">
            <a class="nav-link active" id="out-tab" data-bs-toggle="tab" href="#out">Stock Out (Sales)</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="in-tab" data-bs-toggle="tab" href="#in">Stock In (Receiving)</a>
        </li>
    </ul>

    <div class="tab-content mt-3">
        <!-- **Invoice untuk Stock Out (Sales)** -->
        <div class="tab-pane fade show active" id="out">
            <h4 class="mb-3">Stock Out (Sales)</h4>
            <div class="table-responsive">
                <table class="table table-hover table-bordered align-middle text-center">
                    <thead class="table-dark">
                        <tr>
                            <th>Invoice #</th>
                            <th>Customer</th>
                            <th>Total Amount</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($invoices->whereNotNull('customer_name') as $invoice)
                            <tr>
                                <td>{{ $invoice->invoice_number }}</td>
                                <td>{{ $invoice->customer_name }}</td>
                                <td>Rp {{ number_format($invoice->total_amount, 2) }}</td>
                                <td>{{ $invoice->date->format('d M Y') }}</td>
                                <td>
                                    <a href="{{ route('invoices.generatePdf', $invoice->id) }}"
                                       class="btn btn-sm btn-outline-primary rounded-pill" target="_blank">
                                        <i class="bi bi-file-earmark-pdf"></i> Download
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">No stock out invoices found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- **Invoice untuk Stock In (Receiving)** -->
        <div class="tab-pane fade" id="in">
            <h4 class="mb-3">Stock In (Receiving)</h4>
            <div class="table-responsive">
                <table class="table table-hover table-bordered align-middle text-center">
                    <thead class="table-dark">
                        <tr>
                            <th>Invoice #</th>
                            <th>Receiver</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($invoices->whereNotNull('receiver_name') as $invoice)
                            <tr>
                                <td>{{ $invoice->invoice_number }}</td>
                                <td>{{ $invoice->receiver_name }}</td>
                                <td>{{ $invoice->date->format('d M Y') }}</td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">No stock in invoices found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-3">
        {{ $invoices->links('pagination::bootstrap-5') }}
    </div>
</div>

<!-- Bootstrap Tabs Script -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        var tabEl = document.querySelectorAll("#invoiceTabs a");
        tabEl.forEach(function (tab) {
            tab.addEventListener("click", function (event) {
                event.preventDefault();
                var tabId = this.getAttribute("href").substring(1);
                document.querySelectorAll(".tab-pane").forEach(function (pane) {
                    pane.classList.remove("show", "active");
                });
                document.getElementById(tabId).classList.add("show", "active");

                document.querySelectorAll("#invoiceTabs a").forEach(function (nav) {
                    nav.classList.remove("active");
                });
                this.classList.add("active");
            });
        });
    });
</script>

@endsection
