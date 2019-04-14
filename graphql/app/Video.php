<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    // protected $fillable = [
    //     'video_link', 'video_plattform', 'title', 'description', 'views', 'difficulty'
    // ];

    public function dialogues()
    {
        return $this->hasMany(Dialogue::class); // , 'video_id'
    }

}
