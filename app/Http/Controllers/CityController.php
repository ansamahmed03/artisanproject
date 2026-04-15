<?php

namespace App\Http\Controllers;
use App\Models\City;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CityController extends Controller
{
    public function index()
    {
        $cities = City::with('country')->orderBy('id', 'desc')->withoutTrashed()->simplePaginate(10); // ✅ Capital C
        return response()->view('cms.city.index', compact('cities'));
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
        'name'            => 'required|string|min:3|max:45',
        'price'           => 'required|numeric|min:0',
        'description'     => 'required|string|min:5',
        'stock_quantity'  => 'required|integer|min:0',
        'artisans_id'     => 'required|integer|exists:artisans,id',
        'categories_id'   => 'required|integer|exists:categories,id',
        'status'          => 'required|in:active,inactive',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'icon'  => 'error',
            'title' => $validator->getMessageBag()->first(),
        ], 400);
    }

    $product = new Product();
    $product->name            = $request->name;
    $product->price           = $request->price;
    $product->description     = $request->description;
    $product->stock_quantity  = $request->stock_quantity;
    $product->artisans_id     = $request->artisans_id;
    $product->categories_id   = $request->categories_id;
    $product->status          = $request->status;

    $isSaved = $product->save();

    if ($isSaved) {
        return response()->json([
            'icon'  => 'success',
            'title' => 'Product created successfully',
        ], 200);
    } else {
        return response()->json([
            'icon'  => 'error',
            'title' => 'Failed to create product',
        ], 500);
    }
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

    public function destroy(string $id)
    {
        City::destroy($id);

        return response()->json([
            'icon'    => 'success',
            'title'   => 'Deleted Successfully',
        ], 200);
    }

      public function trashed()
    {
        //

       $cities = City::onlyTrashed()->orderBy('deleted_at','desc')->get();

       return response()->view('cms.city.trashed', compact('cities'));
    }


  public function restore($id)
    {
       $cities = City::onlyTrashed()->findOrFail($id)-> restore();

       return back()->with('success','Success');
    }



      public function force($id)
    {
       $cities = City::onlyTrashed()->findOrFail($id)-> forceDelete();

       return back()->with('success','Success');
    }

          public function forceAll()
    {
       $cities = City::onlyTrashed()->forceDelete();

       return back()->with('success','Success');
    }


}
