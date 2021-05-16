<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    /**
     * Get all of the posts for the user.
     */
    public function comments()
    {
        return $this->hasMany('App\Comment');
    }
}
