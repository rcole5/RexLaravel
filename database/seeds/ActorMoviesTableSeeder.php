<?php

use App\ActorMovie;
use App\Models\Actor;
use App\Models\Movie;
use Illuminate\Database\Seeder;

class ActorMoviesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ActorMovie::truncate();

        factory(Actor::class, 30)->create();
        factory(Movie::class, 20)->create();

        $actors = Actor::all();

        Movie::all()->each(function ($movie) use ($actors) {
            $actor = $actors->random(1, 3);
            $movie->actors()->attach(
                $actor->pluck('id'),
                ['character_name' => $actor->pluck('name')[0]]
            );
        });
    }
}
