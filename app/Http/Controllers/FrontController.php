<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Team;
use Illuminate\Http\Request;
class FrontController extends Controller
{
    public function home()
    {
       $featuredProducts = Product::with(['category', 'artisan', 'images'])
    ->where('status', 'available')
    ->latest()->take(4)->get();

$categories = Category::withCount(['products' => function($q) {
    $q->where('status', 'available');
}])->get();

        return view('frontend.home', compact('featuredProducts', 'categories'));
    }
    public function products(Request $request)
{
    $products = Product::with(['category', 'artisan'])
        ->where('status', 'available')
        ->when($request->category, fn($q) => $q->where('category_id', $request->category))
        ->when($request->sort == 'price_asc', fn($q) => $q->orderBy('price', 'asc'))
->when($request->sort == 'price_desc', fn($q) => $q->orderBy('price', 'desc'))
->when(!$request->sort, fn($q) => $q->latest())
        ->paginate(12);

    $categories = Category::all();

    return view('frontend.products.index', compact('products', 'categories'));
}

public function productShow($id)
{
    $product = Product::with([
        'category',
        'artisan' => fn($q) => $q->withTrashed(),
        'images',
        'reviews'
    ])->findOrFail($id);

    return view('frontend.products.show', compact('product'));
}
}
