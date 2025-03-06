<?php

namespace Database\Seeders\setup_seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::create([
            'name' => 'role-full',
            'display_name' => 'Role Access (Full)',
            'created_by' => 1,
            'updated_by' => 1,
        ]);
        Permission::create([
            'name' => 'role-view',
            'display_name' => 'Role Access (View)',
            'created_by' => 1,
            'updated_by' => 1,
        ]);

        Permission::create([
            'name' => 'user-full',
            'display_name' => 'User Access (Full)',
            'created_by' => 1,
            'updated_by' => 1,
        ]);

        Permission::create([
            'name' => 'user-view',
            'display_name' => 'User Access (View)',
            'created_by' => 1,
            'updated_by' => 1,
        ]);

        Permission::create([
            'name' => 'permission-full',
            'display_name' => 'Permission Access (Full)',
            'created_by' => 1,
            'updated_by' => 1,
        ]);

        Permission::create([
            'name' => 'permission-view',
            'display_name' => 'Permission Access (View)',
            'created_by' => 1,
            'updated_by' => 1,
        ]);

        Permission::create([
            'name' => 'company_settings',
            'display_name' => 'Company Settings Access',
            'created_by' => 1,
            'updated_by' => 1,
        ]);

        Permission::create([
            'name' => 'look_up_full ',
            'display_name' => 'Look Up Access (Full)',
            'created_by' => 1,
            'updated_by' => 1,
        ]);

        Permission::create([
            'name' => 'look_up_view',
            'display_name' => 'Look Up Access (View)',
            'created_by' => 1,
            'updated_by' => 1,
        ]);

        Permission::create([
            'name' => 'video_full',
            'display_name' => 'Video Access (Full)',
            'created_by' => 1,
            'updated_by' => 1,
        ]);

        Permission::create([
            'name' => 'video_view',
            'display_name' => 'Video Access (View)',
            'created_by' => 1,
            'updated_by' => 1,
        ]);

        $admin = Role::where('name', 'admin')->first();
        $admin->givePermissionTo(Permission::all());

        $user = Role::where('name', 'user')->first();
        $user->givePermissionTo('user-view', 'role-view', 'video_view');
    }
}
