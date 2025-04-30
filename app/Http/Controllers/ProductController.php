<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $products = Product::with('category')
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', "%{$search}%")
                             ->orWhere('stock', 'like', "%{$search}%")
                             ->orWhere('price', 'like', "%{$search}%")
                             ->orWhereHas('category', function ($query) use ($search) {
                                 $query->where('name', 'like', "%{$search}%");
                             });
            })
            ->orderBy('name', 'asc')
            ->paginate(5)
            ->appends(['search' => $search]); // Menyimpan query pencarian saat pindah halaman

        $categories = Category::all();

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
        'price' => 'required|string|min:0',
        'stock' => 'required|integer|min:0',
        'description' => 'nullable|string'
    ]);

    $price = str_replace('.', '', $request->price); // Pastikan angka tanpa titik

    Product::create([
        'name' => $request->name,
        'category_id' => $request->category_id,
        'price' => $price,
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

  


}
