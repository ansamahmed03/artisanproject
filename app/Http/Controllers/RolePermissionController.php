<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Role $role)
{
    // جلب الصلاحيات المتوافقة مع Guard الخاص بالدور
    $permissions = Permission::where('guard_name', $role->guard_name)->get();

    // فحص الصلاحيات المرتبطة بالدور حالياً
    $rolePermissions = $role->permissions;

    foreach ($permissions as $permission) {
        $permission->setAttribute('assigned', false);
        foreach ($rolePermissions as $rolePermission) {
            if ($permission->id == $rolePermission->id) {
                $permission->setAttribute('assigned', true);
                break;
            }
        }
    }

  return response()->view('cms.spaity.role.role-permission', [
    'role' => $role,
    'permissions' => $permissions
]);
}



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $roleId) // استلام الـ ID من الرابط
{
    $validator = Validator($request->all(), [
        'permission_id' => 'required|integer|exists:permissions,id',
    ]);

    if (!$validator->fails()) {
        $role = Role::findOrFail($roleId); // البحث عن الدور باستخدام ID الرابط
        $permission = Permission::findOrFail($request->input('permission_id'));

        if ($role->hasPermissionTo($permission)) {
            $role->revokePermissionTo($permission);
        } else {
            $role->givePermissionTo($permission);
        }

        return response()->json(['icon' => 'success', 'title' => 'Is Successfully'], 200);
    } else {
        return response()->json(['message' => $validator->getMessageBag()->first()], 400);
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
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

