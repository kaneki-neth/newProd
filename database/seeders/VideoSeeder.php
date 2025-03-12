<?php

namespace Database\Seeders;

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VideoSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();
        $videoLinks = [
            'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
            'https://youtu.be/F-AfuW8oA6Q?t=75',
            'https://www.youtube.com/watch?v=cqIfgfmLTe4',
        ];

        $this->seedTable('videos', function () use ($faker, $videoLinks) {
            return [
                'title' => $faker->sentence,
                'description' => $faker->paragraph,
                'date' => $faker->dateTimeBetween('first day of January', 'last day of this month')->format('Y-m-d'),
                'video_url' => $faker->randomElement($videoLinks),
                'created_by' => 1,
                'updated_by' => 1,
            ];
        }, 50);
    }

    protected function seedTable(string $table, callable $dataGenerator, int $count = 25): void
    {
        for ($i = 0; $i < $count; $i++) {
            DB::table($table)->insert($dataGenerator());
        }
    }
}
