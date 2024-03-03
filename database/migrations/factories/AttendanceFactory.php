<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Attendance;
use Faker\Generator as Faker;

$factory->define(Attendance::class, function (Faker $faker) {

    return [
        'schedule_id' => $faker->randomDigitNotNull,
        'user_id' => $faker->randomDigitNotNull,
        'role_sidang' => $faker->word
    ];
});
