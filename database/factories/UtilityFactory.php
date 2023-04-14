<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Utility;
use Faker\Generator as Faker;

$factory->define(Utility::class, function (Faker $faker) {
    return [
        'per_page' => 2,
        'user_id' => 1
    ];
});
