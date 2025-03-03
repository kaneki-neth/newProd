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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('email', 255)->unique();
            $table->string('alias', 50);
            $table->string('first_name', 50);
            $table->string('last_name', 50)->nullable();
            $table->tinyInteger('enabled')->default(1);
            $table->tinyInteger('reset_on_login')->default(0);
            $table->date('next_pwd_change')->nullable();
            $table->dateTime('last_login')->nullable();
            $table->dateTime('last_password_change')->nullable();
            $table->rememberToken();
            $table->string('user_profile', 255)->nullable();
            $table->string('address', 255)->nullable();
            $table->string('contact_number', 20)->nullable();
            $table->string('last_login_ip', 50)->nullable();
            $table->string('password', 255); // ->nullable();
            $table->foreignId('created_by')->nullable()->constraint('users');
            $table->foreignId('updated_by')->nullable()->constraint('users');
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
