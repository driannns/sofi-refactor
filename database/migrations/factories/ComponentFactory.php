<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Component;
use Faker\Generator as Faker;

$factory->define(Component::class, function (Faker $faker) {

    return [
        'code' => $faker->word,
        'description' => $faker->text,
        'percentage' => $faker->randomDigitNotNull,
        'unsur_penilaian' => $faker->text,
        'pembimbing' => $faker->word,
        'penguji' => $faker->word,
        'clo_id' => $faker->randomDigitNotNull
    ];
});
