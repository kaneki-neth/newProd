<?php

namespace Database\Seeders\setup_seeders;

use DB;
use Illuminate\Database\Seeder;

class OrgCompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('org_company')->insert([
            'company_id' => 1,
            'company_name' => "Fat Pauly's Hand-crafted Ales & Lagers",
            'short_name' => 'Fat Paulys',
            'address_line1' => '005 Sparrow Rd., Isabel Village Pala-o',
            'address_line2' => null,
            'city' => 'Iligan',
            'province' => 'Lanao del Norte',
            'postal_code' => '9200',
            'country' => 'PH',
            'tel_num' => null,
            'website' => null,
            'created_by' => 1,
            'created_at' => '2024-09-10 16:29:33',
            'updated_by' => 1,
            'updated_at' => '2024-12-10 13:21:41',
        ]);
    }
}
