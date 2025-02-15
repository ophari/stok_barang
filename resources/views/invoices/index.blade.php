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

    <!-- Tabel Invoices -->
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
                @forelse ($invoices as $invoice)
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
                        <td colspan="5" class="text-center text-muted">No invoices found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-3">
        {{ $invoices->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
