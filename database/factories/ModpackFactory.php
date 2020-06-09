<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Modpack;
use Faker\Generator as Faker;

$factory->define(Modpack::class, function (Faker $faker) {
    return [
        'name' => "@{$faker->firstName}",
        'disk' => 'modpacks',
        'path' => $faker->firstName
    ];
});
