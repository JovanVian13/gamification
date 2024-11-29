<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBadgesTable extends Migration
{
    public function up()
    {
        Schema::create('badges', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('criteria');
            $table->string('image');
            $table->text('description')->nullable();
            $table->timestamps();
        });

        // Pivot table for user-badge relationship
        Schema::create('badge_user', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('badge_id');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('badge_id')->references('id')->on('badges')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('badge_user');
        Schema::dropIfExists('badges');
    }
}