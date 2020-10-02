<?php

namespace App\Http\Helpers;

use Illuminate\Database\Eloquent\Collection;
use App\User, App\Post, App\Comment, App\Image;

class CommonHelper
{
    public function getActiveUsers(): Collection
    {
        $users = User::where('active', true)->get(['id', 'name']);

        if ($users->isEmpty())
            return collect([]);

        $userIds = $users->pluck('id')->all();

        $posts = Post::leftJoin('images as i', 'i.id', '=', 'posts.image_id')
            ->select(
                'posts.id',
                'posts.content',
                'i.url as image_url',
                'posts.author_id'
            )
            ->whereIn('posts.author_id', $userIds)
            ->get();

        return $users->map(function ($user) use($posts) {
            $userPosts = $posts->where('author_id', $user->id);

            // 6.1
            if(!empty(request('posts_limit')))
                $userPosts = $userPosts->take(request('posts_limit'));

            $userPosts = $userPosts->all();

            foreach ($userPosts as &$userPost)
                unset($userPost->author_id);

            unset($userPost);

            $user->posts = $userPosts;


            return $user;
        });
    }
}
