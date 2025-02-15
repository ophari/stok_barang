<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\InvoiceDetailController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NavbarController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

// Landing Page
Route::get('/', function () {
    return view('dashboard');
})->middleware(['auth'])->name('home');

Route::get('/low-stock-notifications', [NavbarController::class, 'getLowStockNotifications'])
    ->name('lowStock.notifications');


// Dashboard (Hanya untuk pengguna yang sudah login & terverifikasi)
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth'])->name('dashboard');


// Autentikasi menggunakan Laravel Breeze
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);
});

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

// Middleware untuk semua rute yang memerlukan autentikasi
Route::middleware('auth')->group(function () {
    // Manajemen Profil
    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

    // Manajemen Kategori
    Route::resource('categories', CategoryController::class);

    // Manajemen Produk
    Route::resource('products', ProductController::class);
    Route::post('/products/{product}/increase-stock', [ProductController::class, 'increaseStock']);
    Route::put('/products/supply/{id}', [ProductController::class, 'supply'])->name('products.supply');

    // Manajemen Transaksi
    Route::resource('transactions', TransactionController::class);
    Route::get('transactions/{invoice}/pdf', [TransactionController::class, 'generatePdf'])->name('transactions.generatePdf'); 


    // Manajemen Invoice
    Route::resource('invoices', InvoiceController::class);
    Route::get('invoices/{invoice}/pdf', [InvoiceController::class, 'generatePdf'])->name('transactions.generatePdf');
    Route::get('invoices/{invoice}/pdf', [InvoiceController::class, 'generatePdf'])->name('invoices.generatePdf');

    

    

    // Manajemen Detail Invoice (Jika ingin edit invoice secara manual)
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

    // Route untuk testing (Pastikan backend berjalan)
    Route::get('/test', function () {
        return response()->json(['message' => 'Backend is working!']);
    });

    
});

// Memuat rute autentikasi bawaan Laravel Breeze
require __DIR__.'/auth.php';
