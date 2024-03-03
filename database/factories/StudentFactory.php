<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Student;
use Faker\Generator as Faker;

$factory->define(Student::class, function (Faker $faker) {

    return [
        'status' => $faker->word,
        'tak' => $faker->word,
        'eprt' => $faker->word,
        'studentscol' => $faker->word,
        'user_id' => $faker->randomDigitNotNull,
        'team_id' => $faker->randomDigitNotNull
    ];
});
