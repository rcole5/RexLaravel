<?php

use Faker\Generator as Faker;
$factory->define(\App\Models\Movie::class, function (Faker $faker) {

    return [
        'title' => $faker->name,
        'rating' => $faker->randomFloat(2, 0, 10),
        'description' => $faker->sentence(10, true),
        'image' => $faker->imageUrl(600, 600),
    ];

});
