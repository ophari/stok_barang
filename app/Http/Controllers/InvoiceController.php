<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Product;
use App\Models\InvoiceDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;

class InvoiceController extends Controller
{
    public function index(Request $request)
    {
        try {
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
        } catch (Exception $e) {
            return redirect()->route('invoices.index')->with('error', 'Failed to load invoices: ' . $e->getMessage());
        }
    }


    public function generatePdf(Invoice $invoice)
    {
        try {
            $pdf = Pdf::loadView('invoices.pdf', compact('invoice'));
            return $pdf->stream('invoice-' . $invoice->invoice_number . '.pdf');
        } catch (Exception $e) {
            return redirect()->route('invoices.index')->with('error', 'Failed to generate PDF: ' . $e->getMessage());
        }
    }
}
