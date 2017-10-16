<?php

use \App\Models\Actor;
use Illuminate\Database\Seeder;

class ActorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Remove all previouse records.
        Actor::truncate();

        $faker = \Faker\Factory::create();

        for ($i = 0; $i < 35; $i++) {
            factory(Actor::class)->create();
        }
    }
}
