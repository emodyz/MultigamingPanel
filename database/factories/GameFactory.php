<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Game;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Game::class, function (Faker $faker) {
    return [
        'name' => $faker->firstName,
        'identifier' => Str::lower($faker->firstName),
        'appid' => $faker->randomNumber(4),
        'logo' => $faker->url
    ];
});
