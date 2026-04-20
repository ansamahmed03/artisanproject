<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AddressController extends Controller
{
    public function index()
    {
     $addresses = Address::with(['city' => function($q) {
    $q->withTrashed();
}])
->orderBy('id', 'desc')
->simplePaginate(10);
        return response()->view('cms.address.index', compact('addresses'));
    }

    public function create()
    {
        $cities    = City::all();
    $countries = \App\Models\Country::all();
    return response()->view('cms.address.create', compact('cities', 'countries'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'street'      => 'required|string|min:3|max:45',
            'postal_code' => 'nullable|string|max:45',
            'is_default'  => 'nullable|boolean',
            'city_id'     => 'required|integer|exists:cities,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'icon'  => 'error',
                'title' => $validator->getMessageBag()->first(),
            ], 400);
        }

        $address              = new Address();
        $address->street      = $request->street;
        $address->postal_code = $request->postal_code;
        $address->is_default  = $request->has('is_default') ? 1 : 0;
        $address->city_id     = $request->city_id;
        $isSaved = $address->save();

        if ($isSaved) {
            return response()->json([
                'icon'  => 'success',
                'title' => 'Address created successfully',
            ], 200);
        } else {
            return response()->json([
                'icon'  => 'error',
                'title' => 'Something went wrong',
            ], 500);
        }
    }

    public function show($id)
{
    $address = Address::with(['city' => function($q) {
        $q->withTrashed()->with(['country' => function($q) {
            $q->withTrashed();
        }]);
    }])->findOrFail($id);

    return response()->view('cms.address.show', compact('address'));
}

    public function edit($id)
{
    $address   = Address::with(['city' => function($q) {
        $q->withTrashed()->with(['country' => function($q) {
            $q->withTrashed();
        }]);
    }])->findOrFail($id);

    $countries = \App\Models\Country::all();
    return response()->view('cms.address.edit', compact('address', 'countries'));
}

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'street'      => 'required|string|min:3|max:45',
            'postal_code' => 'nullable|string|max:45',
            'is_default'  => 'nullable|boolean',
            'city_id'     => 'required|integer|exists:cities,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'icon'  => 'error',
                'title' => $validator->getMessageBag()->first(),
            ], 400);
        }

        $address              = Address::findOrFail($id);
        $address->street      = $request->street;
        $address->postal_code = $request->postal_code;
        $address->is_default  = $request->has('is_default') ? 1 : 0;
        $address->city_id     = $request->city_id;
        $address->save();

        return response()->json([
            'icon'     => 'success',
            'title'    => 'Updated Successfully',
            'redirect' => route('addresses.index'),
        ], 200);
    }

    public function destroy($id)
{
    Address::destroy($id);
    return response()->json([
        'icon'  => 'success',
        'title' => 'Deleted Successfully',
    ], 200);
}

public function trashed()
{
    $addresses = Address::with(['city' => function($q) {
        $q->withTrashed();
    }])
        ->onlyTrashed()
        ->orderBy('deleted_at', 'desc')
        ->get();
    return response()->view('cms.address.trashed', compact('addresses'));
}

public function restore($id)
{
    Address::onlyTrashed()->findOrFail($id)->restore();
    return back()->with('success', 'Restored Successfully');
}

public function force($id)
{
    Address::onlyTrashed()->findOrFail($id)->forceDelete();
    return back()->with('success', 'Deleted Successfully');
}

public function forceAll()
{
    Address::onlyTrashed()->forceDelete();
    return back()->with('success', 'All Deleted Successfully');
}
}
