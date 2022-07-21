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
            $table->string('ticket_id')->nullable();
            $table->integer('picth_id');
            $table->integer('user_id');
            $table->date('date_event')->nullable();
            $table->dateTime('start_time');
            $table->dateTime('end_time');
            $table->string('price_pitch');
            $table->string('total');
            $table->string('ispay')->default(0);
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
