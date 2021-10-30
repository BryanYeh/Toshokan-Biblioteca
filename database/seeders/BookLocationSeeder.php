<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory;
use Illuminate\Support\Str;
use Carbon\Carbon;

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

        for ($i = 0; $i < 97; $i++) {
            DB::table('book_locations')->insert([
                'book_id' => $i+1,
                'location_id' => $faker->numberBetween(1, 3),
                'barcode' => $faker->unique()->numerify('0000################'),
                'call_number' => $faker->bothify('?????-#####'),
                'section' => $faker->randomElement(['children','young adult','adult','non-fiction']),
                'price' => $faker->randomFloat(2,1,999),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }

        for ($i = 0; $i < 30; $i++) {
            DB::table('book_locations')->insert([
                'book_id' => $faker->numberBetween(1, 97),
                'location_id' => $faker->numberBetween(1, 3),
                'barcode' => $faker->unique()->numerify('0000################'),
                'call_number' => $faker->bothify('?????-#####'),
                'section' => $faker->randomElement(['children','young adult','adult','non-fiction']),
                'price' => $faker->randomFloat(2,1,999),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }
    }
}
