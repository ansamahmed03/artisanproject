<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleAndPermissionSeeder extends Seeder
{
    public function run(): void
    {
        // مسح الكاش
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            'Create Admin', 'Edit Admin', 'Delete Admin', 'Index Admin',
            'Create Artisan', 'Edit Artisan', 'Delete Artisan', 'Index Artisan',
            'Create Team', 'Edit Team', 'Delete Team', 'Index Team',
            'Create Customer', 'Edit Customer', 'Delete Customer', 'Index Customer',
            'Create Product', 'Edit Product', 'Delete Product', 'Index Product',
            'Create Order', 'Edit Order', 'Delete Order', 'Index Order',
            'Create Role', 'Index Role',
            'Create Permission', 'Index Permission',
            'Create Category', 'Index Category',
            'Create Address', 'Index Address',
            'Create Country', 'Index Country',
            'Create City', 'Index City',
        ];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['name' => $perm, 'guard_name' => 'admin']);
        }

        $admin = Role::firstOrCreate(['name' => 'Admin', 'guard_name' => 'admin']);
        $team = Role::firstOrCreate(['name' => 'Team', 'guard_name' => 'admin']);
        $artisan = Role::firstOrCreate(['name' => 'Artisan', 'guard_name' => 'admin']);

        // Admin له كل الصلاحيات
        $admin->givePermissionTo(Permission::all());

        // Team
        $team->givePermissionTo([
            'Index Artisan', 'Index Customer', 'Index Team',
            'Index Product', 'Index Order',
        ]);

        // Artisan
        $artisan->givePermissionTo([
            'Index Product', 'Create Product', 'Edit Product', 'Delete Product',
            'Index Order', 'Index Artisan',
        ]);
    }
}
