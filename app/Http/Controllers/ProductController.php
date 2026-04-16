<?php

namespace App\Http\Controllers;

use App\Models\Artisan;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
         $products = Product::with(['category', 'artisan'])
                ->orderBy('id', 'desc')
                ->simplePaginate(10);
         return response()->view('cms.product.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
     $artisans   = Artisan::all();
    $categories = Category::all();
    return response()->view('cms.product.create', compact('artisans', 'categories'));    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
{
    $validator =  Validator::make($request->all(), [
        'name'            => 'required|string|min:3|max:45',
        'price'           => 'required|numeric|min:0',
        'description'     => 'required|string|min:5',
        'stock_quantity'  => 'required|integer|min:0',
        'artisan_id'      => 'required|integer|exists:artisans,id',
        'category_id'     => 'required|integer|exists:categories,id',
       'status'           => 'required|in:available,out_of_stock,pending',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'icon'  => 'error',
            'title' => $validator->getMessageBag()->first(),
        ], 400);
    }

    $products                   = new Product();
    $products->name             = $request->name;
    $products->price            = $request->price;
    $products->description      = $request->description;
    $products->stock_quantity   = $request->stock_quantity;
    $products->artisan_id       = $request->artisan_id;
    $products->category_id      = $request->category_id;
    $products->status           = $request->status;

    $isSaved = $products->save();

    if ($isSaved) {
        return response()->json([
            'icon'  => 'success',
            'title' => 'Product created successfully',
        ], 200);
    } else {
        return response()->json([
            'icon'  => 'error',
            'title' => $validator->errors()->first(),
        ], 500);
    }
}

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //

        $products = Product::with(['category', 'artisan'])->findOrFail($id);
        return response()->view('cms.product.show', compact('products'));
    }

    /**
     * Show the form for editing the specified resource.
     */
  public function edit($id)
{
    $products    = Product::findOrFail($id);
    $artisans   = Artisan::all();
    $categories = Category::all();
    return response()->view('cms.product.edit', compact('products', 'artisans', 'categories'));
}

    /**
     * Update the specified resource in storage.
     */
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

    $products                 = Product::findOrFail($id);
    $products->name           = $request->name;
    $products->price          = $request->price;
    $products->description    = $request->description;
    $products->stock_quantity = $request->stock_quantity;
    $products->artisan_id     = $request->artisan_id;
    $products->category_id    = $request->category_id;
    $products->status         = $request->status;
    $products->save();

    return response()->json([
        'icon'     => 'success',
        'title'    => 'Updated Successfully',
        'redirect' => route('products.index')
    ], 200);
}

    /**
     * Remove the specified resource from storage.
     */
   public function destroy($id)
{
    Product::destroy($id);

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
    Product::onlyTrashed()->findOrFail($id)->restore();
    return back()->with('success', 'Restored Successfully');
}

public function force($id)
{
    Product::onlyTrashed()->findOrFail($id)->forceDelete();
    return back()->with('success', 'Deleted Successfully');
}

public function forceAll()
{
    Product::onlyTrashed()->forceDelete();
    return back()->with('success', 'All Deleted Successfully');
}
}
