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

        // small selection of subjects from Barnes and Nobles
        // https://www.barnesandnoble.com/h/books/browse
        $subjects = [
            'Generic Fiction',              // 1
            'Graphic Novels',               // 2
            'Horror',                       // 3
            'Literary Fiction',             // 4
            'Mystery & Crime',              // 5
            'Romance',                      // 6
            'Science Fiction & Fantasy',    // 7

            'Kids',                         // 8
            'Teens & Young Adult',          // 9

            'Art',                          // 10
            'Computers',                    // 11
            'Education',                    // 12
            'Foreign Languages',            // 13
            'History',                      // 14
            'Nature',                       // 15
            'Philosophy'                    // 16
        ];

        foreach($subjects as $subject){
            DB::table('subjects')->insert([
                'subject' => $subject
            ]);
        }

    }
}
