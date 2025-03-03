<?php

namespace Database\Seeders\setup_seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'user']);

        $admin = User::where('email', 'admin@admin.com')->first();
        $admin->assignRole('admin');

        $user = User::where('email', 'user@user.com')->first();
        $user->assignRole('user');
    }
}
