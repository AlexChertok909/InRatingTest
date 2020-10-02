<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'author_id', 'image_id', 'content',
    ];

    /**
     * Get the post to which the user belongs.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Get the post to which the user belongs.
     */
    public function image()
    {
        return $this->belongsTo('App\Image');
    }

    /**
     * Get the comments for the post.
     */
    public function comments()
    {
        return $this->hasMany('App\Comment');
    }
}
