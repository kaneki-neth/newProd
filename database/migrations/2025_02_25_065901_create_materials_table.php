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
        Schema::create('materials', function (Blueprint $table) {
            $table->id('m_id');
            $table->string('name', 255);
            $table->string('material_code', 255)->unique();
            $table->longText('description');
            $table->string('image_file');
            $table->foreignId('y_id')->nullable()->constrained('years', 'y_id')->nullOnDelete();

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
        DB::table('materials')->pluck('image_file')->each(function ($imageFile) {
            if ($imageFile) {
                Storage::disk('public')->delete($imageFile);
            }
        });
        Schema::dropIfExists('materials');
    }
};
