<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeaderboardsTable extends Migration
{
    public function up()
    {
        Schema::create('points', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Foreign key to users table
            $table->integer('points'); // Points for the leaderboard entry
            $table->enum('period', ['daily', 'weekly', 'monthly']); // Leaderboard period
            $table->date('date'); // Specific date for the leaderboard entry
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('leaderboards');
    }
}