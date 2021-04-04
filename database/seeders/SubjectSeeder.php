<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        // subjects from barnes and nobles
        $subjects = [
            'Generic Fiction',
            'Graphic Novels',
            'Comics',
            'Historical Fiction',
            'Horror',
            'Literary Fiction',
            'Literature',
            'Mystery',
            'Crime & Crime',
            'Poetry',
            'Romance',
            'Science Fiction & Fantasy',
            'Thrillers',
            'Western',
            'Kids',
            'Teens',
            'Young Adult',
            'Activities & Games',
            'Art',
            'Astrology',
            'Biography',
            'Business',
            'Computers',
            'Cookbook & Food',
            'Crafts & Hobbies',
            'Politics',
            'Diet, Health & Fitness',
            'Education',
            'Engineering',
            'Foreign Languages',
            'History',
            'Home & Garden',
            'Law',
            'Medicine',
            'Music & Film',
            'Nature',
            'Nonfiction',
            'Parenting & Family',
            'Pets',
            'Philosophy',
            'Religion'
        ];

        foreach($subjects as $subject){
            DB::table('subjects')->insert([
                'uuid' => $faker->uuid(),
                'subject' => $subject
            ]);
        }

    }
}
