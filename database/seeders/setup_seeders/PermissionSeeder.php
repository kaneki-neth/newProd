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
        $permissions = [
            ['role-full', 'Role Access (Full)'],
            ['role-view', 'Role Access (View)'],
            ['user-full', 'User Access (Full)'],
            ['user-view', 'User Access (View)'],
            ['company_settings', 'Company Settings Access'],
            ['look_up_full', 'Look Up Access (Full)'],
            ['look_up_view', 'Look Up Access (View)'],

            ['connect-read', 'Connect (Read)'],
            ['category-read', 'Category (Read)'],
            ['category-write', 'Category (Write)'],
            ['material-read', 'Material (Read)'],
            ['material-write', 'Material (Write)'],
            ['video-read', 'Video (Read)'],
            ['video-write', 'Video (Write)'],
            ['news-read', 'News (Read)'],
            ['news-write', 'News (Write)'],
            ['blog-read', 'Blog (Read)'],
            ['blog-write', 'Blog (Write)'],
            ['research-read', 'Research (Read)'],
            ['research-write', 'Research (Write)'],
            ['event-read', 'Event (Read)'],
            ['event-write', 'Event (Write)'],
        ];

        foreach ($permissions as $permission) {
            Permission::create([
                'name' => $permission[0],
                'display_name' => $permission[1],
                'created_by' => 1,
                'updated_by' => 1,
            ]);
        }

        $admin = Role::where('name', 'admin')->first();
        $admin->givePermissionTo(Permission::all());

        $user = Role::where('name', 'user')->first();
        $user->givePermissionTo(
            'news-read',
            'blog-read',
            'research-read',
            'event-read',
            'video-read',
            'connect-read',
            'category-read',
            'material-read',
        );
    }
}
