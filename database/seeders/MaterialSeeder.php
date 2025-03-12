<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;

class MaterialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Creating Test Material
        for ($i=1; $i <= 5; $i++) { 
            $materialId = DB::table('materials')->insertGetId([
                'name' => 'Material ' . $i,
                'material_code' => 'TM00' . $i,
                'material_source' => 'Material Research Place',
                'description' => 'test material #' . $i,
                'image_file' => 'test-material.jpg',
                'year' => '2025',
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Creating Test Category
        for ($i = 1; $i <= 2; $i++) {
            $categoryId = DB::table('categories')->insertGetId([
                'name' => 'Test Category '.$i,
                'description' => 'test category '.$i,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $categoryId = DB::table('categories')->insertGetId([
            'name' => 'Test Category '.$i,
            'description' => 'test category '.$i,
            'enabled' => 0,
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        for ($i=1; $i <= 5; $i++) { 
            DB::table('item_categories')->insert([
                'm_id' => $i,
                'c_id' => rand(1, 2),
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }


        // Creating Test Property: ['soft', 'technical', 'application', 'soft']
        $property_types = ['soft', 'technical', 'application', 'soft'];
        foreach ($property_types as $idx => $type) {
            $property = DB::table('properties')->where([
                ['name', '=', 'Test Property '.ucfirst($type)],
                ['type', '=', $type],
            ])->first();

            $property ? $property->p_id : DB::table('properties')->insertGetId([
                'name' => 'Test Property '.ucfirst($type),
                'value' => 'test property '.$type.' '.$idx,
                'type' => $type,
                'm_id' => $materialId,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
