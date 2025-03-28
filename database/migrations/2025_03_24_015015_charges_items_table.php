<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('amenity_items', function (Blueprint $table) {
            $table->integer('ai_id')->primary()->autoIncrement();
            $table->string('name');
            $table->string('description')->nullable();
            $table->decimal('price', 10, 2);
            $table->integer('quantity')->default(1);
            $table->tinyInteger('enabled')->default(1);

            $table->integer('created_by')->foreignId('users')->constrained();
            $table->dateTime('created_at')->useCurrent();
            $table->integer('updated_by')->foreignId('users')->constrained()->nullable()->nullOnDelete();
            $table->dateTime('updated_at')->useCurrentOnUpdate()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('amenity_items');
    }
};
