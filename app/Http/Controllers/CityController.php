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
