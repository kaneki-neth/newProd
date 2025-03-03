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
        Schema::create('app_lookup', function (Blueprint $table) {
            $table->string('lookup_type', 30);
            $table->string('lookup_code', 20);
            $table->string('meaning', 30)->nullable();
            $table->string('tag', 100)->nullable();
            $table->tinyInteger('enabled')->default(1);
            $table->string('remarks', 100)->nullable();
            $table->string('attr1', 30)->nullable();
            $table->string('attr2', 30)->nullable();
            $table->integer('lkp_seq')->nullable();
            $table->tinyInteger('is_default')->nullable();
            $table->integer('created_by')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->integer('updated_by')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->primary(['lookup_type', 'lookup_code']);
            $table->index('lookup_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('app_lookup');
    }
};
