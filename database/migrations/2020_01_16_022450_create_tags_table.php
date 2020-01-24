<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tags', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nama');
            $table->string('slug');
            $table->timestamps();
        });
         Schema::create('galleri_tag', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedbigInteger('galleri_id');
            $table->foreign('galleri_id')->references('id')
            ->on('galleries')->onDelete('cascade');
            $table->unsignedbigInteger('tag_id');
            $table->foreign('tag_id')->references('id')
             ->on('tags')->onDelete('cascade');
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
        Schema::dropIfExists('tags');
    }
}
