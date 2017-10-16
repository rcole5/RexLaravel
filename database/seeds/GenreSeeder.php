<?php

use Illuminate\Database\Seeder;

class GenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Genre::truncate();

        for ($i = 0; $i < 35; $i++) {
            factory(\App\Models\Genre::class)->create();
        }
    }
}
