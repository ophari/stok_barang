<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Exception;

class CategoryController extends Controller
{
    public function index()
    {
        try {
            $categories = Category::all();
            return view('categories.index', compact('categories'));
        } catch (Exception $e) {
            return redirect()->route('categories.index')->with('error', 'Failed to load categories: ' . $e->getMessage());
        }
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:100|unique:categories'
            ]);

            Category::create($request->all());
            return redirect()->route('categories.index')->with('success', 'Category created successfully.');
        } catch (Exception $e) {
            return redirect()->route('categories.create')->with('error', 'Failed to create category: ' . $e->getMessage());
        }
    }

    public function show(Category $category)
    {
        return view('categories.show', compact('category'));
    }

    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        try {
            $request->validate([
                'name' => 'required'
            ]);

            $category->update($request->all());
            return redirect()->route('categories.index')->with('success', 'Category updated successfully.');
        } catch (Exception $e) {
            return redirect()->route('categories.edit', $category->id)->with('error', 'Failed to update category: ' . $e->getMessage());
        }
    }

    public function destroy(Category $category)
    {
        try {
            $category->delete();
            return redirect()->route('categories.index')->with('success', 'Category deleted successfully.');
        } catch (Exception $e) {
            return redirect()->route('categories.index')->with('error', 'Failed to delete category: ' . $e->getMessage());
        }
    }
}
