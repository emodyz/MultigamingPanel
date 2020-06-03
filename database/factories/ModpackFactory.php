<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Modpack;
use Faker\Generator as Faker;

$factory->define(Modpack::class, function (Faker $faker) {
    return [
        'name' => "@{$faker->firstName}",
        'path' => "modpacks/{$faker->firstName}",
        'manifest' => $faker->url,
        'manifest_last_update' => $faker->date()
    ];
});
