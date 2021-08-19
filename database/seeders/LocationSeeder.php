<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        for ($i = 0; $i < 3; $i++) {
            DB::table('locations')->insert([
                'name' => $faker->unique()->company(),
                'address1' => $faker->streetAddress(),
                'address2' => $faker->randomElement([$faker->secondaryAddress(),null]),
                'city' => $faker->city(),
                'state' => $faker->state(),
                'postal_code' => $faker->postcode(),
                'country' => $faker->country(),
                'phone' => $faker->phoneNumber(),
            ]);
        }
    }
}
