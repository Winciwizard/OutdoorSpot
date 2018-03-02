<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Like extends Model
{
    const LIKE = 1;
    const UNLIKE = 0;

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Like attached to ONE Post
     *
     * @return BelongsTo
     */
    public function post(): BelongsTo
    {
        return $this->belongsTo('App\Post');
    }

    /**
     * @param $like
     * @return string
     */
    public static function getLike(int $like): string
    {
        $likes = [
            self::LIKE => "like",
            self::UNLIKE => "unlike"
        ];

        return $likes[$like];
    }

}
