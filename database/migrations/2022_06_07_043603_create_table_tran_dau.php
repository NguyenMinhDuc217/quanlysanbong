<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableTranDau extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tran_dau', function (Blueprint $table) {
            $table->id();
            $table->integer('san_id');
            $table->date('ngay_dien_ra');
            $table->dateTime('gio_bat_dau');
            $table->dateTime('gio_ket_thuc');
            $table->string('tinh_trang');
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
        Schema::dropIfExists('tran_dau');
    }
}
