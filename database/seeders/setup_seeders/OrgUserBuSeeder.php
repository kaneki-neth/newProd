<?php

namespace Database\Seeders\setup_seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrgUserBuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('org_user_bu')->insert([
            [
                'user_id' => 1,
                'bu_id' => 1,
                'enabled' => 1,
                'created_by' => 1,
                'updated_by' => 1,
            ],
            [
                'user_id' => 2,
                'bu_id' => 2,
                'enabled' => 1,
                'created_by' => 1,
                'updated_by' => 1,
            ],
            [
                'user_id' => 3,
                'bu_id' => 3,
                'enabled' => 1,
                'created_by' => 1,
                'updated_by' => 1,
            ],
        ]);
    }
}
