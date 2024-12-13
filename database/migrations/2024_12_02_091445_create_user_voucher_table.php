<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserVoucherTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_voucher', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->unsignedBigInteger('user_id'); // Foreign key ke users
            $table->unsignedBigInteger('voucher_id'); // Foreign key ke vouchers
            $table->timestamp('redeemed_at')->nullable(); // Waktu penukaran
            $table->timestamp('expired_at')->nullable();
            $table->timestamps(); // Timestamps
    
            // Foreign key constraints
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('voucher_id')->references('id')->on('vouchers')->onDelete('cascade');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('user_voucher');
    }
    
}
