<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Stock;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index()
    {
        $products = Product::with('category', 'stock')->get();

        return view('products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        $stocks = Stock::all();

        return view('products.create', compact('categories', 'stocks'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name'        => 'required',
            'price'       => 'required|numeric',
            'sku'         => 'required|unique:products',
            'category_id' => 'required|exists:categories,id',
            'stock_id'    => 'required|exists:stocks,id',
        ]);

        $product = Product::create($validatedData);

        return redirect()->route('products.index')
            ->with('success', 'Product created successfully.');
    }

    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        $stocks = Stock::all();

        return view('welcome', compact('product', 'categories', 'stocks'));
    }

    public function update(Request $request, Product $product)
    {
        $validatedData = $request->validate([
            'name'        => 'required',
            'price'       => 'required|numeric',
            'sku'         => 'required|unique:products,sku,'.$product->id,
            'category_id' => 'required|exists:categories,id',
            'stock_id'    => 'required|exists:stocks,id',
        ]);

        $product->update($validatedData);

        return redirect()->route('products.index')
            ->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index')
            ->with('success', 'Product deleted successfully.');
    }

    public function search(Request $request)
    {
        $query = $request->input('query');

        $products = Product::with('category', 'stock')
            ->where('name', 'like', '%'.$query.'%')
            ->orWhere('sku', 'like', '%'.$query.'%')
            ->get();

        return view('products.index', compact('products'));
    }
}
