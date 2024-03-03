<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Verify_document;
use Faker\Generator as Faker;

$factory->define(Verify_document::class, function (Faker $faker) {

    return [
        'serial_number' => $faker->word,
        'perihal' => $faker->word,
        'nim' => $faker->word,
        'created_by' => $faker->randomDigitNotNull,
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s')
    ];
});
