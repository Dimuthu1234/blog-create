<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $guarded = [];

    /**
     * Get all of the posts for the user.
     */
    public function post()
    {
        return $this->belongsTo('App\Post');
    }
}
