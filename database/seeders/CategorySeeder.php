<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['Metals', 'Metals', 1],
            ['Polymers', 'Polymers', 1],
            ['Composite', 'Composite', 1],
            ['Ceramics', 'Ceramics', 1],
            ['Woods & Natural Fibers', 'Woods and Natural Fibers', 1],
            ['Textiles', 'Textiles', 1],
            ['Glass', 'Glass', 1],
            ['Nanomaterials', 'Nanomaterials', 1],
            ['Experimental/Hybrid', 'Experimental/Hybrid', 1],
        ];

        foreach ($categories as $category) {
            $category = DB::table('categories')->insert([
                'name' => $category[0],
                'description' => $category[1],
                'enabled' => $category[2],
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
