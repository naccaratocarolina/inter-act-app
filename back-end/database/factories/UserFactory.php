<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use Faker\Generator as Faker;

$factory->define(User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'profile_picture' =>  $faker->imageUrl($width = 640, $height = 480),
        'description' => $faker->sentence($nbWords = 10, $variableNbWords = true),
        'following_count' => $faker->numberBetween($min = 0, $max = 100),
        'follower_count' => $faker->numberBetween($min = 0, $max = 100),
        'email_verified_at' => now(),
        'password' => bcrypt('senha123'),
        'remember_token' => Str::random(10),
    ];
});
