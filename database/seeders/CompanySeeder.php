<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'name' => 'Company 1',
                'description' => 'Description 1',
                'address' => 'Address 1',
                'contact_number' => '1234567890',
                'email' => 'company1@example.com',
                'enabled' => 0,

                'created_at' => now(),
                'created_by' => 1,
            ],
            [
                'name' => 'Company 2',
                'description' => 'Description 2',
                'address' => 'Address 2',
                'contact_number' => '1234567890',
                'email' => 'company2@example.com',
                'enabled' => 1,

                'created_at' => now(),
                'created_by' => 1,
            ],
            [
                'name' => 'Company 3',
                'description' => 'Description 3',
                'address' => 'Address 3',
                'contact_number' => '1234567890',
                'email' => 'company3@example.com',
                'enabled' => 1,

                'created_at' => now(),
                'created_by' => 1,
            ],
            [
                'name' => 'Company 4',
                'description' => 'Description 4',
                'address' => 'Address 4',
                'contact_number' => '1234567890',
                'email' => 'company4@example.com',
                'enabled' => 0,

                'created_at' => now(),
                'created_by' => 1,
            ],
            [
                'name' => 'Company 5',
                'description' => 'Description 5',
                'address' => 'Address 5',
                'contact_number' => '1234567890',
                'email' => 'company5@example.com',
                'enabled' => 0,

                'created_at' => now(),
                'created_by' => 1,
            ],
            [
                'name' => 'Company 6',
                'description' => 'Description 6',
                'address' => 'Address 6',
                'contact_number' => '1234567890',
                'email' => 'company6@example.com',
                'enabled' => 0,

                'created_at' => now(),
                'created_by' => 1,
            ],
            [
                'name' => 'Company 7',
                'description' => 'Description 7',
                'address' => 'Address 7',
                'contact_number' => '1234567890',
                'email' => 'company7@example.com',
                'enabled' => 1,

                'created_at' => now(),
                'created_by' => 1,
            ],
            [
                'name' => 'Company 8',
                'description' => 'Description 8',
                'address' => 'Address 8',
                'contact_number' => '1234567890',
                'email' => 'company8@example.com',
                'enabled' => 1,

                'created_at' => now(),
                'created_by' => 1,
            ],
            [
                'name' => 'Company 9',
                'description' => 'Description 9',
                'address' => 'Address 9',
                'contact_number' => '1234567890',
                'email' => 'company9@example.com',
                'enabled' => 1,

                'created_at' => now(),
                'created_by' => 1,
            ],
        ];

        foreach ($data as $item) {
            DB::table('companies')->insert($item);
        }
    }
}
