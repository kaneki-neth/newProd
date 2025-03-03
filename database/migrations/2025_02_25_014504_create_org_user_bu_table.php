<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('org_user_bu', function (Blueprint $table) {
            $table->integer('user_id');
            $table->integer('bu_id');
            $table->tinyInteger('enabled')->nullable();
            $table->integer('created_by')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->integer('updated_by')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->primary(['user_id', 'bu_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('org_user_bu');
    }
};
