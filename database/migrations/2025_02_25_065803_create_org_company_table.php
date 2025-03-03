<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('org_company', function (Blueprint $table) {
            $table->integer('company_id')->primary();
            $table->string('company_name', 50);
            $table->string('short_name', 20)->nullable();
            $table->string('address_line1', 50);
            $table->string('address_line2', 50)->nullable();
            $table->string('city', 50)->nullable();
            $table->string('province', 30)->nullable();
            $table->string('postal_code', 10)->nullable();
            $table->string('country', 2)->nullable();
            $table->string('tel_num', 50)->nullable();
            $table->string('website', 150)->nullable();
            $table->integer('created_by')->nullable();
            $table->dateTime('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->integer('updated_by')->nullable();
            $table->dateTime('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('org_company');
    }
};
