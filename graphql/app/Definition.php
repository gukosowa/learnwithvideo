<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Definition extends Model
{
    protected $fillable = [
        'word', 'furigana', 'part_of_speech', 'definition', 'image', 'ispeech_id', 'jlpt', 'tags'
    ];

    public function words()
    {
        return $this->hasMany(Word::class, 'definition_id');
    }
}
