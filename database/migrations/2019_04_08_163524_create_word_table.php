<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWordTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('word', function (Blueprint $table) {
            $table->bigIncrements('id')->autoIncrement();
            $table->integer('definition_id');
            $table->string('custom_definition');
            $table->string('custom_word', 60);
            $table->string('custom_furigana', 60);
            $table->integer('ispeech_id');
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
        Schema::dropIfExists('word');
    }
}
