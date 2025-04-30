<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use Exception;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        try {
            // Ambil data transaksi dengan produk & invoice (jika ada)
            $transactions = Transaction::with(['product', 'invoice'])
                ->when($request->input('date_from'), function ($query, $dateFrom) {
                    return $query->whereDate('created_at', '>=', $dateFrom);
                })
                ->when($request->input('date_to'), function ($query, $dateTo) {
                    return $query->whereDate('created_at', '<=', $dateTo);
                })
                ->when($request->input('type'), function ($query, $type) {
                    return $query->where('type', $type);
                })
                ->orderBy('created_at', 'desc')
                ->paginate(10);

            return view('reports.index', compact('transactions'));
        } catch (Exception $e) {
            return redirect()->route('reports.index')->with('error', 'Failed to load report data: ' . $e->getMessage());
        }
    }
}
