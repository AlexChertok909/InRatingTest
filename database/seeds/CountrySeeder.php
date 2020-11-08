<?php

use Illuminate\Database\Seeder;
use App\Country;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Country::create(['name' => 'Канада']);
        Country::create(['name' => 'Франция']);
        Country::create(['name' => 'Украина']);
    }
}
