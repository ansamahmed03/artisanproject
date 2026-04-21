<?php

namespace App\Http\Controllers;

use App\Models\Artisan;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Review;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;        // ✅ هاي الصح
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['category', 'artisan', 'images'])
            ->orderBy('id', 'desc')
            ->simplePaginate(10);
        return response()->view('cms.product.index', compact('products'));
    }

    public function create()
    {
        $artisans   = Artisan::all();
        $categories = Category::all();
        return response()->view('cms.product.create', compact('artisans', 'categories'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'           => 'required|string|min:3|max:45',
            'price'          => 'required|numeric|min:0',
            'description'    => 'required|string|min:5',
            'stock_quantity' => 'required|integer|min:0',
            'artisan_id'     => 'required|integer|exists:artisans,id',
            'category_id'    => 'required|integer|exists:categories,id',
            'status'         => 'required|in:available,out_of_stock,pending',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'icon'  => 'error',
                'title' => $validator->getMessageBag()->first(),
            ], 400);
        }

        $product                 = new Product();
        $product->name           = $request->name;
        $product->price          = $request->price;
        $product->description    = $request->description;
        $product->stock_quantity = $request->stock_quantity;
        $product->artisan_id     = $request->artisan_id;
        $product->category_id    = $request->category_id;
        $product->status         = $request->status;
        $isSaved = $product->save();

        if ($isSaved) {
            return response()->json([
                'icon'  => 'success',
                'title' => 'Product created successfully',
            ], 200);
        }

        return response()->json([
            'icon'  => 'error',
            'title' => 'Something went wrong',
        ], 500);
    }

    public function show($id)
    {
        $products = Product::with(['category', 'artisan'])->findOrFail($id);
        return response()->view('cms.product.show', compact('products'));
    }





    public function edit($id)
    {
        $products   = Product::findOrFail($id);
        $artisans   = Artisan::all();
        $categories = Category::all();
        return response()->view('cms.product.edit', compact('products', 'artisans', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name'           => 'required|string|min:3|max:45',
            'price'          => 'required|numeric|min:0',
            'description'    => 'required|string|min:5',
            'stock_quantity' => 'required|integer|min:0',
            'artisan_id'     => 'required|integer|exists:artisans,id',
            'category_id'    => 'required|integer|exists:categories,id',
            'status'         => 'required|in:available,out_of_stock,pending',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'icon'  => 'error',
                'title' => $validator->getMessageBag()->first(),
            ], 400);
        }

        $product                 = Product::findOrFail($id);
        $product->name           = $request->name;
        $product->price          = $request->price;
        $product->description    = $request->description;
        $product->stock_quantity = $request->stock_quantity;
        $product->artisan_id     = $request->artisan_id;
        $product->category_id    = $request->category_id;
        $product->status         = $request->status;
        $product->save();

        return response()->json([
            'icon'     => 'success',
            'title'    => 'Updated Successfully',
            'redirect' => route('products.index'),
        ], 200);
    }

public function destroy($id)
{
    $product = Product::with('images')->findOrFail($id);

    // soft delete للصور
    foreach ($product->images as $image) {
        $image->delete();
    }

    // soft delete للـ wishlists
    Wishlist::where('product_id', $id)->delete();

    // soft delete للـ reviews
    Review::where('reviewable_id', $id)
          ->where('reviewable_type', Product::class)
          ->delete();

    // ✅ soft delete للـ order items اللي فيها هاد المنتج
    OrderItem::where('product_id', $id)->delete();

    // ✅ بعد ما نحذف الـ items، نعيد حساب الـ total لكل order متأثر
    $affectedOrderIds = OrderItem::withTrashed()
                        ->where('product_id', $id)
                        ->pluck('order_id')
                        ->unique();

    foreach ($affectedOrderIds as $orderId) {
        $total = OrderItem::where('order_id', $orderId)
                          ->sum(DB::raw('price * quantity'));
        Order::where('id', $orderId)->update(['total_price' => $total]);
    }

    // ✅ لو الأوردر كل الـ items فيه انحذفت، روّحه على الترشيد
    foreach ($affectedOrderIds as $orderId) {
        $hasActiveItems = OrderItem::where('order_id', $orderId)->exists();
        if (!$hasActiveItems) {
            Order::where('id', $orderId)->delete();
        }
    }

    $product->delete();

    return response()->json([
        'icon'  => 'success',
        'title' => 'Deleted Successfully',
    ], 200);
}

    public function trashed()
    {
        $products = Product::with(['category', 'artisan'])
            ->onlyTrashed()
            ->orderBy('deleted_at', 'desc')
            ->get();
        return response()->view('cms.product.trashed', compact('products'));
    }


public function restore($id)
{
    $product = Product::onlyTrashed()->findOrFail($id);

    ProductImage::onlyTrashed()->where('product_id', $id)->restore();
    Wishlist::onlyTrashed()->where('product_id', $id)->restore();
    Review::onlyTrashed()
          ->where('reviewable_id', $id)
          ->where('reviewable_type', Product::class)
          ->restore();

    // ✅ استرجع الـ order items
    OrderItem::onlyTrashed()->where('product_id', $id)->restore();

    // ✅ استرجع الـ orders اللي انحذفت بسبب هاد المنتج
    $affectedOrderIds = OrderItem::where('product_id', $id)
                        ->pluck('order_id')
                        ->unique();

    foreach ($affectedOrderIds as $orderId) {
        $order = Order::withTrashed()->find($orderId);
        if ($order && $order->trashed()) {
            $order->restore();
        }

        // أعد حساب الـ total
        $total = OrderItem::where('order_id', $orderId)
                          ->sum(DB::raw('price * quantity'));
        Order::where('id', $orderId)->update(['total_price' => $total]);
    }

    $product->restore();

    return back()->with('success', 'Restored Successfully');
}

public function force($id)
{
    $product = Product::onlyTrashed()->findOrFail($id);

    foreach ($product->images()->withTrashed()->get() as $image) {
        Storage::disk('public')->delete($image->image_path);
        $image->forceDelete();
    }

    Wishlist::onlyTrashed()->where('product_id', $id)->forceDelete();
    Review::onlyTrashed()
          ->where('reviewable_id', $id)
          ->where('reviewable_type', Product::class)
          ->forceDelete();

    // ✅ احذف الـ order items نهائياً
    OrderItem::onlyTrashed()->where('product_id', $id)->forceDelete();

    $product->forceDelete();

    return back()->with('success', 'Deleted Successfully');
}

public function forceAll()
{
    $products = Product::onlyTrashed()->get();

    foreach ($products as $product) {
        foreach ($product->images()->withTrashed()->get() as $image) {
            Storage::disk('public')->delete($image->image_path);
            $image->forceDelete();
        }

        Wishlist::onlyTrashed()->where('product_id', $product->id)->forceDelete();
        Review::onlyTrashed()
              ->where('reviewable_id', $product->id)
              ->where('reviewable_type', Product::class)
              ->forceDelete();

        // ✅ احذف الـ order items نهائياً
        OrderItem::onlyTrashed()->where('product_id', $product->id)->forceDelete();

        $product->forceDelete();
    }

    return back()->with('success', 'All Deleted Successfully');
}
}
