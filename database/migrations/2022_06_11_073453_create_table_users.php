<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username',255)->nullable();
            $table->string('email',255);
            $table->string('password')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('wallet',255)->nullable();
            $table->string('status',255)->nullable();
            $table->string('created_by',255)->nullable();
            $table->string('time_login',255)->nullable();
            $table->string('token');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
