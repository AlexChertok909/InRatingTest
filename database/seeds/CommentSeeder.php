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

		$comments = Comment::get();
        $randomComments = $comments->random(21);

        $randomComments->each(function ($comment) {
            $comment->delete();
        });


        $randomPosts= $posts->random(21);

        $randomPosts->each(function ($post) {
            $post->image_id = null;
			$post->save();
        });

    }
}
