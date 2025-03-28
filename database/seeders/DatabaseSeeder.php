<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Database\Seeders\setup_seeders\BusinessUnitSeeder;
use Database\Seeders\setup_seeders\OrgCompanySeeder;
use Database\Seeders\setup_seeders\OrgUserBuSeeder;
use Database\Seeders\setup_seeders\PermissionSeeder;
use Database\Seeders\setup_seeders\RoleSeeder;
use Database\Seeders\setup_seeders\UserSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $this->call([
            UserSeeder::class,
            RoleSeeder::class,
            PermissionSeeder::class,
            BusinessUnitSeeder::class,
            OrgUserBuSeeder::class,
            OrgCompanySeeder::class,

            CategoriesSeeder::class,
            RoomSeeder::class,
        ]);

        $this->call([
            AmenityItemsSeeder::class,
            ChargesItemsSeeder::class,
            CompanySeeder::class,
            GuestSeeder::class,
        ]);
    }
}
