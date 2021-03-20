<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory;
use Illuminate\Support\Str;

class BookLocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        for ($i = 0; $i < 1000; $i++) {
            DB::table('book_locations')->insert([
                'book_id' => $i+1,
                'location_id' => $faker->numberBetween(1, 3),
                'barcode' => $faker->unique()->numerify('0000################'),
                'call_number' => $faker->bothify('?????-#####'),
                'location' => $faker->randomElement(['children','young adult','adult','non-fiction']),
                'price' => $faker->randomFloat(2,1,999)
            ]);
        }

        for ($i = 0; $i < 200; $i++) {
            DB::table('book_locations')->insert([
                'book_id' => $faker->numberBetween(1, 1000),
                'location_id' => $faker->numberBetween(1, 3),
                'barcode' => $faker->unique()->numerify('0000################'),
                'call_number' => $faker->bothify('?????-#####'),
                'location' => $faker->randomElement(['children','young adult','adult','non-fiction']),
                'price' => $faker->randomFloat(2,1,999)
            ]);
        }
    }
}
