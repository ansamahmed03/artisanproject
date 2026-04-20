<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\City;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CityController extends Controller
{
    public function index()
    {
$cities = City::with(['country' => function($q) {
    $q->withTrashed();
}])
->orderBy('id', 'desc')
->simplePaginate(10);        return response()->view('cms.city.index', compact('cities'));
    }

    public function create()
    {
        $countries = Country::all();
        return response()->view('cms.city.create', compact('countries'));
    }

    public function show($id)
{
    // جلب المدينة مع علاقة الدولة التابعة لها
    $cities = City::with('country')->findOrFail($id);

    // عرض الصفحة (تأكد من إنشاء ملف الـ blade في هذا المسار)
    return response()->view('cms.city.show', compact('cities'));
}


       public function edit($id)
    {
        $cities = City::findOrFail($id);
          $countries = Country::all();
           return response()->view('cms.city.edit', compact('cities' , 'countries'));
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'       => 'required|string|min:3|max:22|regex:/^[\pL\s\-]+$/u',
            'street' => 'required|string|min:5|max:50|regex:/^[\pL\s\-0-9]+$/u',
            'country_id' => 'required|integer|exists:countries,id',
        ], [
            'name.required'     => 'The city name is required.',
            'street.required'     => 'The street name is required.',
            'name.regex'        => 'The city name must contain only letters.',
            'name.min'          => 'The city name must be at least 3 characters.',
            'street.regex'      => 'The street name format is invalid.',
            'country_id.exists' => 'The selected country is invalid.',
        ]);

        if ($validator->fails()) {
          return response()->json([
         'icon'  => 'error',
         'title' => $validator->getMessageBag()->first(), // ← بدون errors array
    ], 400);
    }

    $city             = new City();
    $city->name       = $request->name;
    $city->street     = $request->street;
    $city->country_id = $request->country_id;
    $city->save();

    return response()->json([
        'icon'    => 'success',
        'title'   => 'Updated Successfully',
        'message' => 'City created successfully',
    ], 200);
}

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name'       => 'required|string|min:3|max:22|regex:/^[\pL\s\-]+$/u',
            'street'     => 'nullable|string|min:5|max:50|regex:/^[\pL\s\-0-9]+$/u', // ✅ نفس التصحيح
            'country_id' => 'required|integer|exists:countries,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
        'icon'  => 'error',
        'title' => $validator->getMessageBag()->first(), // ← بدون errors array
    ], 400);
        }

        $city             = City::findOrFail($id);
        $city->name       = $request->name;
        $city->street     = $request->street;
        $city->country_id = $request->country_id;
        $city->save();

        return response()->json([
            'icon'     => 'success',
            'title'    => 'Updated Successfully',
            'redirect' => route('cities.index')
        ], 200);
    }

    public function destroy($id)
{
    $city = City::findOrFail($id);

    // ترشيد الـ addresses التابعة لها
    Address::where('city_id', $id)->delete();

    $city->delete();

    return response()->json([
        'icon'  => 'success',
        'title' => 'Deleted Successfully',
    ], 200);
}


      public function trashed()
    {
        //
     $cities = City::with(['country' => function($q) {
        $q->withTrashed();
     }])
        ->onlyTrashed()
        ->orderBy('deleted_at', 'desc')
        ->get();


       return response()->view('cms.city.trashed', compact('cities'));
    }

    public function byCountry($id)
{
    $cities = City::where('country_id', $id)->get(['id', 'name', 'street']);
    return response()->json($cities);
}

  public function restore($id)
{
    $city = City::onlyTrashed()->findOrFail($id);

    // استرجع الـ addresses معها
    Address::onlyTrashed()->where('city_id', $id)->restore();

    $city->restore();

    return back()->with('success', 'Restored Successfully');
}

public function force($id)
{
    $city = City::onlyTrashed()->findOrFail($id);

    Address::onlyTrashed()->where('city_id', $id)->forceDelete();

    $city->forceDelete();

    return back()->with('success', 'Deleted Successfully');
}

public function forceAll()
{
    $cities = City::onlyTrashed()->get();
    foreach ($cities as $city) {
        Address::onlyTrashed()->where('city_id', $city->id)->forceDelete();
        $city->forceDelete();
    }

    return back()->with('success', 'All Deleted Successfully');
}


}
