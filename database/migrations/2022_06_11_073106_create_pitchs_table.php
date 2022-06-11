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
            $table->string('describe',255)->nullable();
            $table->string('type_pitch',255);
            $table->string('avartar',255)->nullable();
            $table->string('screenshort',255)->nullable();
            $table->string('average_rating')->nullable();
            $table->integer('total_rating')->nullable();
            $table->integer('total_set')->nullable();
            $table->string('status')->nullable();
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
