<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AmenitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'name' => 'Breakfast',
                'price' => 100.00,
                'created_at' => now(),
                'created_by' => 1,
            ],
            [
                'name' => 'Mattress',
                'price' => 150.00,
                'created_at' => now(),
                'created_by' => 1,
            ],
            [
                'name' => 'Towel    ',
                'price' => 50.00,
                'created_at' => now(),
                'created_by' => 1,
            ],
            [
                'name' => 'Blanket',
                'price' => 100.00,
                'created_at' => now(),
                'created_by' => 1,
            ],
            [
                'name' => 'Wifi',
                'price' => 100.00,
                'created_at' => now(),
                'created_by' => 1,
            ],
        ];

        foreach ($data as $item) {
            DB::table('amenities')->insert($item);
        }
    }
}
