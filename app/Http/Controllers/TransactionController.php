<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with('product', 'user')->get();
        return view('transactions.index', compact('transactions'));
    }

    public function create()
    {
        $products = Product::all();
        return view('transactions.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'type' => 'required|in:in,out',
            'quantity' => 'required|integer|min:1',
            'note' => 'nullable|string',
        ]);

        $transaction = new Transaction($request->all());
        $transaction->user_id = Auth::id();
        $transaction->save();

        if ($transaction->type == 'out') {
            $product = Product::find($request->product_id);
            $product->stock -= $request->quantity;
            $product->save();
        }

        if ($transaction->type == 'in') {
            $product = Product::find($request->product_id);
            $product->stock += $request->quantity;
            $product->save();
        }

        return redirect()->route('transactions.index')->with('success', 'Transaction recorded successfully.');
    }
}
