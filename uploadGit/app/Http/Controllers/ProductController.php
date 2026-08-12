<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->get();
        $categories = Category::all();
        return view('pos.produk', compact('products', 'categories'));
    }

    public function store(Request $request)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Akses ditolak. Hanya Admin.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ]);

        Product::create([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'price' => $request->price,
            'stock' => $request->stock,
            'sku' => 'PRD-' . rand(100, 999),
        ]);

        return redirect('/produk')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function destroy($id)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Akses ditolak. Hanya Admin.');
        }

        $product = Product::findOrFail($id);
        $product->delete();

        return redirect('/produk')->with('success', 'Produk berhasil dihapus.');
    }
}