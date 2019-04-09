<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDefinitionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('definition', function (Blueprint $table) {
            $table->bigIncrements('id')->autoIncrement();
            $table->string('word', 25);
            $table->string('furigana', 25);
            $table->string('part_of_speech')->comment('n = noun, v = verb, a = Adj, i = iAdj, in = interjection na = naAdj, 
                                                c = conjunction, adv = adverb, pA = prenounAdjective, p = particle, su = suffix, pr = prefix, pp = preposition, mw = measure word,', 3);
            $table->longText('definition');
            $table->integer('jlpt');
            $table->string('tags');
            $table->string('image');
            $table->integer('ispeech_id');
            $table->string('kanji');
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
        Schema::dropIfExists('definition');
    }
}
