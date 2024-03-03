<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\CLO;
use Faker\Generator as Faker;

$factory->define(CLO::class, function (Faker $faker) {

    return [
        'code' => $faker->word,
        'precentage' => $faker->randomDigitNotNull,
        'description' => $faker->text,
        'period_id' => $faker->randomDigitNotNull,
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s')
    ];
});
