@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container">
    <!-- Statistik Utama -->
    <div class="row g-3">
        <div class="col-md-3">
            <div class="card bg-primary text-white shadow-sm">
                <div class="card-body text-center p-3">
                    <h6><i class="bi bi-box"></i> Total Products</h6>
                    <h4 class="fw-bold">{{ $totalProducts ?? 0 }}</h4>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card bg-secondary text-white shadow-sm">
                <div class="card-body text-center p-3">
                    <h6><i class="bi bi-box-seam"></i> Total Stock</h6>
                    <h4 class="fw-bold">{{ $totalStock ?? 0 }}</h4>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card bg-success text-white shadow-sm">
                <div class="card-body text-center p-3">
                    <h6><i class="bi bi-cart-check"></i> Best Selling</h6>
                    <h4 class="fw-bold">{{ $topSellingProducts->count() ?? 0 }}</h4>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card bg-danger text-white shadow-sm">
                <div class="card-body text-center p-3">
                    <h6><i class="bi bi-exclamation-triangle"></i> Low Stock</h6>
                    <h4 class="fw-bold">{{ $lowStockProducts->count() ?? 0 }}</h4>
                </div>
            </div>
        </div>
    </div> 

    <!-- Grafik Penjualan & Produk Terlaris -->
    <div class="row mt-4 g-3">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h6 class="mb-0"><i class="bi bi-bar-chart"></i> Sales Trend</h6>
                </div>
                <div class="card-body">
                    <canvas id="transactionsChart" style="height: 220px;"></canvas>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <h6 class="mb-0"><i class="bi bi-cart-check"></i> Best Selling Products</h6>
                </div>
                <div class="card-body">
                    <ul class="list-group small">
                        @forelse($topSellingProducts as $product)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span>{{ $product->product->name ?? 'Unknown' }}</span>
                                <span class="badge bg-success px-2">{{ $product->total_sold ?? 0 }} Sold</span>
                            </li>
                        @empty
                            <li class="list-group-item text-muted text-center">No best-selling products yet.</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ChartJS -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    var ctx = document.getElementById('transactionsChart').getContext('2d');
    var transactionsChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($transactionsChartLabels) !!},
            datasets: [{
                label: 'Stock Out',
                data: {!! json_encode($transactionsStockOut) !!},
                backgroundColor: 'rgba(255, 99, 132, 0.8)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
</script>
@endsection
