<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class NewsEventsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'category' => 'news',
                'title' => 'News Title 1',
                'date' => '2025-03-03',
                'description' => 'News Description 1',
                'image_file' => 'news_image_1.jpg',
                'created_by' => 1,
                'updated_by' => 1,
            ],
            [
                'category' => 'news',
                'title' => 'News Title 2',
                'date' => '2025-03-03',
                'description' => 'News Description 2',
                'image_file' => 'news_image_2.jpg',
                'created_by' => 1,
                'updated_by' => 1,
            ],
            [
                'category' => 'event',
                'title' => 'Event Title 1',
                'date' => '2025-03-03',
                'description' => 'Event Description 1',
                'image_file' => 'event_image_1.jpg',
                'created_by' => 1,
                'updated_by' => 1,
            ],
            [
                'category' => 'event',
                'title' => 'Event Title 2',
                'date' => '2025-03-03',
                'description' => 'Event Description 2',
                'image_file' => 'event_image_2.jpg',
                'created_by' => 1,
                'updated_by' => 1,
            ],
        ];

        foreach ($data as $row) {
            \DB::table('news_events')->insert($row);
        }
    }
}
