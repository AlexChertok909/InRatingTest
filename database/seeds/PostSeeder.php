<?php

use Illuminate\Database\Seeder;
use App\Post, App\User;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userIds = User::where('active', true)->get('id');

        $userIds->each(function ($userId) {

            for ($i = 1; $i <= 10; $i++) {

                Post::create([
                    'author_id' => $userId->id,
                    'image_id' => $userId->id * $i,
                    'content' => 'Post - test content' . $userId->id * $i,
                ]);

            }
        });
    }
}
