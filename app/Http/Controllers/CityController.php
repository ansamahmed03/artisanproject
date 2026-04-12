<?php

namespace App\Http\Controllers;
use App\Models\City;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //

         $cities = city::orderBy('id','desc')->simplePaginate(10);
        return response()->view('cms.city.index' , compact('cities'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
                $countries = Country::all();
                return response()->view('cms.city.create' , compact('countries'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
           $validator = Validator::make($request->all(), [


            'name' => 'required|string|min:3|max:22|regex:/^[\pL\s\-]+$/u',
            'street'   => 'nullable|required|string|min:5|max:50|regex:/^[\pL\s\-0-9]+$/u',
            'country_id' => 'required|integer|exists:countries,id' , //نأكد من انه موجود في الكونتري
          ] , [

// رسائل الخطأ المخصصة
'name.required'     => 'The city name is required.',
    'name.regex'        => 'The city name must contain only letters.',
    'name.min'          => 'The city name must be at least 3 characters.',
    'street.required'   => 'The street address is required.',
    'street.regex'      => 'The street name format is invalid.',
    'country_id.exists' => 'The selected country is invalid.',
          ]);


           if( $validator->fails()){
            return response()->json([
                'icon'    => 'error',
                'title'   => 'خطأ في المدخلات',
                'message' => $validator->getMessageBag()->first(),
                'errors'  => $validator->errors()
        ], 400);
           }

         else{
         $cities = new City();
         $cities->name = $request->get('name');
         $cities->street = $request->get('street');
          $cities->country_id = $request->get('country_id');

         $isSave = $cities->save();
           return response()->json([
               'icon'=>'success',
               'title'   => 'success',
              'message'=> 'created is sucssesfully' ]  , 200);
          }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
          $cities = City::findOrFail($id);
          $countries = Country::all();
           return response()->view('cms.city.edit', compact('cities' , 'countries'));

           $countries = Country::all();

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //

           $validator = Validator::make($request->all(), [


            'name' => 'required|string|min:3|max:22|regex:/^[\pL\s\-]+$/u',
            'street'   => 'nullable|required|string|min:5|max:50|regex:/^[\pL\s\-0-9]+$/u',
            'country_id' => 'required|integer|exists:countries,id' , //نأكد من انه موجود في الكونتري
          ] , [

// رسائل الخطأ المخصصة
'name.required'     => 'The city name is required.',
    'name.regex'        => 'The city name must contain only letters.',
    'name.min'          => 'The city name must be at least 3 characters.',
    'street.required'   => 'The street address is required.',
    'street.regex'      => 'The street name format is invalid.',
    'country_id.exists' => 'The selected country is invalid.',
          ]);




           if(! $validator->fails()){
           $cities =  City::findOrFail( $id );
         $cities->name = $request->get('name');
         $cities->street = $request->get('street');
          $cities->country_id = $request->get('country_id');

       
         $isUpdate = $cities->save();
           return response()->json([
               'icon'=>'success',
               'title'   => 'success',
              'message'=> 'updated is sucssesfully' ]  , 200);

           }

         else{

               return response()->json([
                'icon'    => 'error',
                'title'   => 'خطأ في المدخلات',
                'message' => $validator->getMessageBag()->first(),
                'errors'  => $validator->errors()
        ], 400);
          }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //


      $cities = City::destroy($id);
    }
}
