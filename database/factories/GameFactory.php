<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Game;
use Faker\Generator as Faker;

$factory->define(Game::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'identifier' => $faker->randomAscii,
        'appid' => $faker->randomNumber(4),
        'logo' => $faker->url
    ];
});
