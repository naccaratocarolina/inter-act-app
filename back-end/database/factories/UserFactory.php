<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use Faker\Generator as Faker;

//make fake informantion for DB
$factory->define(User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'profile_picture' =>  $faker->imageUrl($width = 500, $height = 640),
        'description' => $faker->sentence($nbWords = 10, $variableNbWords = true),
        'following_count' => $faker->numberBetween($min = 0, $max = 100),
        'follower_count' => $faker->numberBetween($min = 0, $max = 100),
        'email_verified_at' => now(),
        'password' => bcrypt('senha123'),
        'remember_token' => Str::random(10),
    ];
});
