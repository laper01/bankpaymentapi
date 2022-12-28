<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('va', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('name');
            $table->enum('billing_type', ['c','o']);
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->dateTime('datetime_expired');
            $table->string('description')->nullable();
            $table->integer('tagihan');
            $table->string('no_rrn');
            $table->string('va');
            $table->integer('payment_amount');
            $table->boolean('va_status')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('va');
    }
}
