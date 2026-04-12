<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $countries = country::orderBy('id','desc')->simplePaginate(10);
        return response()->view('cms.country.index' , compact('countries'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //

        return response()->view('cms.country.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        ////validation

          $validator = Validator::make($request->all(), [

              'country_name'=> 'required|string|min:3|max:22',
               'code'=> 'required|digits:4',
          ] , [


                'country_name.required'=> 'this colum is nedded',
                'country_name.min'=> 'min 3',
                 'code.required'=> 'this colum is nedded',
          ]);


           if( $validator->fails()){
            return response()->json([
                'icon'=>'error',
                'title'=> $validator->getMessageBag()->first(),
                'errors' => $validator->errors()
                ] , 400);
           }
         else{
         $countries = new Country();
         $countries->country_name = $request->get('country_name');
         $countries->code = $request->input('code');

         $isSave = $countries->save();
           return response()->json([
            'icon'=>'success',
              'title'=> 'created is sucssesfully' ]  , 200);
          }

    }
    /**
     * Display the specified resource.
     */
    public function show( $id)
    {
        //عرض بيانات لعنصر محدد
          $countries = Country::findOrFail($id);
          return response()->view('cms.country.show', compact('countries'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
                //عرض واحهة تعديل بيانات لعنصر محدد
           $countries = Country::findOrFail($id);
           return response()->view('cms.country.edit', compact('countries'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //

        $validator = Validator::make($request->all(), [

          'country_name'=> 'required|string|min:3|max:22',
               'code'=> 'required|digits:4',
        ]);

       if ($validator->fails()) {
        return response()->json([
            'icon'   => 'error',
            'title'  => $validator->getMessageBag()->first(),
            'errors' => $validator->errors()
        ], 400);
    }

    // 3. البحث عن الدولة وتعديلها
    $country = Country::findOrFail($id);
    $country->country_name = $request->get('country_name');
    $country->code = $request->get('code');

    $isUpdated = $country->save();

    // 4. الرد عند النجاح (مع مفتاح الـ redirect ليستخدمه الـ JS)
    if ($isUpdated) {
        return response()->json([
            'icon'     => 'success',
            'title'    => 'Updated Successfully',
            'redirect' => route('countries.index')
        ], 200);
    } else {
        return response()->json([
            'icon'  => 'error',
            'title' => 'Failed to update!'
        ], 500);
    }
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $id)
    {
        //

       $countries = Country::destroy($id);
    }
}
