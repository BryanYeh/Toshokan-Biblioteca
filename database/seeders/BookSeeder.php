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
        $titles = [
            "altering the east",
            "a day with my imagination",
            "a new form",
            "androids and figures",
            "assassin of heaven",
            "athletes and devils",
            "athletes and queens",
            "bears and girls",
            "beloved of lust",
            "blacksmiths and strangers",
            "blank paper",
            "bliss left me",
            "bliss of the idea",
            "boy makeover",
            "bravery at spells",
            "cats and fiends",
            "celebrating the new planet",
            "clumsy at my town",
            "corrupted in the graves",
            "country in my house",
            "creation of hope",
            "creators and assassins",
            "criminal setup",
            "dears at my school",
            "death at the past",
            "dishonor with wings",
            "dogs in your garden",
            "dragon invasion",
            "earth to unknown",
            "exploration of the flight",
            "eye of the wolf",
            "figure hiding from me",
            "foreigner and mouse",
            "foreigner of dread",
            "foxes and kings",
            "friend of parody",
            "fungi of medicine",
            "ghosts of the moon",
            "giant without a home",
            "girls and boys",
            "gods of the depths",
            "guarding her parents",
            "guest in the past",
            "guests in the center of the earth",
            "harlequin and friend",
            "hidden by the river",
            "honeys and husbands",
            "honored by the lands",
            "hope of the invaders",
            "horses during Halloween",
            "hunter of the vacuum",
            "inventor of dawn",
            "king without a home",
            "kings without a goal",
            "languages of science",
            "laughter in the museum",
            "life after moon rocks",
            "lions and foes",
            "lions without shame",
            "lords of the night",
            "loss of the mountains",
            "maid with a cheeky smile",
            "man from the forests",
            "medics of time",
            "men of the orbit",
            "mice of life",
            "mistresses and assistants",
            "mouse of mysteries",
            "perfume of the galaxy",
            "pilots and hobgoblins",
            "planners and spies",
            "prepare for my girlfriend",
            "prince of stone",
            "queens without restrictions",
            "raven with rotten skin",
            "respect for the job",
            "revenge without a conscience",
            "rise of stone",
            "robots and defenders",
            "shadows at the graveyard",
            "shield of wonder",
            "songs of the apocolypse",
            "star of the stars",
            "stars of the west",
            "strangers under my bed",
            "strife of yesterday",
            "students and guests",
            "temptations of hell",
            "the angel and the star",
            "trinkets of tomorrow",
            "vampires of misfortune",
            "vision without time",
            "whispers of my home",
            "who took my book?",
            "wife of the great",
            "woman of the forest",
            "zombies of the plague"
        ];
        $faker = Factory::create();

        foreach($titles as $title) {
            $last_word = explode(" ", $title);
            $last_word = end($last_word);
            
            DB::table('books')->insert([
                'title' => Str::of($title)->title(),
                'slug' => Str::slug($title),
                'isbn' => $faker->isbn13(),
                'edition' => $faker->optional()->randomElement(['1st Edition', '2nd Edition', '3rd Edition', 'Revised Edition', 'Collectors Edition']),
                'summary' => $faker->paragraph(5),
                'language' => $faker->languageCode(),
                'image' => "https://source.unsplash.com/random/500×300/?" . $last_word,
                'author' => $faker->name(),
                'publisher' => $faker->company(),
                'publication_date' => Carbon::createFromTimestamp($faker->dateTimeBetween('-100 years', '-1 year')->getTimestamp()),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }
    }
}
