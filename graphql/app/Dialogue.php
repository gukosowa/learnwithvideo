<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dialogue extends Model
{
    protected $fillable = [
        'video_id', 'text', 'translation', 'time'
    ];

    public function video()
    {
        return $this->belongsTo(Video::class);
    }

    public function words()
    {
        return $this->hasMany(Word::class);
    }
}
