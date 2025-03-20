<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class RoomTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'name' => 'Single Room',
                'price' => 100,
            ],
            [
                'name' => 'Double Room',
                'price' => 200,
            ],
            [
                'name' => 'Family Room',
                'price' => 300,
            ],
        ];

        foreach ($data as $item) {
            DB::table('room_types')->insert($item);
        }
    }
}
