<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class GuestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $guests = [
            [
                'first_name' => '1 John',
                'middle_name' => 'Doe',
                'last_name' => 'Smith',
                'gender' => 'Male',
                'contact_number' => '1234567890',
                'email' => '1john.smith@example.com',
                'address_1' => '123 Main St',
                'address_2' => 'Apt 1',
                'company_id' => 1,
                'enabled' => 1,
                'created_by' => 1,
                'created_at' => now(),
            ],
            [
                'first_name' => '1 Jane',
                'middle_name' => 'Doe',
                'last_name' => 'Smith',
                'gender' => 'Female',
                'contact_number' => '1234567890',
                'email' => '1jane.smith@example.com',
                'address_1' => '123 Main St',
                'address_2' => 'Apt 1',
                'company_id' => 2,
                'enabled' => 1,
                'created_by' => 1,
                'created_at' => now(),
            ],
            [
                'first_name' => '2 John',
                'middle_name' => 'Doe',
                'last_name' => 'Smith',
                'gender' => 'Male',
                'contact_number' => '1234567890',
                'email' => '2john.smith@example.com',
                'address_1' => '123 Main St',
                'address_2' => 'Apt 1',
                'company_id' => 2,
                'enabled' => 0,
                'created_by' => 1,
                'created_at' => now(),
            ],
            [
                'first_name' => '3 John',
                'middle_name' => 'Doe',
                'last_name' => 'Smith',
                'gender' => 'Male',
                'contact_number' => '1234567890',
                'email' => '3john.smith@example.com',
                'address_1' => '123 Main St',
                'address_2' => 'Apt 1',
                'enabled' => 1,
                'created_by' => 1,
                'created_at' => now(),
            ],
            [
                'first_name' => '4 John',
                'middle_name' => 'Doe',
                'last_name' => 'Smith',
                'gender' => 'Male',
                'contact_number' => '1234567890',
                'email' => '4john.smith@example.com',
                'address_1' => '123 Main St',
                'address_2' => 'Apt 1',
                'company_id' => 5,
                'enabled' => 1,
                'created_by' => 1,
                'created_at' => now(),
            ],
            [
                'first_name' => '5 John',
                'middle_name' => 'Doe',
                'last_name' => 'Smith',
                'gender' => 'Male',
                'contact_number' => '1234567890',
                'email' => '5john.smith@example.com',
                'address_1' => '123 Main St',
                'address_2' => 'Apt 1',
                'enabled' => 0,
                'created_by' => 1,
                'created_at' => now(),
            ],
            [
                'first_name' => '6 John',
                'middle_name' => 'Doe',
                'last_name' => 'Smith',
                'gender' => 'Male',
                'contact_number' => '1234567890',
                'email' => '6john.smith@example.com',
                'address_1' => '123 Main St',
                'address_2' => 'Apt 1',
                'company_id' => 1,
                'enabled' => 0,
                'created_by' => 1,
                'created_at' => now(),
            ],
            [
                'first_name' => '7 John',
                'middle_name' => 'Doe',
                'last_name' => 'Smith',
                'gender' => 'Male',
                'contact_number' => '1234567890',
                'email' => '7john.smith@example.com',
                'address_1' => '123 Main St',
                'address_2' => 'Apt 1',
                'company_id' => 4,
                'enabled' => 1,
                'created_by' => 1,
                'created_at' => now(),
            ],
            [
                'first_name' => '8 John',
                'middle_name' => 'Doe',
                'last_name' => 'Smith',
                'gender' => 'Male',
                'contact_number' => '1234567890',
                'email' => '8john.smith@example.com',
                'address_1' => '123 Main St',
                'address_2' => 'Apt 1',
                'enabled' => 1,
                'created_by' => 1,
                'created_at' => now(),
            ],
            [
                'first_name' => '9 John',
                'middle_name' => 'Doe',
                'last_name' => 'Smith',
                'gender' => 'Male',
                'contact_number' => '1234567890',
                'email' => '9john.smith@example.com',
                'address_1' => '123 Main St',
                'address_2' => 'Apt 1',
                'enabled' => 1,
                'created_by' => 1,
                'created_at' => now(),
            ],
        ];

        foreach ($guests as $guest) {
            DB::table('guests')->insert($guest);
        }
    }
}
