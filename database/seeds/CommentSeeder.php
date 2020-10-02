<?php

use Illuminate\Database\Seeder;
use App\Comment, App\Post;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $posts = Post::get();

        $posts->each(function ($post) {

            for ($i = 1; $i <= 10; $i++) {

                Comment::create([
                    'post_id' => $post->id,
                    'commentator_id' => $post->author_id,
                    'content' => 'Comment - test content' . $post->id * $i,
                ]);

            }
        });

        $random = $posts->random(21);

        $random->each(function ($post) {
            $post->delete();
        });

    }
}
