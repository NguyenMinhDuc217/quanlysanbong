<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bills', function (Blueprint $table) {
            $table->id();
            $table->string('detail_set_pitch_id',255);
            $table->string('user_id',255);
            $table->string('transaction_id',255)->nullable();
            $table->string('bill_number',255);
            $table->string('trace_number',255)->nullable();
            $table->string('price',255)->default(0);
            $table->string('createdate',255);
            $table->string('bank',255);
            $table->string('transfer_content',255)->nullable();
            $table->string('status',255);
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
        Schema::dropIfExists('bills');
    }
}
