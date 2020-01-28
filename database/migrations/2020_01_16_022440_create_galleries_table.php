<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGalleriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('galleries', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nama');
            $table->string('slug');
            $table->text('konten');
            $table->double('harga');
            $table->string('foto');
            $table->float('stok')->nullable();
            $table->unsignedbigInteger('id_kategori');
            $table->foreign('id_kategori')->references('id')
            ->on('kategoris')->onDelete('cascade');
            // $table->unsignedbigInteger('id_user');
            // $table->foreign('id_user')->references('id')
            //  ->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('galleries');
    }
}
