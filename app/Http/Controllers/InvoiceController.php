<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Product;
use App\Models\InvoiceDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = Invoice::with('user')->get();
        return view('invoices.index', compact('invoices'));
    }

    public function create()
    {
        $products = Product::all();
        return view('invoices.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'nullable|string|max:150',
            'products' => 'required|array',
            'products.*.id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
        ]);

        $totalAmount = 0;
        $invoice = Invoice::create([
            'invoice_number' => 'INV-' . now()->format('YmdHis'),
            'user_id' => Auth::id(),
            'customer_name' => $request->customer_name,
            'total_amount' => 0,
            'date' => now(),
        ]);

        foreach ($request->products as $item) {
            $product = Product::find($item['id']);
            $subtotal = $product->price * $item['quantity'];
            $totalAmount += $subtotal;

            InvoiceDetail::create([
                'invoice_id' => $invoice->id,
                'product_id' => $item['id'],
                'quantity' => $item['quantity'],
                'price' => $product->price,
                'subtotal' => $subtotal,
            ]);

            $product->stock -= $item['quantity'];
            $product->save();
        }

        $invoice->update(['total_amount' => $totalAmount]);

        return redirect()->route('invoices.index')->with('success', 'Invoice created successfully.');
    }

    public function generatePdf(Invoice $invoice)
    {
        $pdf = Pdf::loadView('invoices.pdf', compact('invoice'));
        return $pdf->stream('invoice-' . $invoice->invoice_number . '.pdf'); // Menampilkan PDF di browser dulu
    }

    public function show(Invoice $invoice)
{
    return view('invoices.show', compact('invoice'));
}

}
