<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\StatusLog;
use Faker\Generator as Faker;

$factory->define(StatusLog::class, function (Faker $faker) {

    return [
        'feedback' => $faker->text,
        'created_by' => $faker->randomDigitNotNull,
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'sidangs_id' => $faker->randomDigitNotNull,
        'workflow_type' => $faker->word,
        'name' => $faker->word
    ];
});
