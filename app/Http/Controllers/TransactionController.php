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
        $transactions = Transaction::with('product', 'user', 'invoice')->paginate(3); // Menampilkan 3 transaksi per halaman
        $products = Product::all();
        
        return view('transactions.index', compact('transactions', 'products'));
    }
    

    public function store(Request $request)
{
    $request->validate([
        'product_id' => 'required|exists:products,id',
        'type' => 'required|in:in,out',
        'quantity' => 'required|integer|min:1',
        'customer_name' => 'nullable|required_if:type,out|string|max:150',
        'receiver_name' => 'nullable|required_if:type,in|string|max:150',
        'address' => 'required|string|max:255',
        'note' => 'nullable|string',
    ]);

    $product = Product::find($request->product_id);

    if (!$product) {
        return redirect()->route('transactions.index')->with('error', 'Product not found.');
    }

    $subtotal = $product->price * $request->quantity;

    // Buat Invoice terlebih dahulu
    $invoice = Invoice::create([
        'invoice_number' => 'INV-' . now()->format('YmdHis'),
        'user_id' => Auth::id(),
        'customer_name' => $request->type == 'out' ? $request->customer_name ?? 'Walk-in Customer' : null,
        'receiver_name' => $request->type == 'in' ? $request->receiver_name : null,
        'total_amount' => $subtotal, // **Tambahkan Total Amount**
        'date' => now(),
    ]);

    // Buat Invoice Detail
    InvoiceDetail::create([
        'invoice_id' => $invoice->id,
        'product_id' => $product->id,
        'quantity' => $request->quantity,
        'price' => $product->price,
        'subtotal' => $subtotal,
    ]);

    if ($request->type == 'out') {
        if ($product->stock >= $request->quantity) {
            $product->decrement('stock', $request->quantity);

            // Simpan transaksi stok keluar
            Transaction::create([
                'product_id' => $product->id,
                'type' => 'out',
                'quantity' => $request->quantity,
                'note' => $request->note,
                'user_id' => Auth::id(),
                'invoice_id' => $invoice->id,
                'address' => $request->address,
            ]);

            return redirect()->route('transactions.index')->with('success', 'Transaction recorded successfully.');
        } else {
            return redirect()->route('transactions.index')->with('error', 'Not enough stock available.');
        }
    }

    // Jika Stock In, tambahkan stok
    $product->increment('stock', $request->quantity);

    // Simpan transaksi stok masuk
    Transaction::create([
        'product_id' => $product->id,
        'type' => 'in',
        'quantity' => $request->quantity,
        'note' => $request->note,
        'user_id' => Auth::id(),
        'invoice_id' => $invoice->id,
        'address' => $request->address,
    ]);

    return redirect()->route('transactions.index')->with('success', 'Stock added successfully.');
}




    public function generatePdf($invoice_id)
    {
        $invoice = Invoice::with('invoiceDetails.product')->findOrFail($invoice_id);
        $pdf = Pdf::loadView('invoices.pdf', compact('invoice'));
        return $pdf->stream('invoice-' . $invoice->invoice_number . '.pdf');
    }

    public function viewTransaction(Transaction $transaction)
{
    return view('transactions.view', compact('transaction'));
}

}

