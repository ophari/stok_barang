<?php

namespace App\Http\Controllers;

use App\Models\InvoiceDetail;
use Illuminate\Http\Request;
use Exception;

class InvoiceDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $invoiceDetails = InvoiceDetail::all();
            return view('invoice_details.index', compact('invoiceDetails'));
        } catch (Exception $e) {
            return redirect()->route('invoice_details.index')->with('error', 'Failed to load invoice details: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            return view('invoice_details.create');
        } catch (Exception $e) {
            return redirect()->route('invoice_details.index')->with('error', 'Failed to load create form: ' . $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'invoice_id' => 'required|exists:invoices,id',
                'product_id' => 'required|exists:products,id',
                'quantity' => 'required|integer|min:1',
                'price' => 'required|numeric|min:0',
                'subtotal' => 'required|numeric|min:0',
            ]);

            InvoiceDetail::create($request->all());

            return redirect()->route('invoice_details.index')->with('success', 'Invoice detail created successfully.');
        } catch (Exception $e) {
            return redirect()->route('invoice_details.create')->with('error', 'Failed to create invoice detail: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(InvoiceDetail $invoiceDetail)
    {
        try {
            return view('invoice_details.show', compact('invoiceDetail'));
        } catch (Exception $e) {
            return redirect()->route('invoice_details.index')->with('error', 'Failed to load invoice detail: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(InvoiceDetail $invoiceDetail)
    {
        try {
            return view('invoice_details.edit', compact('invoiceDetail'));
        } catch (Exception $e) {
            return redirect()->route('invoice_details.index')->with('error', 'Failed to load edit form: ' . $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, InvoiceDetail $invoiceDetail)
    {
        try {
            $request->validate([
                'quantity' => 'required|integer|min:1',
                'price' => 'required|numeric|min:0',
                'subtotal' => 'required|numeric|min:0',
            ]);

            $invoiceDetail->update($request->all());

            return redirect()->route('invoice_details.index')->with('success', 'Invoice detail updated successfully.');
        } catch (Exception $e) {
            return redirect()->route('invoice_details.edit', $invoiceDetail->id)->with('error', 'Failed to update invoice detail: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(InvoiceDetail $invoiceDetail)
    {
        try {
            $invoiceDetail->delete();

            return redirect()->route('invoice_details.index')->with('success', 'Invoice detail deleted successfully.');
        } catch (Exception $e) {
            return redirect()->route('invoice_details.index')->with('error', 'Failed to delete invoice detail: ' . $e->getMessage());
        }
    }
}
