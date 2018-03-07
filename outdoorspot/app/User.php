<?php

namespace App;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Model implements Authenticatable
{
    use \Illuminate\Auth\Authenticatable;
    /**
     * @return HasMany
     */
    public function posts()
    {
        return $this->hasMany('App\Post');
    }

    /**
     * @return HasMany
     */
    public function comments()
    {
        return $this->hasMany('App\Post');
    }

    /**
     * @return HasMany
     */
    public function likes()
    {
        return $this->hasMany('App\Like');
    }
}
