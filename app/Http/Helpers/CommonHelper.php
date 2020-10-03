<?php

namespace App\Http\Helpers;

use Illuminate\Database\Eloquent\Collection;
use App\Repositories\CommonRepository;
use App\User, App\Comment;

/**
 * Class CommonHelper
 * @package App\Http\Helpers
 */
class CommonHelper
{
    protected $commonRepository;

    public function __construct(CommonRepository $commonRepository)
    {
        $this->commonRepository = $commonRepository;
    }

    /**
     * @return Collection
     */
    public function getActiveUsers(): Collection
    {
        $users = User::where('active', true)->get(['id', 'name']);

        if ($users->isEmpty())
            return collect([]);

        $userIds = $users->pluck('id')->all();

        $posts = $this->commonRepository->getPostsByUserIds($userIds);

        // 6.2
        $posts = $this->addComments($posts);

        return $users->map(function ($user) use ($posts) {
            $userPosts = $posts->where('author_id', $user->id);

            // 6.3
            $userPosts = $userPosts->sortBy('countOfComments');

            // 6.1
            if (!empty(request('posts_limit')))
                $userPosts = $userPosts->take(request('posts_limit'));

            $userPosts = $userPosts->all();

            foreach ($userPosts as &$userPost)
                unset($userPost->author_id);

            unset($userPost);

            $user->posts = $userPosts;

            return $user;
        });
    }

    /**
     * @param int $userId
     * @return Collection|\Illuminate\Support\Collection
     */
    public function getUserComments(int $userId)
    {
        // 7.1
        $commentsSql = $this->commonRepository->getCommentsByUserIdSQL($userId);
        $comments = $this->commonRepository->getCommentsByUserId($userId);

        // 7.2
        $comments = $this->commonRepository->getCommentsByUserIdLoad($userId);
        $comments = $this->addImage($comments);

        return $comments;
    }

    /**
     * @param Collection $posts
     * @return Collection
     */
    private function addComments(Collection $posts): Collection
    {
        $comments = Comment::get();

        return $posts->map(function ($post) use ($comments) {
            $post->countOfComments = $comments->where('post_id', $post->id)->count();
            return $post;
        });
    }

    /**
     * @param Collection $comments
     * @return Collection
     */
    private function addImage(Collection $comments): Collection
    {
        return $comments->map(function ($comment) {

            $comment->post->image = $comment->post->load('image')
                ->get();

            // 7.2.1
            $comment->post->author = User::where('id', $comment->post->author_id)
                ->where('active', true)
                ->first();

            return $comment;
        });
    }
}
