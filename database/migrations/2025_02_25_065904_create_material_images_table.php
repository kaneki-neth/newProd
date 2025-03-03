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
        Schema::create('material_images', function (Blueprint $table) {
            $table->id('mi_id');
            $table->string('image_file');
            $table->foreignId('m_id')->constrained('materials', 'm_id');

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
        DB::table('material_images')->pluck('image_file')->each(function ($imageFile) {
            Storage::disk('public')->delete($imageFile);
        });
        Schema::dropIfExists('material_images');
    }
};
