<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('org_business_units', function (Blueprint $table) {
            $table->increments('bu_id');
            $table->string('bu_code', 5);
            $table->string('bu_name', 100);
            $table->string('address_line1', 50);
            $table->string('address_line2', 50)->nullable();
            $table->string('city', 50)->nullable();
            $table->string('province', 30)->nullable();
            $table->string('postal_code', 10)->nullable();
            $table->string('country', 2)->nullable();
            $table->string('tel_num', 50)->nullable();
            $table->tinyInteger('enabled')->nullable();
            $table->string('logo_filename', 150)->nullable();
            $table->integer('created_by')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->integer('updated_by')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->primary('bu_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('org_business_units');
    }
};
