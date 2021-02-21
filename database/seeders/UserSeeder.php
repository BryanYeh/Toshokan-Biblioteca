<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Faker\Factory;

class UserSeeder extends Seeder
{
    protected $model = User::class;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        for ($i = 0; $i < 500; $i++) {
            $user_type = $faker->randomElement(['librarian','patron','visitor']);

            DB::table('users')->insert([
                'user_type' => $user_type,
                'username' => $faker->unique()->username(),
                'card_number' => $user_type === 'patron' ? $faker->unique()->numerify('0000########') : null,
                'email' => $faker->unique()->safeEmail,
                'email_verified_at' => now(),
                'password' => Hash::make($faker->password()),
                'first_name' => $faker->firstName(),
                'last_name' => $faker->lastName(),
                'dob' => $user_type === 'patron' ? Carbon::createFromTimestamp($faker->dateTimeBetween('-100 years', '-1 year')->getTimestamp()) : null,
                'address1' => $user_type === 'patron' ? $faker->streetAddress() : null,
                'address2' => $user_type === 'patron' ? $faker->randomElement([$faker->secondaryAddress(),'']) : null,
                'city' => $user_type === 'patron' ? $faker->city() : null,
                'state' => $user_type === 'patron' ? $faker->state() : null,
                'postal_code' => $user_type === 'patron' ? $faker->postcode() : null,
                'country' => $user_type === 'patron' ? $faker->country() : null,
                'phone' => $user_type === 'patron' ? $faker->phoneNumber() : null,
            ]);
        }
    }
}
