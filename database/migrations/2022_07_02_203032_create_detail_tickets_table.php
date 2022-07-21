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
            $table->longText('description');
            $table->string('sercive_id');
            $table->dateTime('start_time');
            $table->dateTime('end_time');
            $table->longText('detail_time_of_week')->nullable();
            $table->string('pitch_id');
            $table->string('advise_phone')->nullable();
            $table->string('status')->default('1');
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
