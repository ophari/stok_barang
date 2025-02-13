<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\InvoiceDetailController;

Route::get('/', function () {
    return view('dashboard');
});

// Route Dashboard (hanya untuk pengguna yang sudah login & terverifikasi)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Middleware untuk semua route yang memerlukan autentikasi
Route::middleware('auth')->group(function () {
    // Profile Management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // CRUD Routes
    Route::resource('categories', CategoryController::class);
    Route::resource('products', ProductController::class);
    Route::resource('transactions', TransactionController::class);
    Route::resource('invoices', InvoiceController::class);

    // Route untuk generate PDF invoice
    Route::get('invoices/{invoice}/pdf', [InvoiceController::class, 'generatePdf'])->name('invoices.generatePdf');

    // Routes untuk Invoice Details (jika ingin edit invoice secara manual)
    Route::get('invoices/{invoice}/details', [InvoiceDetailController::class, 'index'])->name('invoice.details.index');
    Route::get('invoices/{invoice}/details/create', [InvoiceDetailController::class, 'create'])->name('invoice.details.create');
    Route::post('invoices/{invoice}/details', [InvoiceDetailController::class, 'store'])->name('invoice.details.store');
    Route::get('invoice-details/{invoiceDetail}/edit', [InvoiceDetailController::class, 'edit'])->name('invoice.details.edit');
    Route::put('invoice-details/{invoiceDetail}', [InvoiceDetailController::class, 'update'])->name('invoice.details.update');
    Route::delete('invoice-details/{invoiceDetail}', [InvoiceDetailController::class, 'destroy'])->name('invoice.details.destroy');

    // Route untuk testing (Pastikan backend berjalan)
    Route::get('/test', function () {
        return response()->json(['message' => 'Backend is working!']);
    });

    Route::post('/products/{product}/increase-stock', [ProductController::class, 'increaseStock']);

});

// Route untuk autentikasi (bawaan Laravel Breeze)
require __DIR__.'/auth.php';
