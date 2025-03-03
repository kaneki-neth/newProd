<?php

namespace Database\Seeders\setup_seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BusinessUnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('org_business_units')->insert([
            [
                'bu_code' => 'BU001',
                'bu_name' => 'Mock Business Unit 1',
                'address_line1' => '123 Mock Street',
                'address_line2' => 'Suite 456',
                'city' => 'Mock City',
                'province' => 'Mock Province',
                'postal_code' => '12345',
                'country' => 'US',
                'tel_num' => '1234567890',
                'enabled' => 1,
                'logo_filename' => 'mock_logo1.png',
                'created_by' => 1,
                'updated_by' => 1,
            ],
            [
                'bu_code' => 'BU002',
                'bu_name' => 'Mock Business Unit 2',
                'address_line1' => '456 Mock Avenue',
                'address_line2' => 'Suite 789',
                'city' => 'Mock City',
                'province' => 'Mock Province',
                'postal_code' => '67890',
                'country' => 'US',
                'tel_num' => '0987654321',
                'enabled' => 1,
                'logo_filename' => 'mock_logo2.png',
                'created_by' => 1,
                'updated_by' => 1,
            ],
            [
                'bu_code' => 'BU003',
                'bu_name' => 'Mock Business Unit 3',
                'address_line1' => '789 Mock Boulevard',
                'address_line2' => 'Suite 101',
                'city' => 'Mock City',
                'province' => 'Mock Province',
                'postal_code' => '11223',
                'country' => 'US',
                'tel_num' => '1122334455',
                'enabled' => 1,
                'logo_filename' => 'mock_logo3.png',
                'created_by' => 1,
                'updated_by' => 1,
            ],
        ]);
    }
}
