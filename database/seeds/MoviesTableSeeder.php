<?php

use App\Models\Movie;
use Illuminate\Database\Seeder;

class MoviesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Movie::truncate();

        for ($i = 0; $i < 35; $i++) {
            factory(Movie::class)->create();
        }
    }
}
