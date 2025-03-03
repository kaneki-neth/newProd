<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class VideoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('videos')->insert([
            'title' => 'Video Title 1',
            'description' => 'Video Description 1',
            'date' => '2025-03-03',
            'video_file' => null,
            'created_by' => 1,
            'updated_by' => 1,
        ]);

        DB::table('videos')->insert([
            'title' => 'Video Title 2',
            'description' => 'Video Description 2',
            'date' => '2025-03-03',
            'video_file' => null,
            'created_by' => 1,
            'updated_by' => 1,
        ]);
    }
}
