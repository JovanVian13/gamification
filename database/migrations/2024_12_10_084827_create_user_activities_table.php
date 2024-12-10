<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserActivitiesTable extends Migration
{
    public function up()
    {
        Schema::create('user_activities', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('activity_type'); // e.g., 'task_completed', 'content_interaction', 'point_conversion'
            $table->string('activity_detail')->nullable(); // e.g., 'Task Name', 'Video ID'
            $table->integer('points_earned')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_activities');
    }
}
