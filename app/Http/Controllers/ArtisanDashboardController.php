<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ArtisanDashboardController extends Controller
{
    private function artisan()
    {
        return Auth::guard('artisan')->user();
    }

    public function index()
{
    $artisan    = $this->artisan()->load('products.images', 'reviews');

    $categories = Category::all();

    $orders = Order::whereHas('orderItems.product', function($q) {
                    $q->where('artisan_id', $this->artisan()->id);
                })
                ->with(['orderItems.product', 'customer'])
                ->latest()
                ->get();

    return view('frontend.artisans.dashboard', compact('artisan', 'orders', 'categories'));
}

    public function storeProduct(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'images'      => 'nullable|array',
            'images.*'    => 'image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $product = Product::create([
            'name'           => $request->name,
            'description'    => $request->description,
            'price'          => $request->price,
            'stock_quantity' => $request->stock_quantity,
            'category_id'    => $request->category_id,
            'artisan_id'     => $this->artisan()->id,
            'status'         => 'available',
        ]);

        // رفع الصور
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $i => $file) {
                $path = $file->store('product-images', 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $path,
                    'is_primary' => $i === 0 ? 1 : 0,
                ]);
            }
        }

        return back()->with('success', 'Product added successfully!');
    }

    public function destroyProduct($id)
    {
        $product = Product::where('id', $id)
                          ->where('artisan_id', $this->artisan()->id)
                          ->firstOrFail();
        $product->delete();
        return back()->with('success', 'Product deleted successfully!');
    }
}
