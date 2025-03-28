<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'room_number' => '101',
                'floor_number' => '1',
                'c_id' => rand(1, 5),
                'status' => 'Available',
            ],
            [
                'room_number' => '102',
                'floor_number' => '1',
                'c_id' => rand(1, 5),
                'status' => 'Occupied',
            ],
            [
                'room_number' => '103',
                'floor_number' => '2',
                'c_id' => rand(1, 5),
                'status' => 'Occupied',
            ],
            [
                'room_number' => '104',
                'floor_number' => '2',
                'c_id' => rand(1, 5),
                'status' => 'Available',
            ],
            [
                'room_number' => '105',
                'floor_number' => '2',
                'c_id' => rand(1, 5),
                'status' => 'Need Cleaning',
            ],
            [
                'room_number' => '106',
                'floor_number' => '3',
                'c_id' => rand(1, 5),
                'status' => 'Available',
            ],
            [
                'room_number' => '107',
                'floor_number' => '3',
                'c_id' => rand(1, 5),
                'status' => 'Available',
            ],
            [
                'room_number' => '108',
                'floor_number' => '3',
                'c_id' => rand(1, 5),
                'status' => 'Need Cleaning',
            ],
            [
                'room_number' => '109',
                'floor_number' => '4',
                'c_id' => rand(1, 5),
                'status' => 'Need Cleaning',
            ],
            [
                'room_number' => '110',
                'floor_number' => '4',
                'c_id' => rand(1, 5),
                'status' => 'Available',
            ],
            [
                'room_number' => '111',
                'floor_number' => '4',
                'c_id' => rand(1, 5),
                'status' => 'Unavailable',
            ],
            [
                'room_number' => '112',
                'floor_number' => '5',
                'c_id' => rand(1, 5),
                'status' => 'Available',
            ],
            [
                'room_number' => '113',
                'floor_number' => '5',
                'c_id' => rand(1, 5),
                'status' => 'Occupied',
            ],
            [
                'room_number' => '114',
                'floor_number' => '5',
                'c_id' => rand(1, 5),
                'status' => 'Need Cleaning',
            ],
            [
                'room_number' => '115',
                'floor_number' => '6',
                'c_id' => rand(1, 5),
                'status' => 'Available',
            ],
            [
                'room_number' => '116',
                'floor_number' => '6',
                'c_id' => rand(1, 5),
                'status' => 'On Maintenance',
            ],
            [
                'room_number' => '117',
                'floor_number' => '6',
                'c_id' => rand(1, 5),
                'status' => 'Available',
            ],
            [
                'room_number' => '118',
                'floor_number' => '7',
                'c_id' => rand(1, 5),
                'status' => 'Occupied',
            ],
            [
                'room_number' => '119',
                'floor_number' => '7',
                'c_id' => rand(1, 5),
                'status' => 'Available',
            ],
            [
                'room_number' => '120',
                'floor_number' => '7',
                'c_id' => rand(1, 5),
                'status' => 'Need Cleaning',
            ],
            [
                'room_number' => '121',
                'floor_number' => '8',
                'c_id' => rand(1, 5),
                'status' => 'Available',
            ],
            [
                'room_number' => '122',
                'floor_number' => '8',
                'c_id' => rand(1, 5),
                'status' => 'Occupied',
            ],
            [
                'room_number' => '123',
                'floor_number' => '8',
                'c_id' => rand(1, 5),
                'status' => 'Need Cleaning',
            ],
            [
                'room_number' => '124',
                'floor_number' => '9',
                'c_id' => rand(1, 5),
                'status' => 'Available',
            ],
        ];

        foreach ($data as $item) {
            DB::table('rooms')->insert($item);
        }
    }
}
