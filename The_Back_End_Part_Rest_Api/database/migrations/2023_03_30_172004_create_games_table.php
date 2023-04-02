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
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('home');
            $table->foreign('home')->references('id')->on('teams')->onDelete('cascade');
            $table->integer('home_score')->nullable();
            $table->unsignedBigInteger('away');
            $table->foreign('away')->references('id')->on('teams')->onDelete('cascade');
            $table->integer('away_score')->nullable();
            $table->string('game_place')->nullable();
            $table->time('start_time');
            $table->date('date');
            $table->string('referee')->nullable();
            $table->string('referee1')->nullable();
            $table->string('referee2')->nullable();
            $table->string('referee3')->nullable();
            $table->boolean('played')->default(0);
            $table->boolean('fans')->default(1);
            $table->integer('seats_number')->nullable();
            $table->integer('seats_available')->nullable();
            $table->unsignedBigInteger('sport_id');
            $table->foreign('sport_id')->references('id')->on('sports')->onDelete('cascade');
            $table->unsignedBigInteger('tournament_id')->nullable();
            $table->foreign('tournament_id')->references('id')->on('tournaments')->onDelete('cascade');
            $table->integer('round')->nullable();
            $table->double('ticket_price')->default(0)->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('games');
    }
};
