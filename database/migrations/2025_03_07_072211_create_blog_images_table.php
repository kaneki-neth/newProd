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
        Schema::create('blog_images', function (Blueprint $table) {
            $table->id('bi_id');
            $table->string('image_file');
            $table->foreignId('b_id')->constrained('blogs', 'b_id');

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
        DB::table('blog_images')->pluck('image_file')->each(function ($imageFile) {
            Storage::disk('public')->delete($imageFile);
        });
        Schema::dropIfExists('blog_images');
    }
};
