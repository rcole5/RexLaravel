<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\Models\Actor::class, function (Faker $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'dob' => $faker->date(),
        'age' => $faker->numberBetween(18, 80),
        'bio' => $faker->sentence(10, true),
        'image' => $faker->imageUrl(600, 600, 'people'),
    ];
});
