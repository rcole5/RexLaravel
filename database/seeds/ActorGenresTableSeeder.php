<?php

use App\ActorGenre;
use App\Models\Actor;
use App\Models\Genre;
use Illuminate\Database\Seeder;

class ActorGenresTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ActorGenre::truncate();

        factory(Actor::class, 30)->create();
        factory(Genre::class, 10)->create();

        $genres = Genre::all();

        Actor::all()->each(function ($actor) use ($genres) {
             $actor->genres()->attach(
                 $genres->random(rand(1,3))->pluck('id')->toArray()
             );
        });
    }
}
