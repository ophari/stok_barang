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
                <div class="col-md-3">
                    <label for="type" class="form-label">Transaction Type</label>
                    <select class="form-select" name="type">
                        <option value="">All</option>
                        <option value="in" {{ request('type') == 'in' ? 'selected' : '' }}>Stock In</option>
                        <option value="out" {{ request('type') == 'out' ? 'selected' : '' }}>Stock Out</option>
                    </select>
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100"><i class="bi bi-search"></i> Search</button>
                </div>
            </form>

            <!-- Transaction Table -->
            <div class="table-responsive">
                <table class="table table-hover table-bordered align-middle text-center">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Date</th>
                            <th>Product</th>
                            <th>Type</th>
                            <th>Quantity</th>
                            <th>Customer Name</th>
                            <th>Address</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($transactions as $index => $transaction)
                        <tr>
                            <td>{{ $transactions->firstItem() + $index }}</td>
                            <td>{{ $transaction->created_at->format('d M Y') }}</td>
                            <td>{{ $transaction->product->name ?? '-' }}</td>
                            <td>
                                <span class="badge {{ $transaction->type == 'in' ? 'bg-success' : 'bg-danger' }}">
                                    {{ ucfirst($transaction->type) }}
                                </span>
                            </td>
                            <td>{{ $transaction->quantity }}</td>
                            <td>{{ $transaction->invoice->customer_name ?? '-' }}</td>
                            <td>{{ $transaction->invoice->address ?? '-' }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">No transactions found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center">
                {{ $transactions->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>
@endsection
