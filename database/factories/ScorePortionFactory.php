<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\ScorePortion;
use Faker\Generator as Faker;

$factory->define(ScorePortion::class, function (Faker $faker) {

    return [
        'period_id' => $faker->randomDigitNotNull,
        'study_program_id' => $faker->word,
        'pembimbing' => $faker->randomDigitNotNull,
        'penguji' => $faker->randomDigitNotNull,
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s')
    ];
});
