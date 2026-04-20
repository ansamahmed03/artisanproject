<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $roles = Role::withCount('permissions')->paginate(10);
return view('cms.spaity.role.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return response()->view('cms.spaity.role.create');

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validator = Validator($request->all(), [
        'name' => 'required|string|max:100',
        'guard_name' => 'required|string|in:admin,artisan,customer,team', // حسب الجاردات اللي عندك
    ]);

    if (!$validator->fails()) {
        // 2. إنشاء سجل جديد
        $role = new Role();
        $role->name = $request->input('name');
        $role->guard_name = $request->input('guard_name');

        $isSaved = $role->save();

        // 3. إرسال رد JSON ليتعامل معه الـ Axios في الجافاسكريبت
     return response()->json([
    'icon' => 'success', // مهم جداً لظهور شكل التنبيه
    'message' => 'تم الحفظ بنجاح'
], 201);

    } else {
        // في حال وجود خطأ في المدخلات
        return response()->json([
            'message' => $validator->getMessageBag()->first()
        ], 400);
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
        $roles = Role::findOrFail($id);
        return response()->view('cms.spaity.role.edit', compact('roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
      $validator = Validator($request->all(), [
    'name' => 'required|string|max:100',
    'guard_name' => 'required|string',
]);

    if (!$validator->fails()) {
        $role = Role::findOrFail($id);
        $role->name = $request->input('name');
        $role->guard_name = $request->input('guard_name');
        $isSaved = $role->save();

        return response()->json([
            'icon' => $isSaved ? 'success' : 'error',
            'message' => $isSaved ? 'تم التعديل بنجاح' : 'فشل التعديل'
        ], $isSaved ? 200 : 400);
    } else {
        return response()->json([
            'icon' => 'error',
            'message' => $validator->getMessageBag()->first()
        ], 400);
    }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $role = Role::findOrFail($id);
    $isDeleted = $role->delete();

    return response()->json([
        'icon' => $isDeleted ? 'success' : 'error',
        'message' => $isDeleted ? 'تم الحذف بنجاح' : 'فشل الحذف'
    ], $isDeleted ? 200 : 400);
    }
}
