<?php

use Illuminate\Database\Seeder;
use App\Company;
use App\CompanyUser;

class CompanyUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $companies = Company::all();

        $companies->each(function ($company, $key) {
            for ($i = 1; $i <= 4; $i++) {
                CompanyUser::create(['company_id' => $company->id, 'user_id'=> $i * ($key+1)]);

            }
        });

        CompanyUser::create(['company_id' => 1, 'user_id'=> 60]);
        CompanyUser::create(['company_id' => 1, 'user_id'=> 56]);
        CompanyUser::create(['company_id' => 2, 'user_id'=> 52]);
        CompanyUser::create(['company_id' => 2, 'user_id'=> 48]);
    }
}
