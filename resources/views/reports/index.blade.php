@extends('layouts.app')

@section('title', 'Transaction Report')

@section('content')
<div class="container">
    <div class="card shadow-sm border-0 rounded">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0"><i class="bi bi-clipboard-data"></i> Transaction Report</h5>
        </div>

        <div class="card-body">
            <!-- Filter Form -->
            <form action="{{ route('reports.index') }}" method="GET" class="row g-3 mb-3">
                <div class="col-md-3">
                    <label for="date_from" class="form-label">From</label>
                    <input type="date" class="form-control" name="date_from" value="{{ request('date_from') }}">
                </div>
                <div class="col-md-3">
                    <label for="date_to" class="form-label">To</label>
                    <input type="date" class="form-control" name="date_to" value="{{ request('date_to') }}">
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100"><i class="bi bi-search"></i> Search</button>
                </div>
            </form>

            <!-- Tabs untuk Stock In & Stock Out -->
            <ul class="nav nav-tabs" id="transactionTabs">
                <li class="nav-item">
                    <a class="nav-link active" id="out-tab" data-bs-toggle="tab" href="#out">Stock Out Report</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="in-tab" data-bs-toggle="tab" href="#in">Stock In Report</a>
                </li>
            </ul>

            <div class="tab-content mt-3">
                <!-- **Stock Out Report** -->
                <div class="tab-pane fade show active" id="out">
                    <h4 class="mb-3">Stock Out Report</h4>
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered align-middle text-center">
                            <thead class="table-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Date</th>
                                    <th>Product</th>
                                    <th>Quantity</th>
                                    <th>Customer Name</th>
                                    <th>Address</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($transactions->where('type', 'out') as $index => $transaction)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $transaction->created_at->format('d M Y') }}</td>
                                    <td>{{ $transaction->product->name ?? '-' }}</td>
                                    <td>{{ $transaction->quantity }}</td>
                                    <td>{{ $transaction->invoice->customer_name ?? '-' }}</td>
                                    <td>{{ $transaction->address ?? '-' }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted">No stock out transactions found.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- **Stock In Report** -->
                <div class="tab-pane fade" id="in">
                    <h4 class="mb-3">Stock In Report</h4>
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered align-middle text-center">
                            <thead class="table-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Date</th>
                                    <th>Product</th>
                                    <th>Quantity</th>
                                    <th>Receiver Name</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($transactions->where('type', 'in') as $index => $transaction)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $transaction->created_at->format('d M Y') }}</td>
                                    <td>{{ $transaction->product->name ?? '-' }}</td>
                                    <td>{{ $transaction->quantity }}</td>
                                    <td>{{ $transaction->invoice->receiver_name ?? '-' }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted">No stock in transactions found.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-3">
                {{ $transactions->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap Tabs Script -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        var tabEl = document.querySelectorAll("#transactionTabs a");
        tabEl.forEach(function (tab) {
            tab.addEventListener("click", function (event) {
                event.preventDefault();
                var tabId = this.getAttribute("href").substring(1);
                document.querySelectorAll(".tab-pane").forEach(function (pane) {
                    pane.classList.remove("show", "active");
                });
                document.getElementById(tabId).classList.add("show", "active");

                document.querySelectorAll("#transactionTabs a").forEach(function (nav) {
                    nav.classList.remove("active");
                });
                this.classList.add("active");
            });
        });
    });
</script>

@endsection
