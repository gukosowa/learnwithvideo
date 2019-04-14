<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Definition extends Model
{
    public function words()
    {
        return $this->hasMany(Word::class, 'definition_id');
    }
}
