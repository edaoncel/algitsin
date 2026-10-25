<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class StoreController extends Controller
{
public function index(Request $request)
{
    $query = Product::with('category');

    if ($request->has('search') && $request->search != '') {
        $query->where('name', 'like', '%' . $request->search . '%');
    }

    if ($request->has('category') && $request->category != '') {
        $query->whereHas('category', function($q) use ($request) {
            $q->where('slug', $request->category);
        });
    }

    $products = $query->latest()->paginate(12);
        $productsCount = \App\Models\Product::count();
        
$categories = Category::with('products')->get();
        
        $bestSellers = Product::with('category')->where('is_best_seller', true)->latest()->take(7)->get();

    return view('store.index', compact('products', 'categories', 'bestSellers'));
}
}