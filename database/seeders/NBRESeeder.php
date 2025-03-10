<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class NBRESeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seed data for news table
        $newsData = [
            [
                'title' => 'News Title 1',
                'date' => '2025-03-03',
                'description' => 'News Description 1',
                'image_file' => 'news_image_1.jpg',
                'enabled' => 1,
                'created_by' => 1,
                'updated_by' => 1,
            ],
            [
                'title' => 'News Title 2',
                'date' => '2025-03-03',
                'description' => 'News Description 2',
                'image_file' => 'news_image_2.jpg',
                'enabled' => 1,
                'created_by' => 1,
                'updated_by' => 1,
            ],
        ];

        foreach ($newsData as $row) {
            \DB::table('news')->insert($row);
        }

        // Seed data for blogs table
        $blogsData = [
            [
                'title' => 'Blog Title 1',
                'date' => '2025-03-03',
                'description' => 'Blog Description 1',
                'image_file' => 'blog_image_1.jpg',
                'enabled' => 1,
                'created_by' => 1,
                'updated_by' => 1,
            ],
            [
                'title' => 'Blog Title 2',
                'date' => '2025-03-03',
                'description' => 'Blog Description 2',
                'image_file' => 'blog_image_2.jpg',
                'enabled' => 1,
                'created_by' => 1,
                'updated_by' => 1,
            ],
        ];

        foreach ($blogsData as $row) {
            \DB::table('blogs')->insert($row);
        }

        // Seed data for research table
        $researchData = [
            [
                'title' => 'Research Title 1',
                'date' => '2025-03-03',
                'description' => 'Research Description 1',
                'image_file' => 'research_image_1.jpg',
                'enabled' => 1,
                'created_by' => 1,
                'updated_by' => 1,
            ],
            [
                'title' => 'Research Title 2',
                'date' => '2025-04-03',
                'description' => 'Research Description 2',
                'image_file' => 'research_image_2.jpg',
                'enabled' => 1,
                'created_by' => 1,
                'updated_by' => 1,
            ],
        ];

        foreach ($researchData as $row) {
            \DB::table('research')->insert($row);
        }

        $eventsData = [
            [
                'title' => 'Event Title 1',
                'date' => '2025-03-03',
                'time' => '9:00',
                'location' => 'Event Location 1',
                'registration_link' => 'https://www.example.com',
                'description' => 'Event Description 1',
                'image_file' => 'event_image_1.jpg',
                'enabled' => 1,
                'created_by' => 1,
                'updated_by' => 1,
            ],
            [
                'title' => 'Event Title 2',
                'date' => '2025-03-03',
                'time' => '13:00',
                'location' => 'Event Location 2',
                'registration_link' => 'https://www.example.com',
                'description' => 'Event Description 2',
                'image_file' => 'event_image_2.jpg',
                'enabled' => 1,
                'created_by' => 1,
                'updated_by' => 1,
            ],
        ];

        foreach ($eventsData as $row) {
            \DB::table('events')->insert($row);
        }
    }
}
