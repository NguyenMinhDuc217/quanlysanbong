<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use phpDocumentor\Reflection\Types\Nullable;
use PHPUnit\Framework\Test;

class CreatePitchsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pitchs', function (Blueprint $table) {
            $table->id();
            $table->string('name',255);
            $table->string('price')->nullable();
            $table->string('discount')->nullable();
            $table->string('describe',255)->nullable();
            $table->string('type_pitch',255);
            $table->string('avartar',255)->nullable();
            $table->string('screenshort',255)->nullable();
            $table->integer('five')->default(0);
            $table->integer('four')->default(0);
            $table->integer('three')->default(0);
            $table->integer('two')->default(0);
            $table->integer('one')->default(0);
            $table->string('average_rating')->default(0);
            $table->integer('total_rating')->default(0);
            $table->integer('total_set')->default(0);
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
        Schema::dropIfExists('pitchs');
    }
}
