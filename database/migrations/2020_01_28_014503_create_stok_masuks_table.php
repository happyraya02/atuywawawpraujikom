<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStokMasuksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stok_masuks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('galleri_id');
            $table->foreign('galleri_id')->references('id')->on('galleries')->onDelete('cascade');
            $table->integer('qty');
            $table->date('tgl');
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
        Schema::dropIfExists('stok_masuks');
    }
}
