<?php

use Illuminate\Database\Seeder;
use App\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $active = true;

        for ($i = 1; $i <= 100; $i++) {
            if (in_array($i, [5, 7]))
                $active = false;

            User::create([
                'name' => 'test' . $i,
                'email' => 'email' . $i . '@mail.com',
                'password' => 'pass12345',
                'active' => $active,
            ]);

            $active = true;
        }
    }
}
