<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
{
    $products = Product::with('category')->get();
    $categories = Category::all(); // Mengambil semua kategori

    return view('products.index', compact('products', 'categories'));
}


    public function create()
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'category_id' => 'required|integer',
        'price' => 'required|numeric|min:0',
        'stock' => 'required|integer|min:0',
        'description' => 'nullable|string'
    ]);

    Product::create([
        'name' => $request->name,
        'category_id' => $request->category_id,
        'price' => str_replace('.', '', $request->price), // Pastikan input angka tanpa titik ribuan
        'stock' => $request->stock,
        'description' => $request->description
    ]);

    return redirect()->route('products.index')->with('success', 'Product added successfully!');
}


    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:150',
            'price' => 'required|string|min:1',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'stock' => 'required|integer|min:0'
        ]);
    
        $product->update([
            'name' => $request->name,
            'stock' => $request->stock,
            'price' => intval(str_replace('.', '', $request->price)), // Hapus titik ribuan sebelum simpan ke database
            'description' => $request->description,
            'category_id' => $request->category_id,
        ]);
    
        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }
    

    

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }

    public function increaseStock(Product $product)
{
    $product->increment('stock', 1);
    
}

// public function supply(Request $request, $id)
// {
//     $product = Product::findOrFail($id);
//     $product->stock += $request->add_stock; // Tambah stok baru
//     $product->save();

//     return redirect()->route('products.index')->with('success', 'Stock updated successfully!');
// }


}
