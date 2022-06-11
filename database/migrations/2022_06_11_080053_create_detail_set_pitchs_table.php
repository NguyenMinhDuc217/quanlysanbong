<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailSetPitchsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_set_pitchs', function (Blueprint $table) {
            $table->id();
            $table->integer('picth_id');
            $table->integer('user_id');
            $table->integer('service_id');
            $table->date('date_event');
            $table->dateTime('start_time');
            $table->dateTime('end_time');
            $table->string('total');
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
        Schema::dropIfExists('detail_set_pitchs');
    }
}
