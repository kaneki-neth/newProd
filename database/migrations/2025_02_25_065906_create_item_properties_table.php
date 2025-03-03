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
        Schema::create('item_properties', function (Blueprint $table) {
            $table->id('ip_id');
            $table->string('value', 255);

            $table->foreignId('m_id')->constrained('materials', 'm_id')->cascadeOnDelete();
            $table->foreignId('p_id')->constrained('properties', 'p_id')->cascadeOnDelete();

            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_properties');
    }
};
