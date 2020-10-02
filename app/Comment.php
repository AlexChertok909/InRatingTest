<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'post_id', 'commentator_id', 'content',
    ];

    /**
     * Get the comment to which the post belongs.
     */
    public function post()
    {
        return $this->belongsTo('App\Post');
    }

    /**
     * Get the comment to which the user belongs.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
