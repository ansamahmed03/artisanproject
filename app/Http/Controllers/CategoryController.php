<?php

namespace App\Http\Controllers;

use App\Models\Category;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::orderBy('id','desc')->paginate(10);

        return response()->view('cms.category.index' , compact('categories'));


    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
          return response()->view('cms.category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //

        $validator = Validator::make($request->all(),[
            'name'=> 'required |string|min:3|max:20',

            'description'=> 'required|string|min:10',

        ],[
            'name.required' => 'يرجى إدخال اسم التصنيف',
             'name.min' => 'الاسم يجب أن يكون 3 حروف على الأقل',


              'description.required'   => 'الوصف مطلوب',
              'description.min'   => 'الوصف يجب أن يكون 10 حروف على الأقل',


        ]

        );

        if($validator->fails()){
            return response()->json([
                'icon'=>'error' ,
                'title' => $validator->getMessageBag()->first(),

            ], 400);


        }else{


        $categories = new Category();
        $categories->name = $request->get('name');
        $categories->description = $request->input('description');


        $isSaved = $categories->save();
        return response()->json( [
             'icon'=>'success' ,
                'title' =>'created is succeful',

            ],200);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $categories = Category::findOrFail($id);
    return response()->view('cms.category.show', compact('categories'));
    //     //
    //    $categories = Category::findOrFail($id); // جلب الكائن من قاعدة البيانات
    // // return view('cms.category.show', compact('categories'));
    // return response()->view('cms.category.show' , compact('categories'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
         $categories = Category::findOrFail($id);
        return response()->view('cms.category.edit' , compact('categories'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
           $validator = Validator($request->all(),[
            'name'=> 'required |string|min:3|max:20',
            'description' => 'required|string|min:10',
        ]);
        if(!$validator->fails()){
           $categories = Category::findOrFail($id);
           $categories->name = $request->get('name');
           $categories->description = $request->input('description');
           $isUpdated = $categories->save();

             if ($isUpdated) {
            return response()->json([
                'icon' => 'success',
                'title' => 'updated succefully',
                'redirect' => route('categories.index')
            ], 200);
        } else {
            return response()->json([
                'icon' => 'error',
                'title' => 'failed'
            ], 400);
        }

        }else{
             return response()->json([
                'icon'=>'error' ,
                'title' => $validator->getMessageBag()->first(),

            ], 400);
        }}








    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //

         $categories=Category::destroy($id);
    }
}
