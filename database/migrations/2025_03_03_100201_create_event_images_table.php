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
        Schema::create('events_images', function (Blueprint $table) {
            $table->id('ei_id');
            $table->string('image_file');
            $table->foreignId('e_id')->constrained('events', 'e_id');

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
        DB::table('events_images')->pluck('image_file')->each(function ($imageFile) {
            Storage::disk('public')->delete($imageFile);
        });
        Schema::dropIfExists('events_images');
    }
};
