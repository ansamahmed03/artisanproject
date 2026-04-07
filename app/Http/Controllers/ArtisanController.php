<?php

namespace App\Http\Controllers;

use App\Models\Artisan;
//use Dotenv\Validator;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class ArtisanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $artisans = Artisan::orderBy('id', 'desc')->paginate(10);
        //وظيفتها ترجع فيو

        return response()->view('cms.artisan.index' , compact('artisans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //نننl

        return response()->view('cms.artisan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //

        $validator = Validator::make($request->all(),[
            'artisan_name'=> 'required |string|min:3|max:20',
            'email'        => 'required|email|unique:artisans,email',
            'password'     => 'required|string|min:6',
            'store_name'   => 'required|string|min:3|max:50',
            'city'         => 'required|string|max:30',
            'bio'          => 'required|string|min:10',
            'bank_info'    => 'required|string|min:10',


        ],[
            'artisan_name.required' => 'يرجى إدخال اسم الحرفي',
    'artisan_name.min'      => 'الاسم يجب أن يكون 3 حروف على الأقل',

    'email.required'        => 'البريد الإلكتروني مطلوب',
    'email.email'           => 'يرجى إدخال بريد إلكتروني صحيح',
    'email.unique'          => 'هذا البريد الإلكتروني مسجل مسبقاً',

    'password.required'     => 'كلمة المرور مطلوبة',
    'password.min'          => 'كلمة المرور يجب ألا تقل عن 6 حروف',

    'store_name.required'   => 'اسم المتجر مطلوب',
    'city.required'         => 'يرجى تحديد المدينة',

    'bio.required'          => 'السيرة الذاتية مطلوبة',
    'bio.min'               => 'السيرة الذاتية يجب أن تكون 10 حروف على الأقل',

    'bank_info.required'    => 'بيانات البنك مطلوبة لضمان حقوقك المادية',
        ]

        );

        if($validator->fails()){
            return response()->json([
                'icon'=>'error' ,
                'title' => $validator->getMessageBag()->first(),

            ], 400);


        }else{


        $artisans = new Artisan;
        $artisans->artisan_name = $request->get('artisan_name');
        $artisans->email = $request->get('email');
        $artisans->password = $request->get('password');


        $artisans->store_name = $request->input('store_name');

    $artisans->city = $request->input('city');
    $artisans->bio = $request->input('bio');
    $artisans->bank_info = $request->input('bank_info');

        $isSaved = $artisans->save();
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
        //
        $artisans = Artisan::findOrFail($id);
        return response()->view('cms.artisan.show' , compact('artisans'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
        $artisans = Artisan::findOrFail($id);
        return response()->view('cms.artisan.edit' , compact('artisans'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
        $validator = Validator($request->all(),[
             'artisan_name'=> 'required |string|min:3|max:20',
           'email' => 'required|email|unique:artisans,email,' . $id,
            'password'     => 'nullable|string|min:6',
            'store_name'   => 'required|string|min:3|max:50',
            'city'         => 'required|string|max:30',
            'bio'          => 'required|string|min:10',
            'bank_info'    => 'required|string|min:10',

        ]);
        if(!$validator->fails()){

$artisans = Artisan::findOrFail($id);
    $artisans->artisan_name = $request->get('artisan_name');
    $artisans->email = $request->get('email');

    if ($request->has('password') && !empty($request->get('password'))) {
        $artisans->password = Hash::make($request->get('password'));
    }
    $artisans->store_name = $request->input('store_name');
    $artisans->city = $request->input('city');
    $artisans->bio = $request->input('bio');
    $artisans->bank_info = $request->input('bank_info');

    $isUpdated = $artisans->save();
//     return response()->json([
//             'icon'  => $isUpdated ? 'success' : 'error',
//             'title' => $isUpdated ? 'تم التحديث بنجاح' : 'فشل التحديث'
//         ], $isUpdated ? 200 : 400);
// return ['redirect'=>route('cms.admin.artisans.edit')];
             if ($isUpdated) {
            return response()->json([
                'icon' => 'success',
                'title' => 'updated succefully',
                'redirect' => route('cms.admin.artisans.index') // هذا السطر هو الذي سيقوم بالتحويل
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
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        $artisans=Artisan::destroy($id);

    }
}
