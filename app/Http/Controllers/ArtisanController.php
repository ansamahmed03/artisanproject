<?php

namespace App\Http\Controllers;

use App\Models\Artisan;
use App\Models\City;
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

      $artisans = Artisan::with(['user'])->paginate(10);


        //وظيفتها ترجع فيو

        return response()->view('cms.artisan.index' , compact('artisans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //نننl
$cities = City::all(); // جلب كل المدن
    return response()->view('cms.artisan.create', compact('cities'));
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
             'city' => 'nullable|string|max:30',
            // 'city'         => 'required|string|max:30',
            'bio'          => 'required|string|min:10',
            'bank_info'    => 'required|string|min:10',
            'city_id' => 'nullable|exists:cities,id',


        ],[
    'artisan_name.required' => 'Please enter the artisan name',
    'artisan_name.min'      => 'The name must be at least 3 letters long',

    'email.required'        => ' Email address required',
    'email.email'           => 'Please enter a valid email address',
    'email.unique'          => 'This email address is already registered',

    'password.required'     => 'Password required',
    'password.min'          => 'The password must be at least 6 characters long',

    'store_name.required'   => 'Store name required',
    // 'city.required'         => 'Please specify the city',

    'bio.required'          => 'bio required',
    'bio.min'               => 'The bio must be at least 10 characters long',

    'bank_info.required'    => 'Bank details are required to guarantee your financial rights',
        ]

        );

        if($validator->fails()){
            return response()->json([
                'icon'=>'error' ,
                'title' => $validator->getMessageBag()->first(),

            ], 400);


         }else{


    //        $artisans = new Artisan;
    //        $artisans->artisan_name = $request->get('artisan_name');
    //        $artisans->email = $request->get('email');
    //        $artisans->password = $request->get('password');
    //        $artisans->store_name = $request->input('store_name');
    //        $artisans->city = $request->input('city');
    //        $artisans->bio = $request->input('bio');
    //        $artisans->bank_info = $request->input('bank_info');

    //         $isSaved = $artisans->save();
    //         return response()->json( [
    //          'icon'=>'success' ,
    //             'title' =>'created is succeful',

    //         ],200);
    //     }
    // }


         $artisans = new Artisan;
        $artisans->artisan_name = $request->get('artisan_name');
        $artisans->email        = $request->get('email');

        // ملاحظة: يفضل تشفير كلمة المرور للحماية
        $artisans->password     = Hash::make($request->get('password'));

        $artisans->store_name   = $request->input('store_name');
     if ($request->filled('city_id')) {
    $cityModel = City::find($request->city_id);
    $artisans->city_id = $cityModel->id;
    $artisans->city    = $cityModel->name; // تخزين الاسم في حقل النص
} else {
    $artisans->city_id = null;
    $artisans->city    = 'سيتي'; // القيمة الافتراضية
}
        $artisans->bio          = $request->input('bio');
        $artisans->bank_info    = $request->input('bank_info');

        $isSaved = $artisans->save();

        if ($isSaved) {
            // 2. السطر السحري: ربط هذا الأرتزان بجدول المستخدمين (Morph)
            // سيقوم لارافيل تلقائياً بتعبئة userable_id برقم الأرتزان
            // وتعبئة userable_type بمسار المودل (App\Models\Artisan)
            $artisans->user()->create([
                'name'     => $request->get('artisan_name'),
                'email'    => $request->get('email'),
                'password' => Hash::make($request->get('password')),
            ]);
                 $artisans->assignRole('artisan');
            return response()->json([
                'icon'  => 'success',
                'title' => 'Account and artisan created successfully',
            ], 200);
        } else {
            return response()->json([
                'icon'  => 'error',
                'title' => 'Data saving failed',
            ], 500);
        }
    }}

    /**
     * Display the specified resource.
     */
    public function show($guard, $id)
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
    $cities = City::all(); // <-- لازم تكون موجودة
    return response()->view('cms.artisan.edit', compact('artisans', 'cities'));
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
            'city_id'      => 'nullable|exists:cities,id',
            'bio'          => 'required|string|min:10',
            'bank_info'    => 'required|string|min:10',
           'city' => 'nullable|string|max:30',
        ]);
        if(!$validator->fails()){

             $artisans = Artisan::findOrFail($id);
             $artisans->artisan_name = $request->get('artisan_name');
             $artisans->email = $request->get('email');

            if ($request->has('password') && !empty($request->get('password'))) {
             $artisans->password = Hash::make($request->get('password'));
             }
            $artisans->store_name = $request->input('store_name');
            // $artisans->city = $request->input('city');
            if ($request->filled('city_id')) {
        $cityModel = City::find($request->city_id);
        $artisans->city_id = $cityModel->id;
        $artisans->city    = $cityModel->name; // تحديث الاسم النصي بناءً على الاختيار
    } else {
        $artisans->city_id = null;
        $artisans->city    = 'سيتي'; // القيمة الافتراضية
    }
            $artisans->bio = $request->input('bio');
            $artisans->bank_info = $request->input('bank_info');


            $isUpdated = $artisans->save();
                            //     return response()->json([
                           //             'icon'  => $isUpdated ? 'success' : 'error',
                            //             'title' => $isUpdated ? 'تم التحديث بنجاح' : 'فشل التحديث'
                            //         ], $isUpdated ? 200 : 400);
                            // return ['redirect'=>route('cms.Artisan.artisans.edit')];
             if ($isUpdated) {
                if ($artisans->user) {
                $userData = [
                    'name'  => $request->get('artisan_name'),
                    'email' => $request->get('email'),
                ];

                if (isset($newPassword)) {
                    $userData['password'] = $newPassword;
                }

                $artisans->user->update($userData);
            }
              return response()->json([
                'icon' => 'success',
                'title' => 'updated succefully',
               'redirect' => route('artisans.index', ['guard' => 'Admin'])
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
   $artisan = Artisan::findOrFail($id);

    // حذف اليوزر اللي هو ارتزان
    if ($artisan->user) {
        $artisan->user->delete();
    }

    // حذف ارتزان
    $isDeleted = $artisan->delete();


    if ($isDeleted) {
        return response()->json([
            'icon' => 'success',
            'title' => 'Deleted successfully'
        ], 200);
    } else {
        return response()->json([
            'icon' => 'error',
            'title' => 'Deletion failed'
        ], 400);
    }
    }

       public function trashed() {
    $artisans = Artisan::onlyTrashed()->get();
    return response()->view('cms.artisan.trashed', compact('artisans'));
}

public function restore($id) {
    $artisan = Artisan::withTrashed()->findOrFail($id);
    $artisan->restore();
    return redirect()->back()->with('success', 'تمت استعادة المسؤول بنجاح');
    // return response()->json(['icon' => 'success', 'title' => 'تم الاسترجاع بنجاح'], 200);
}
public function force($id) {
    $artisan = Artisan::withTrashed()->findOrFail($id);
    $artisan->forceDelete();
    return response()->json(['icon' => 'success', 'title' => 'تم الحذف النهائي بنجاح'], 200);
}
public function forceAll() {
    // جلب كل الأدمنز المحذوفين مع اليوزرز تبعهم
    $artisans = Artisan::onlyTrashed()->get();

    foreach($artisans as $artisan) {
        // حذف اليوزر المرتبط في جدول users (إذا كان موجوداً)
        if($artisan->user) {
            $artisan->user()->forceDelete();
        }
        // حذف الأدمن نفسه نهائياً
        $artisan->forceDelete();
    }

    // return response()->json(['icon' => 'success', 'title' => 'تم تفريغ السلة وحذف الحسابات المرتبطة نهائياً'], 200);
    return redirect()->back()->with('success', 'تم إفراغ البيانات بنجاح');
}



    }
