<?php

use Illuminate\Database\Seeder;
use App\Image;

class ImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 1000; $i++) {
            Image::create([
                'url' => 'https://InRatingTest/cdn/pulic/image_' . $i . '.png',
            ]);
        }
    }
}
