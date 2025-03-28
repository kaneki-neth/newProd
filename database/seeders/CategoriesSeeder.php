<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'name' => 'Single Room',
                'description' => 'Single Room',
                'daily_rate' => 100,
                'hourly_rate' => 100,
                'max_occupancy' => 1,
                'enabled' => 1,
            ],
            [
                'name' => 'Double Room',
                'description' => 'Double Room',
                'daily_rate' => 200,
                'hourly_rate' => 200,
                'max_occupancy' => 2,
                'enabled' => 1,
            ],
            [
                'name' => 'Family Room',
                'description' => 'Family Room',
                'daily_rate' => 300,
                'hourly_rate' => 300,
                'max_occupancy' => 3,
                'enabled' => 1,
            ],
            [
                'name' => 'Suite Room',
                'description' => 'Suite Room',
                'daily_rate' => 400,
                'hourly_rate' => 400,
                'max_occupancy' => 4,
                'enabled' => 1,
            ],
            [
                'name' => 'VIP Room',
                'description' => 'VIP Room',
                'daily_rate' => 500,
                'hourly_rate' => 500,
                'max_occupancy' => 5,
                'enabled' => 0,
            ],
        ];

        foreach ($data as $item) {
            DB::table('categories')->insert($item);
        }
    }
}
