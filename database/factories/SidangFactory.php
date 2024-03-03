<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Sidang;
use Faker\Generator as Faker;

$factory->define(Sidang::class, function (Faker $faker) {

    return [
        'mahasiswa_id' => $faker->randomDigitNotNull,
        'pembimbing1_id' => $faker->randomDigitNotNull,
        'pembimbing2_id' => $faker->randomDigitNotNull,
        'judul' => $faker->text,
        'form_bimbingan' => $faker->word,
        'eprt' => $faker->word,
        'dokumen_ta' => $faker->word,
        'makalah' => $faker->word,
        'tak' => $faker->word,
        'status' => $faker->word,
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s'),
        'is_english' => $faker->word,
        'period_id' => $faker->randomDigitNotNull
    ];
});
