<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Product;
use App\Models\Invoice;
use App\Models\InvoiceDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;

class TransactionController extends Controller
{
    public function index()
    {
        try {
            $transactions = Transaction::with('product', 'user', 'invoice')->paginate(5);
            $products = Product::all();

            return view('transactions.index', compact('transactions', 'products'));
        } catch (Exception $e) {
            return redirect()->route('transactions.index')->with('error', 'Failed to load transactions: ' . $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        try {
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
                'total_amount' => $subtotal,
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
        } catch (Exception $e) {
            return redirect()->route('transactions.index')->with('error', 'Failed to process transaction: ' . $e->getMessage());
        }
    }

    public function generatePdf($invoice_id)
{
    try {
        // Retrieve the invoice with its details
        $invoice = Invoice::with('invoiceDetails.product')->findOrFail($invoice_id);

        // Fetch the related transaction for the invoice
        $transaction = Transaction::where('invoice_id', $invoice_id)->first();

        // Generate the PDF
        $pdf = Pdf::loadView('invoices.pdf', compact('invoice', 'transaction'));

        return $pdf->stream('invoice-' . $invoice->invoice_number . '.pdf');
    } catch (\Exception $e) {
        return redirect()->route('transactions.index')->with('error', 'Failed to generate PDF: ' . $e->getMessage());
    }
}

    public function viewTransaction(Transaction $transaction)
    {
        try {
            return view('transactions.partials.view', compact('transaction'));
        } catch (Exception $e) {
            return redirect()->route('transactions.index')->with('error', 'Failed to load transaction details: ' . $e->getMessage());
        }
    }
}
