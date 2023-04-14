<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
namespace Database\Factories;

use App\User;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

$factory->define(User::class, function (Faker $faker) {
    return [
        'name' => Str::random(10),
        'email' => Str::random(10).'@gmail.com',
        'password' => Hash::make('password'),//Password je reč "password".
        "role_id" => 2
    ];
});
