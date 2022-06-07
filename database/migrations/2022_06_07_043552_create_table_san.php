<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableSan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('san', function (Blueprint $table) {
            $table->id();
            $table->string('ten',255);
            $table->integer('gia');
            $table->string('mo_ta',255)->nullable();
            $table->string('dia_chi',255);
            $table->string('loai_san');
            $table->string('tinh_trang');
            $table->string('anh_dai_dien');
            $table->string('anh_hoat_dong');
            $table->integer('danh_gia_trung_binh');
            $table->integer('tong_danh_gia');
            $table->integer('tong_dat');
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
        Schema::dropIfExists('san');
    }
}
