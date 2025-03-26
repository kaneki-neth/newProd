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
        Schema::create('companies', function (Blueprint $table) {
            $table->id('c_id');
            $table->string('name');
            $table->string('description');
            $table->string('address');
            $table->string('contact_number');
            $table->string('email')->unique();
            $table->tinyInteger('enabled')->default(1);

            $table->dateTime('created_at')->useCurrent();
            $table->foreignId('created_by')->constrained('users');
            $table->dateTime('updated_at')->nullable()->useCurrentOnUpdate();
            $table->foreignId('updated_by')->nullable()->constrained('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
