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
        Schema::create('rooms', function (Blueprint $table) {
            $table->id('r_id')->autoIncrement();
            $table->string('room_number');
            $table->string('floor_number');
            $table->string('status');
            $table->foreignId('rt_id')->nullable()->constrained('room_types', 'rt_id')->nullOnDelete();


            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->dateTime('created_at')->useCurrent();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->dateTime('updated_at')->useCurrentOnUpdate()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
