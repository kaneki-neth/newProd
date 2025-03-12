<?php

namespace Database\Seeders;

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class NBRESeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        // Seed news table using a factory-like closure.
        $this->seedTable('news', function () use ($faker) {
            return [
                'title' => $faker->sentence,
                'date' => $faker->dateTimeBetween('first day of January', 'last day of this month')->format('Y-m-d'),
                'description' => $faker->paragraph,
                'image_file' => 'news_image_'.$faker->numberBetween(1, 5).'.jpg',
                'enabled' => 1,
                'created_by' => 1,
                'updated_by' => 1,
            ];
        });

        // Seed blogs table.
        $this->seedTable('blogs', function () use ($faker) {
            return [
                'title' => $faker->sentence,
                'date' => $faker->dateTimeBetween('first day of January', 'last day of this month')->format('Y-m-d'),
                'description' => $faker->paragraph,
                'image_file' => 'blog_image_'.$faker->numberBetween(1, 5).'.jpg',
                'enabled' => 1,
                'created_by' => 1,
                'updated_by' => 1,
            ];
        });

        // Seed research table.
        $this->seedTable('research', function () use ($faker) {
            return [
                'title' => $faker->sentence,
                'date' => $faker->dateTimeBetween('first day of January', 'last day of this month')->format('Y-m-d'),
                'description' => $faker->paragraph,
                'image_file' => 'research_image_'.$faker->numberBetween(1, 5).'.jpg',
                'enabled' => 1,
                'created_by' => 1,
                'updated_by' => 1,
            ];
        });

        // Seed events table.
        $this->seedTable('events', function () use ($faker) {
            return [
                'title' => $faker->sentence,
                'date' => $faker->dateTimeBetween('first day of January', 'last day of this month')->format('Y-m-d'),
                'time' => $faker->time('H:i'),
                'location' => $faker->address,
                'registration_link' => $faker->url,
                'description' => $faker->paragraph,
                'image_file' => 'event_image_'.$faker->numberBetween(1, 5).'.jpg',
                'enabled' => 1,
                'created_by' => 1,
                'updated_by' => 1,
            ];
        });
    }

    // Helper function
    protected function seedTable(string $table, callable $dataGenerator, int $count = 25): void
    {
        for ($i = 0; $i < $count; $i++) {
            \DB::table($table)->insert($dataGenerator());
        }
    }
}
