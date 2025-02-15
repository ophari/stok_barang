<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Data ringkasan
        $totalProducts = Product::count();
        $totalCategories = Category::count();
        $totalTransactions = Transaction::count();
        $totalStock = Product::sum('stock');

        // Grafik Penjualan Harian / Bulanan (Stock Out)
        $transactionsByMonth = Transaction::selectRaw("DATE_FORMAT(created_at, '%Y-%m') as month, type, SUM(quantity) as total")
            ->groupBy('month', 'type')
            ->get()
            ->groupBy('month');

        $transactionsChartLabels = $transactionsByMonth->keys();
        $transactionsStockOut = $transactionsByMonth->map(fn ($transactions) => $transactions->where('type', 'out')->sum('total'));

        // Produk dengan Penjualan Terbanyak
        $topSellingProducts = Transaction::where('type', 'out')
            ->selectRaw('product_id, SUM(quantity) as total_sold')
            ->groupBy('product_id')
            ->orderByDesc('total_sold')
            ->with('product')
            ->limit(5)
            ->get();

        // Stok Barang yang Menipis
        $lowStockProducts = Product::where('stock', '<', 10)
            ->orderBy('stock', 'asc')
            ->limit(5)
            ->get();

        // Transaksi terbaru
        $recentTransactions = Transaction::latest()
            ->limit(5)
            ->with('product')
            ->get();

        return view('dashboard', compact(
            'totalProducts', 'totalCategories', 'totalTransactions', 'totalStock',
            'transactionsChartLabels', 'transactionsStockOut',
            'topSellingProducts', 'lowStockProducts', 'recentTransactions'
        ));
    }
}
