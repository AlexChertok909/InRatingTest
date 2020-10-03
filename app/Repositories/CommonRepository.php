<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use App\User, App\Post, App\Comment, App\Image;

class CommonRepository
{
    public function getPostsByUserIds(array $userIds): Collection
    {
        return Post::leftJoin('images as i', 'i.id', '=', 'posts.image_id')
            ->select(
                'posts.id',
                'posts.content',
                'i.url as image_url',
                'posts.author_id'
            )
            ->whereIn('posts.author_id', $userIds)
            ->get();
    }
}
