<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WishlistController extends Controller
{
    public function index()
{
    $wishlists = Wishlist::with([
        'customer',
        'product' => fn($q) => $q->withTrashed()
    ])
    ->orderBy('id', 'desc')
    ->simplePaginate(10); // ← بدل get()

    return response()->view('cms.wishlist.index', compact('wishlists'));
}

    public function create()
    {
        $customers = Customer::all();
        $products  = Product::where('status', 'available')->get();
        return response()->view('cms.wishlist.create', compact('customers', 'products'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer_id' => 'required|integer|exists:customers,id',
            'product_id'  => 'required|integer|exists:products,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['icon' => 'error', 'title' => $validator->getMessageBag()->first()], 400);
        }

        // منع التكرار
        $exists = Wishlist::where('customer_id', $request->customer_id)
            ->where('product_id', $request->product_id)
            ->exists();

        if ($exists) {
            return response()->json(['icon' => 'error', 'title' => 'Product already in wishlist!'], 400);
        }

        $wishlist              = new Wishlist();
        $wishlist->customer_id = $request->customer_id;
        $wishlist->product_id  = $request->product_id;
        $isSaved = $wishlist->save();

        if ($isSaved) {
            return response()->json(['icon' => 'success', 'title' => 'Added to Wishlist'], 200);
        }
        return response()->json(['icon' => 'error', 'title' => 'Something went wrong'], 500);
    }



    public function show($id)
{
    $wishlist = Wishlist::with([
        'customer',
        'product' => fn($q) => $q->withTrashed() // ← أضف withTrashed
    ])->findOrFail($id);
    return response()->view('cms.wishlist.show', compact('wishlist'));
}

    public function edit($id)
    {
        $wishlist  = Wishlist::findOrFail($id);
        $customers = Customer::all();
        $products  = Product::where('status', 'available')->get();
        return response()->view('cms.wishlist.edit', compact('wishlist', 'customers', 'products'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'customer_id' => 'required|integer|exists:customers,id',
            'product_id'  => 'required|integer|exists:products,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['icon' => 'error', 'title' => $validator->getMessageBag()->first()], 400);
        }

        $wishlist              = Wishlist::findOrFail($id);
        $wishlist->customer_id = $request->customer_id;
        $wishlist->product_id  = $request->product_id;
        $wishlist->save();

        return response()->json(['icon' => 'success', 'title' => 'Updated Successfully', 'redirect' => route('wishlists.index')], 200);
    }

    public function destroy($id)
    {
        Wishlist::destroy($id);
        return response()->json(['icon' => 'success', 'title' => 'Deleted Successfully'], 200);
    }

    public function trashed()
{
    $wishlists = Wishlist::with([
        'customer',
        'product' => fn($q) => $q->withTrashed()
    ])
    ->onlyTrashed()
    ->orderBy('deleted_at', 'desc')
    ->get();
    return response()->view('cms.wishlist.trashed', compact('wishlists'));
}

    public function restore($id)
    {
        Wishlist::onlyTrashed()->findOrFail($id)->restore();
        return back()->with('success', 'Restored Successfully');
    }

    public function force($id)
    {
        Wishlist::onlyTrashed()->findOrFail($id)->forceDelete();
        return back()->with('success', 'Deleted Successfully');
    }

    public function forceAll()
    {
        Wishlist::onlyTrashed()->forceDelete();
        return back()->with('success', 'All Deleted Successfully');
    }
}