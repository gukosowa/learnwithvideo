<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Word extends Model
{
    public function definition()
    {
        return $this->belongsTo(Definition::class);
    }
}
