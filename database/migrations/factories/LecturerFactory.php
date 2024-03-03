<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Lecturer;
use Faker\Generator as Faker;

$factory->define(Lecturer::class, function (Faker $faker) {

    return [
        'nip' => $faker->word,
        'code' => $faker->word,
        'jfa' => $faker->word,
        'kk' => $faker->word,
        'user_id' => $faker->randomDigitNotNull
    ];
});
