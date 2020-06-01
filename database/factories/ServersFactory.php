<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Server;
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

$factory->define(Server::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'picture' => $faker->url,
        'ip' => $faker->ipv4,
        'port' => $faker->randomNumber(4),
        'data' => '{}',
        'modpacks' => json_encode([
            "@Test"
        ]),
        'game_id' => fn() => factory(\App\Game::class)->create()->first()->id
    ];
});
