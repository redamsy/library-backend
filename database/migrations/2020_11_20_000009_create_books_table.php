<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->text('description');
            $table->timestamp('publishDate');
            $table->decimal('price');
            $table->integer('chapters');
            $table->integer('pages');
            $table->string('imageName');
            $table->string('pdfName');
            $table->boolean('isProhibited')->default(false);
            $table->integer('publisher_id')->unsigned()->nullable();
            $table->foreign('publisher_id')->references('id')->on('publishers');
            $table->integer('serie_id')->unsigned();
            $table->foreign('serie_id')->references('id')->on('series');
            $table->integer('language_id')->unsigned();
            $table->foreign('language_id')->references('id')->on('languages');
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
        Schema::dropIfExists('books');
    }
}
