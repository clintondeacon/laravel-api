<?php

namespace Database\Seeders;

use App\Models\Station;
use Illuminate\Database\Seeder;

class StationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Station::truncate();

        $faker = \Faker\Factory::create();

        for ($i = 0; $i < 200; $i++) {

            Station::create([
                'name' => $faker->name,
                'latitude' => $faker->latitude(59.92248870, 60.29783890),
                'longitude' => $faker->longitude(24.78287580, 25.25448490),
                'company_id' => rand(1, 3),
                'address' => $faker->address

            ]);

        }


    }
}
