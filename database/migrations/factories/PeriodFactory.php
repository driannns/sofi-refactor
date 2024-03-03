<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Period;
use Faker\Generator as Faker;

$factory->define(Period::class, function (Faker $faker) {

    return [
        'start_date' => $faker->word,
        'end_date' => $faker->word,
        'description' => $faker->text,
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s')
    ];
});
