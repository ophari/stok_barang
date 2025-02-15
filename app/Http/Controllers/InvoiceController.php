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
    public function index(Request $request)
    {
        $search = $request->input('search');

        $invoices = Invoice::when($search, function ($query, $search) {
            return $query->where('invoice_number', 'like', "%{$search}%")
                         ->orWhere('customer_name', 'like', "%{$search}%")
                         ->orWhere('total_amount', 'like', "%{$search}%");
        })
        ->orderBy('date', 'desc')
        ->paginate(10)
        ->appends(['search' => $search]); // Menjaga hasil pencarian saat berpindah halaman

        return view('invoices.index', compact('invoices'));
    }

    public function create()
    {
        $products = Product::where('stock', '>', 0)->get(); // Hanya produk yang memiliki stok
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

            if ($product->stock < $item['quantity']) {
                return redirect()->back()->with('error', 'Stock not enough for ' . $product->name);
            }

            $subtotal = $product->price * $item['quantity'];
            $totalAmount += $subtotal;

            InvoiceDetail::create([
                'invoice_id' => $invoice->id,
                'product_id' => $item['id'],
                'quantity' => $item['quantity'],
                'price' => $product->price,
                'subtotal' => $subtotal,
            ]);

            $product->decrement('stock', $item['quantity']);
        }

        $invoice->update(['total_amount' => $totalAmount]);

        return redirect()->route('invoices.index')->with('success', 'Invoice created successfully.');
    }

    public function show(Invoice $invoice)
    {
        return view('invoices.show', compact('invoice'));
    }

    public function generatePdf(Invoice $invoice)
    {
        $pdf = Pdf::loadView('invoices.pdf', compact('invoice'));
        return $pdf->stream('invoice-' . $invoice->invoice_number . '.pdf');
    }

    public function destroy(Invoice $invoice)
    {
        foreach ($invoice->invoiceDetails as $detail) {
            $product = $detail->product;
            $product->increment('stock', $detail->quantity);
        }

        $invoice->delete();

        return redirect()->route('invoices.index')->with('success', 'Invoice deleted and stock restored.');
    }
}
