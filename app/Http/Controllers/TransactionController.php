<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Product;
use App\Models\Invoice;
use App\Models\InvoiceDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with('product', 'user', 'invoice')->paginate(2); // Menampilkan 6 transaksi per halaman
        $products = Product::all();
        
        return view('transactions.index', compact('transactions', 'products'));
    }
    

    public function store(Request $request)
{
    $request->validate([
        'product_id' => 'required|exists:products,id',
        'type' => 'required|in:in,out',
        'quantity' => 'required|integer|min:1',
        'customer_name' => 'nullable|string|max:150', // Tambahkan validasi untuk Customer Name
        'note' => 'nullable|string',
    ]);

    $product = Product::find($request->product_id);

    if ($request->type == 'out') {
        if ($product->stock >= $request->quantity) {
            $product->decrement('stock', $request->quantity);

            // **Buat Invoice dengan Customer Name**
            $invoice = Invoice::create([
                'invoice_number' => 'INV-' . now()->format('YmdHis'),
                'user_id' => Auth::id(),
                'customer_name' => $request->customer_name ?? 'Walk-in Customer', // Default jika kosong
                'total_amount' => $product->price * $request->quantity,
                'date' => now(),
            ]);

            InvoiceDetail::create([
                'invoice_id' => $invoice->id,
                'product_id' => $product->id,
                'quantity' => $request->quantity,
                'price' => $product->price,
                'subtotal' => $product->price * $request->quantity,
            ]);

            $transaction = Transaction::create([
                'product_id' => $product->id,
                'type' => 'out',
                'quantity' => $request->quantity,
                'note' => $request->note,
                'user_id' => Auth::id(),
                'invoice_id' => $invoice->id, // Simpan ID Invoice di transaksi
            ]);

            return redirect()->route('transactions.index')->with('success', 'Transaction recorded successfully.');
        } else {
            return redirect()->route('transactions.index')->with('error', 'Not enough stock available.');
        }
    }

    // Jika Stock In, tambahkan stok
    $product->increment('stock', $request->quantity);
    Transaction::create([
        'product_id' => $product->id,
        'type' => 'in',
        'quantity' => $request->quantity,
        'note' => $request->note,
        'user_id' => Auth::id(),
    ]);

    return redirect()->route('transactions.index')->with('success', 'Stock added successfully.');
}


    public function generatePdf($invoice_id)
    {
        $invoice = Invoice::with('invoiceDetails.product')->findOrFail($invoice_id);
        $pdf = Pdf::loadView('invoices.pdf', compact('invoice'));
        return $pdf->stream('invoice-' . $invoice->invoice_number . '.pdf');
    }
}

