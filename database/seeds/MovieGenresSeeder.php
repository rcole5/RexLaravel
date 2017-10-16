<?php

use App\Models\Genre;
use App\Models\Movie;
use App\MovieGenre;
use Illuminate\Database\Seeder;

class MovieGenresSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MovieGenre::truncate();

        factory(Movie::class, 20)->create();
        factory(Genre::class, 10)->create();

        $genres = Genre::all();

        Movie::all()->each(function ($movie) use ($genres) {
           $movie->genres()->attach(
               $genres->random(rand(1,3))->pluck('id')->toArray()
            );
        });
    }
}
