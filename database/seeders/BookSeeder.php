<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory;
use Illuminate\Support\Str;
use Carbon\Carbon;


class BookSeeder extends Seeder
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
            DB::table('books')->insert([
                'title' => Str::of($faker->words(4, true))->title(),
                'isbn' => $faker->isbn13(),
                'edition' => $faker->optional()->randomElement(['1st Edition', '2nd Edition', '3rd Edition', '4th Edition', '5th Edition', '6th Edition', '7th Edition', '8th Edition', '9th Edition', '10th Edition']),
                'summary' => $faker->text(150),
                'language' => $faker->languageCode(),
                'image' => $faker->optional()->randomElement([$faker->md5() . '.jpg']),
                'author' => $faker->name(),
                'publisher' => $faker->company(),
                'publication_date' => Carbon::createFromTimestamp($faker->dateTimeBetween('-100 years', '-1 year')->getTimestamp())
            ]);
        }
    }
}
