<?php

namespace Database\Seeders\setup_seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'email' => 'admin@admin.com',
            'password' => bcrypt('password'),
            'alias' => 'admin',
            'first_name' => 'Admin',
            'last_name' => 'User',
            'enabled' => true,
            'reset_on_login' => 0,
            'next_pwd_change' => now()->addMonths(3),
            'last_login' => now(),
            'last_password_change' => now(),
            'user_profile' => 'assets/userProfile/cat_image.png',
            'address' => '123 Admin St',
            'contact_number' => '1234567890',
            'last_login_ip' => '127.0.0.1',
            'created_by' => null,
            'updated_by' => null,
        ]);

        User::create([
            'email' => 'user@user.com',
            'password' => bcrypt('password'),
            'alias' => 'user',
            'first_name' => 'Regular',
            'last_name' => 'User',
            'enabled' => true,
            'reset_on_login' => 0,
            'next_pwd_change' => now()->addMonths(3),
            'last_login' => now(),
            'last_password_change' => now(),
            'user_profile' => 'assets/userProfile/cat_image.png',
            'address' => '456 User Ave',
            'contact_number' => '0987654321',
            'last_login_ip' => '127.0.0.1',
            'created_by' => null,
            'updated_by' => null,
        ]);
    }
}
