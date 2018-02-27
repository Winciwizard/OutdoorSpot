<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    const LIKE = 1;
    const UNLIKE = 0;

    public function post(){
        return $this->belongsTo('App\Post');
    }

    public static function getLike($like){
        $likes = [
            self::LIKE => "like",
            self::UNLIKE => "unlike"
        ];

        return $likes[$like];
    }

}
