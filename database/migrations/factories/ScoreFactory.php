<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Score;
use Faker\Generator as Faker;

$factory->define(Score::class, function (Faker $faker) {

    return [
        'value' => $faker->randomDigitNotNull,
        'percentage' => $faker->randomDigitNotNull,
        'component_id' => $faker->randomDigitNotNull,
        'jadwal_id' => $faker->randomDigitNotNull
    ];
});
