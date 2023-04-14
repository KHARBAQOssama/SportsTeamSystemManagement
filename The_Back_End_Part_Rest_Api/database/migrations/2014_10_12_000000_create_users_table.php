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
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->unsignedBigInteger('role_id')->default(1);
            $table->unsignedBigInteger('sport_id')->nullable();
            $table->text('image_url')->default('http://localhost:8000/storage/images/userDefaultImage.png');
            $table->foreign('sport_id')->references('id')->on('sports')->onDelete('cascade');
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
            $table->date('birth_day');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->boolean('banned')->default(0);
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
