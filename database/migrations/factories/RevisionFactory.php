<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Revision;
use Faker\Generator as Faker;

$factory->define(Revision::class, function (Faker $faker) {

    return [
        'schedule_id' => $faker->randomDigitNotNull,
        'deskripsi' => $faker->text,
        'hal' => $faker->word,
        'status' => $faker->word,
        'dokumen_id' => $faker->randomDigitNotNull
    ];
});
