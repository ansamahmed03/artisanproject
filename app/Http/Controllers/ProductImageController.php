<?php

namespace App\Http\Controllers;

use App\Models\ProductImage;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class ProductImageController extends Controller
{
   public function index()
{
    $images = ProductImage::with([
        'product' => fn($q) => $q->withTrashed()
    ])
    ->orderBy('id', 'desc')
    ->simplePaginate(10);
    return response()->view('cms.product-image.index', compact('images'));
}

    public function create()
    {
        $products = Product::all();
        return response()->view('cms.product-image.create', compact('products'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|integer|exists:products,id',
            'image'      => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'is_primary' => 'nullable|boolean',
        ], [
            'product_id.required' => 'Please select a product.',
            'product_id.exists'   => 'The selected product is invalid.',
            'image.required'      => 'Please upload an image.',
            'image.image'         => 'The file must be an image.',
            'image.mimes'         => 'Only jpeg, png, jpg, webp are allowed.',
            'image.max'           => 'Image size must not exceed 2MB.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'icon'  => 'error',
                'title' => $validator->getMessageBag()->first(),
            ], 400);
        }

        $path = $request->file('image')->store('product-images', 'public');

        $image             = new ProductImage();
        $image->product_id = $request->product_id;
        $image->image_path = $path;
        $image->is_primary = $request->is_primary ? 1 : 0;
        $image->save();

        return response()->json([
            'icon'  => 'success',
            'title' => 'Image uploaded successfully',
        ], 200);
    }

    public function show($id)
    {
        $image = ProductImage::with('product')->findOrFail($id);
        return response()->view('cms.product-image.show', compact('image'));
    }

    public function edit($id)
    {
        $image    = ProductImage::findOrFail($id);
        $products = Product::all();
        return response()->view('cms.product-image.edit', compact('image', 'products'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|integer|exists:products,id',
            'image'      => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'is_primary' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'icon'  => 'error',
                'title' => $validator->getMessageBag()->first(),
            ], 400);
        }

        $image             = ProductImage::findOrFail($id);
        $image->product_id = $request->product_id;
        $image->is_primary = $request->is_primary ? 1 : 0;

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($image->image_path);
            $image->image_path = $request->file('image')->store('product-images', 'public');
        }

        $image->save();

        return response()->json([
            'icon'     => 'success',
            'title'    => 'Updated Successfully',
            'redirect' => route('product-images.index')
        ], 200);
    }

    public function destroy($id)
    {
        ProductImage::destroy($id);
        return response()->json([
            'icon'  => 'success',
            'title' => 'Deleted Successfully',
        ], 200);
    }

   public function trashed()
{
    $images = ProductImage::with([
        'product' => fn($q) => $q->withTrashed()
    ])
    ->onlyTrashed()
    ->orderBy('deleted_at', 'desc')
    ->get();
    return response()->view('cms.product-image.trashed', compact('images'));
}

    public function restore($id)
    {
        ProductImage::onlyTrashed()->findOrFail($id)->restore();
        return back()->with('success', 'Restored Successfully');
    }

    public function force($id)
    {
        $image = ProductImage::onlyTrashed()->findOrFail($id);
        Storage::disk('public')->delete($image->image_path);
        $image->forceDelete();
        return back()->with('success', 'Deleted Successfully');
    }

    public function forceAll()
    {
        $images = ProductImage::onlyTrashed()->get();
        foreach ($images as $image) {
            Storage::disk('public')->delete($image->image_path);
        }
        ProductImage::onlyTrashed()->forceDelete();
        return back()->with('success', 'All Deleted Successfully');
    }
}
