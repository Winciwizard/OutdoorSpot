<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo('App\User');
    }

    /**
     * @return BelongsTo
     */
    public function post(): BelongsTo
    {
        return $this->belongsTo('App\Post');
    }
}
