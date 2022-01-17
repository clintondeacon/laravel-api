<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Company;

class CompanyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Company::truncate();

        Company::create(['parent_id' => null,"company_ids" => "1,2,3", 'name' => "Company A",]);
        Company::create(['parent_id' => 1,"company_ids" => "2,3", 'name' => "Company B",]);
        Company::create(['parent_id' => 2,"company_ids" => "3", 'name' => "Company C",]);


    }
}
