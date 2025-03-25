<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenaltySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'name' => 'Late Check-In',
                'amount' => 500,
                'enabled' => 1,
                'created_by' => 1,
                'created_at' => now(),
            ],
            [
                'name' => 'Early Check-Out',
                'amount' => 500,
                'enabled' => 1,
                'created_by' => 1,
                'created_at' => now(),
            ],
            [
                'name' => 'No Show',
                'amount' => 1000,
                'enabled' => 1,
                'created_by' => 1,
                'created_at' => now(),
            ],
            [
                'name' => 'Furniture Damage',
                'amount' => 1000,
                'enabled' => 1,
                'created_by' => 1,
                'created_at' => now(),
            ],
            [
                'name' => 'Room Service',
                'amount' => 1000,
                'enabled' => 1,
                'created_by' => 1,
                'created_at' => now(),
            ],
            [
                'name' => 'Other',
                'amount' => 1000,
                'enabled' => 1,
                'created_by' => 1,
                'created_at' => now(),
            ],
        ];

        foreach ($data as $item) {
            DB::table('penalties')->insert($item);
        }
    }
}
