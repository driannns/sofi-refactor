<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Peminatan;
use Faker\Generator as Faker;

$factory->define(Peminatan::class, function (Faker $faker) {

    return [
        'nama' => $faker->word,
        'kk' => $faker->word,
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s')
    ];
});
