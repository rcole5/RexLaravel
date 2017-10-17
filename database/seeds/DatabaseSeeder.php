<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
//        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        $this->call(ActorsTableSeeder::class);
        $this->call(GenreSeeder::class);
        $this->call(MoviesTableSeeder::class);
        $this->call(ActorGenresTableSeeder::class);
        $this->call(ActorMoviesTableSeeder::class);
        $this->call(MovieGenresSeeder::class);
//        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

    }
}
