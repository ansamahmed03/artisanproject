<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $countries = country::withCount('City')->orderBy('id','desc')->withoutTrashed()->simplePaginate(10);
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

              'country_name'=> 'required|string|min:3|max:22|regex:/^[\pL\s\-]+$/u',
               'code'=> 'required|string|min:5|max:50|regex:/^[\pL\s\-0-9]+$/u',
          ],
           [


            'country_name.required'     => 'The country name field is required.',
            'code.required'              => 'The street name is required.',
            'country_name.regex'        => 'The country name must contain only letters.',
            'country_name.min'          => 'The country name must be at least 3 characters.',
            'code.regex'      => 'The street name format is invalid.',

          ]);


           if( $validator->fails()){
            return response()->json([
                 'icon'  => 'error',
               'title' => $validator->getMessageBag()->first(),
                ] , 400);
           }
         else{
         $countries = new Country();
         $countries->country_name = $request->get('country_name');
         $countries->code = $request->get('code');

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

        $validator = Validator::make($request->all(), [

          'country_name'=> 'required|string|min:3|max:22',
           'code'=> 'required|digits:4',
        ]);

       if ($validator->fails()) {
        return response()->json([
               'icon'  => 'error',
               'title' => $validator->getMessageBag()->first(),
        ], 400);
    }

    // 3. البحث عن الدولة وتعديلها
    $country                = Country::findOrFail($id);
    $country->country_name = $request->get('country_name');
    $country->code         = $request->get('code');

    $country->save();

        return response()->json([
            'icon'     => 'success',
            'title'    => 'Updated Successfully',
            'redirect' => route('countries.index')
        ], 200);


    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $id)
    {
        //

       $countries = Country::destroy($id);
    }


      public function trashed()
    {
        //

       $countries = Country::onlyTrashed()->orderBy('deleted_at','desc')->get();

       return response()->view('cms.country.trashed', compact('countries'));
    }


  public function restore($id)
    {
       $countries = Country::onlyTrashed()->findOrFail($id)-> restore();

       return back()->with('success','Success');
    }



      public function force($id)
    {
       $countries = Country::onlyTrashed()->findOrFail($id)-> forceDelete();

       return back()->with('success','Success');
    }

          public function forceAll()
    {
       $countries = Country::onlyTrashed()->forceDelete();

       return back()->with('success','Success');
    }


}
