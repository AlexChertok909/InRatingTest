<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use App\User, App\Post, App\Comment, App\Image;
use App\CompanyUser, App\Company, App\Country;

class CommonRepository
{
    /**
     * @param array $userIds
     * @return Collection
     */
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

    /**
     * @param int $userId
     * @return array
     */
    public function getCommentsByUserIdSQL(int $userId): array
    {
        return DB::select(DB::raw("SELECT comments.* FROM comments
            LEFT JOIN posts ON comments.post_id = posts.id
            WHERE posts.image_id IS NOT NULL AND comments.commentator_id = :userId
            ORDER BY comments.created_at DESC"), array(
            'userId' => $userId,
        ));
    }

    /**
     * @param int $userId
     * @return Collection
     */
    public function getCommentsByUserId(int $userId): Collection
    {
        return Comment::withTrashed()
            ->leftJoin('posts as p', 'p.id', '=', 'comments.post_id')
            ->select('comments.*')
            ->where('comments.commentator_id', $userId)
            ->whereNotNull('p.image_id')
            ->orderBy('comments.created_at', 'desc')
            ->get();
    }

    /**
     * @param int $userId
     * @return Collection
     */
    public function getCommentsByUserIdLoad(int $userId)
    {
        return Comment::with('post')
            ->withTrashed()
            ->leftJoin('posts as p', 'p.id', '=', 'comments.post_id')
            ->select('comments.*')
            ->where('comments.commentator_id', $userId)
            ->whereNotNull('p.image_id')
            ->orderBy('comments.created_at', 'desc')
            ->get();
    }

    public function getUserByCountry($country)
    {
        return Country::with('companies.users.companies')
            ->where('name', $country)
            ->first();
    }
}
