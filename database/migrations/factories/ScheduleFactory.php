<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Schedule;
use Faker\Generator as Faker;

$factory->define(Schedule::class, function (Faker $faker) {

    return [
        'sidang_id' => $faker->randomDigitNotNull,
        'date' => $faker->word,
        'time' => $faker->word,
        'ruang' => $faker->text,
        'penguji1' => $faker->randomDigitNotNull,
        'penguji2' => $faker->randomDigitNotNull,
        'presentasi_file' => $faker->word,
        'status' => $faker->word,
        'keputusan' => $faker->word,
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s')
    ];
});
