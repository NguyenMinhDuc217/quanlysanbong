<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSetServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('set_services', function (Blueprint $table) {
            $table->id();
            $table->integer('set_pitch_id');
            $table->integer('service_id');
            $table->string('name',255);
            $table->integer('quantity')->default(1);
            $table->string('total',255);
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
        Schema::dropIfExists('set_services');
    }
}
