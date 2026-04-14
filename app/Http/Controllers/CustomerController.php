<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
          $customers=Customer::with('user')->paginate(10);


       return view('cms.customer.index', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
          return response()->view('cms.customer.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //

         $validator = Validator::make($request->all(), [
        'name' => 'required|string|min:3|max:20',
        'email'     => 'required|email|unique:admins,email',
        'password'  => 'required|string|min:6',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'icon'  => 'error',
            'title' => $validator->getMessageBag()->first(),
        ], 400);
    } else {
        $customer = new Customer();
        $customer->name = $request->get('name');
        $customer->email     = $request->get('email');
        $customer->password  = Hash::make($request->get('password'));

        $isSaved = $customer->save();

        if ($isSaved) {
            // هنا لارافيل سيقوم بتعبئة actor_id و actor_type تلقائياً
            $customer->user()->create([
                'name'     => $request->get('name'),
                'email'    => $request->get('email'),
                'password' => Hash::make($request->get('password')),
            ]);

            return response()->json([
                'icon'  => 'success',
                'title' => 'تم إنشاء الأدمن بنجاح والربط باليوزر',
            ], 200);
        } else {
            return response()->json(['icon' => 'error', 'title' => 'فشل الحفظ'], 500);
        }
    }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
         $customers = Customer::findOrFail($id);
        return response()->view('cms.customer.show' , compact('customers'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
           $customers = Customer::findOrFail($id);
            return response()->view('cms.customer.edit' , compact('customers'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //



        $validator = Validator($request->all(),[
             'name'=> 'required |string|min:3|max:20',
           'email' => 'required|email|unique:artisans,email,' . $id,
            'password'     => 'nullable|string|min:6',


        ]);
        if(!$validator->fails()){

            $customers = Customer::findOrFail($id);
             $customers->name = $request->get('name');
             $customers->email = $request->get('email');

            if ($request->has('password') && !empty($request->get('password'))) {
             $customers->password = Hash::make($request->get('password'));
             }


            $isUpdated = $customers->save();

             if ($isUpdated) {
                if ($customers->user) {
                $userData = [
                    'name'  => $request->get('name'),
                    'email' => $request->get('email'),
                ];

                if (isset($newPassword)) {
                    $userData['password'] = $newPassword;
                }

                $customers->user->update($userData);
            }
              return response()->json([
                'icon' => 'success',
                'title' => 'updated succefully',
                'redirect' => route('customers.index')
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
        //
        $customer=Customer::findOrFail($id);
            if ($customer->user) {
        $customer->user->delete();
    }

    // حذف ارتزان
    $isDeleted = $customer->delete();


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
}
