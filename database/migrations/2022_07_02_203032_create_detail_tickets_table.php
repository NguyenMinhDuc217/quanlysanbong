<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_tickets', function (Blueprint $table) {
            $table->id();
            $table->string('ticket_id');
            $table->string('sercive_id');
            $table->dateTime('start_time');
            $table->dateTime('end_time');
            $table->string('pitch_id');
            $table->string('status');
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
        Schema::dropIfExists('detail_tickets');
    }
}
