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

        Company::create(['parent_id' => null, 'name' => "Company A",]);
        Company::create(['parent_id' => 1, 'name' => "Company B",]);
        Company::create(['parent_id' => 2, 'name' => "Company C",]);


    }
}
