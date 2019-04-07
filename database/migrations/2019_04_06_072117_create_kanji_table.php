<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKanjiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kanji', function (Blueprint $table) {
            $table->bigIncrements('id')->autoIncrement();
            $table->string('kanji', 10);
            $table->smallInteger('strokes');
            $table->string('reading', 60);
            $table->smallInteger('grade');
            $table->smallInteger('jlpt');
            $table->integer('freq');
            $table->text('translation_on');
            $table->text('translation_kun');
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
        Schema::dropIfExists('kanji');
    }
}
