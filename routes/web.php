<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NavbarController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\InvoiceDetailController;
use App\Http\Controllers\Users;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

// =============================================
// 🔹 LANDING PAGE & NOTIFIKASI STOK RENDAH
// =============================================
Route::get('/', [DashboardController::class, 'index'])
    ->middleware('auth')
    ->name('Home');

Route::get('/low-stock-notifications', [NavbarController::class, 'getLowStockNotifications'])
    ->name('lowStock.notifications');

// =============================================
// 🔹 AUTENTIKASI (LARAVEL BREEZE)
// =============================================
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);
});

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

// =============================================
// 🔹 ROUTE YANG MEMERLUKAN AUTENTIKASI
// =============================================
Route::middleware('auth')->group(function () {

    // ===========================
    // 🔹 DASHBOARD
    // ===========================
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // ===========================
    // 🔹 MANAJEMEN PROFIL
    // ===========================
    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

    // ===========================
    // 🔹 MANAJEMEN KATEGORI
    // ===========================
    Route::resource('categories', CategoryController::class);

    // ===========================
    // 🔹 MANAJEMEN PRODUK
    // ===========================
    Route::resource('products', ProductController::class);
    Route::post('/products/{product}/increase-stock', [ProductController::class, 'increaseStock']);
    Route::put('/products/supply/{id}', [ProductController::class, 'supply'])->name('products.supply');

    // ===========================
    // 🔹 MANAJEMEN TRANSAKSI
    // ===========================
    Route::resource('transactions', TransactionController::class);
    Route::get('transactions/{invoice}/pdf', [TransactionController::class, 'generatePdf'])->name('transactions.generatePdf');
    Route::get('/transactions/view/{transaction}', [TransactionController::class, 'viewTransaction'])->name('transactions.view');

    // ===========================
    // 🔹 MANAJEMEN INVOICE
    // ===========================
    Route::resource('invoices', InvoiceController::class);
    Route::get('invoices/{invoice}/pdf', [InvoiceController::class, 'generatePdf'])->name('invoices.generatePdf');

    // ===========================
    // 🔹 MANAJEMEN DETAIL INVOICE
    // ===========================
    Route::prefix('invoices/{invoice}/details')->group(function () {
        Route::get('/', [InvoiceDetailController::class, 'index'])->name('invoice.details.index');
        Route::get('/create', [InvoiceDetailController::class, 'create'])->name('invoice.details.create');
        Route::post('/', [InvoiceDetailController::class, 'store'])->name('invoice.details.store');
    });

    Route::prefix('invoice-details')->group(function () {
        Route::get('{invoiceDetail}/edit', [InvoiceDetailController::class, 'edit'])->name('invoice.details.edit');
        Route::put('{invoiceDetail}', [InvoiceDetailController::class, 'update'])->name('invoice.details.update');
        Route::delete('{invoiceDetail}', [InvoiceDetailController::class, 'destroy'])->name('invoice.details.destroy');
    });

    // ===========================
    // 🔹 MANAJEMEN PENGGUNA
    // ===========================
    Route::resource('/users', Users::class);
    Route::get('/users/view/{user}', [Users::class, 'viewUser'])->name('users.view');

    // ===========================
    // 🔹 LAPORAN
    // ===========================
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');

    // ===========================
    // 🔹 TEST ROUTE (Untuk mengecek backend berjalan)
    // ===========================
    Route::get('/test', function () {
        return response()->json(['message' => 'Backend is working!']);
    });

});

// =============================================
// 🔹 MEMUAT ROUTE AUTENTIKASI BAWAAN LARAVEL BREEZE
// =============================================
require __DIR__.'/auth.php';
