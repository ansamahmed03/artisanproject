<?php

namespace App\Http\Controllers;

use App\Models\Admin;
// use Illuminate\Container\Attributes\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //

        $admins=Admin::with('user')->paginate(10);


       return view('cms.admin.index', compact('admins'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $roles = \Spatie\Permission\Models\Role::where('guard_name', 'admin')->get();
        $roles = Role::where('guard_name', 'admin')->get();
        return response()->view('cms.admin.create', [
        'roles' => $roles
    ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       $validator = Validator::make($request->all(), [
        'full_name' => 'required|string|min:3|max:20',
        'email'     => 'required|email|unique:admins,email',
        'password'  => 'required|string|min:6',
        'role_id' => 'required|integer|exists:roles,id',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'icon'  => 'error',
            'title' => $validator->getMessageBag()->first(),
        ], 400);
    } else {
        $admin = new Admin();
        $admin->full_name = $request->get('full_name');
        $admin->email     = $request->get('email');
        $admin->password  = Hash::make($request->get('password'));

        $isSaved = $admin->save();

        if ($isSaved) {
            $role = Role::findOrFail($request->get('role_id'));
            $admin->assignRole($role->name);
            // هنا لارافيل سيقوم بتعبئة actor_id و actor_type تلقائياً
            $admin->user()->create([
                'name'     => $request->get('full_name'),
                'email'    => $request->get('email'),
                'password' => Hash::make($request->get('password')),
            ]);

            return response()->json([
                'icon'  => 'success',
                'title' => 'Admin created successfully ',
            ], 200);
        } else {
            return response()->json(['icon' => 'error', 'title' => 'Save failed'], 500);
        }
    }
}  // 3. إنشاء اليوزر المرتبط به (يحتوي على البيانات الشخصية والمورف)
    // $admin->user()->create([
    //     'First_name' => $request->full_name,


        // actor_id و actor_type يتم تعبئتهم تلقائياً بواسطة لارافيل هنا
    // ]);



    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
         $admins = Admin::findOrFail($id);
        return response()->view('cms.admin.show' , compact('admins'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
                $admins = Admin::findOrFail($id);
        return response()->view('cms.admin.edit' , compact('admins'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
         $validator = Validator($request->all(),[
             'full_name'=> 'required |string|min:3|max:20',
           'email' => 'required|email|unique:artisans,email,' . $id,
            'password'     => 'nullable|string|min:6',


        ]);
        if(!$validator->fails()){

             $admins = Admin::findOrFail($id);
             $admins->full_name = $request->get('full_name');
             $admins->email = $request->get('email');

            if ($request->has('password') && !empty($request->get('password'))) {
             $admins->password = Hash::make($request->get('password'));
             }


            $isUpdated = $admins->save();

             if ($isUpdated) {
                if ($admins->user) {
                $userData = [
                    'name'  => $request->get('full_name'),
                    'email' => $request->get('email'),
                ];

                if (isset($newPassword)) {
                    $userData['password'] = $newPassword;
                }

                $admins->user->update($userData);
            }
              return response()->json([
                'icon' => 'success',
                'title' => 'updated succefully',
                'redirect' => route('admins.index')
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
    public function destroy(string $id)
    {
        // $artisan = Artisan::findOrFail($id);
 $admin = Admin::findOrFail($id);

    if ($admin->user) {
        $admin->user->delete();
    }

    // حذف ارتزان
    $isDeleted = $admin->delete();


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
    $admins = Admin::onlyTrashed()->get();
    return response()->view('cms.admin.trashed', compact('admins'));
}

public function restore($id) {
    $admin = Admin::withTrashed()->findOrFail($id);
    $admin->restore();
    return redirect()->back()->with('success', 'The admin has successfully recovered');
    // return response()->json(['icon' => 'success', 'title' => 'تم الاسترجاع بنجاح'], 200);
}
public function force($id) {
    $admin = Admin::withTrashed()->findOrFail($id);
    $admin->forceDelete();
    return response()->json(['icon' => 'success', 'title' => 'Final deletion successfully completed'], 200);
}
public function forceAll() {
    // جلب كل الأدمنز المحذوفين مع اليوزرز تبعهم
    $admins = Admin::onlyTrashed()->get();

    foreach($admins as $admin) {
        // حذف اليوزر المرتبط في جدول users (إذا كان موجوداً)
        if($admin->user) {
            $admin->user()->forceDelete();
        }
        // حذف الأدمن نفسه نهائياً
        $admin->forceDelete();
    }

    // return response()->json(['icon' => 'success', 'title' => 'تم تفريغ السلة وحذف الحسابات المرتبطة نهائياً'], 200);
    return redirect()->back()->with('success', 'Data successfully erased');
}

// public function __construct()
// {
//     $this->middleware('permission:Index Admin', ['only' => ['index']]);
//     $this->middleware('permission:Create Admin', ['only' => ['create', 'store']]);
// }

}
