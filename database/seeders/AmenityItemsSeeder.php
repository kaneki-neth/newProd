<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AmenityItemsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'name' => 'Breakfast',
                'description' => 'Breakfast',
                'price' => 100.00,
                'quantity' => 1,
                'created_at' => now(),
                'created_by' => 1,
                'enabled' => 1,
            ],
            [
                'name' => 'Mattress',
                'description' => 'Mattress',
                'price' => 150.00,
                'quantity' => 1,
                'created_at' => now(),
                'created_by' => 1,
                'enabled' => 1,
            ],
            [
                'name' => 'Towel    ',
                'description' => 'Towel',
                'price' => 50.00,
                'quantity' => 1,
                'created_at' => now(),
                'created_by' => 1,
                'enabled' => 1,
            ],
            [
                'name' => 'Blanket',
                'description' => 'Blanket',
                'price' => 100.00,
                'quantity' => 1,
                'created_at' => now(),
                'created_by' => 1,
                'enabled' => 1,
            ],
            [
                'name' => 'Wifi',
                'description' => 'Wifi',
                'price' => 100.00,
                'quantity' => 1,
                'created_at' => now(),
                'created_by' => 1,
                'enabled' => 0,
            ],
            [
                'name' => 'Laundry',
                'description' => 'Laundry',
                'price' => 100.00,
                'quantity' => 1,
                'created_at' => now(),
                'created_by' => 1,
                'enabled' => 1,
            ],
        ];

        foreach ($data as $item) {
            DB::table('amenity_items')->insert($item);
        }
    }
}
