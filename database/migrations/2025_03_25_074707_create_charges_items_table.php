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
        Schema::create('charges_items', function (Blueprint $table) {
            $table->id('ci_id');
            $table->string('name');
            $table->string('description')->nullable();
            $table->decimal('amount', 10, 2);
            $table->tinyInteger('enabled')->default(1);

            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->dateTime('created_at')->nullable()->useCurrent();
            $table->foreignId('updated_by')->nullable()->constrained('users');
            $table->dateTime('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('charges_items');
    }
};
