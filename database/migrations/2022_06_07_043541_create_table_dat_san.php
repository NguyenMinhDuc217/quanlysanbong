<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableDatSan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dat_san', function (Blueprint $table) {
            $table->id();
            $table->integer('san_id');
            $table->integer('user_id');
            $table->integer('dich_vu_id');
            $table->date('ngay_dien_ra');
            $table->dateTime('gio_bat_dau');
            $table->dateTime('gio_ket_thuc');
            $table->double('tong_tien');
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
        Schema::dropIfExists('dat_san');
    }
}
