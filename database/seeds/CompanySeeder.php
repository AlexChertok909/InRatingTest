<?php

use Illuminate\Database\Seeder;
use App\Company;
use App\Country;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $countries = Country::all();

        $countries->each(function ($country) {
            for ($i = 1; $i <= 5; $i++) {
                Company::create(['name' => 'Country '. $country->id.' Company '. $i, 'country_id' => $country->id]);
            }
        });
    }
}
