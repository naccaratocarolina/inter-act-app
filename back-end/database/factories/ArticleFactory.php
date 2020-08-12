<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Article;
use Faker\Generator as Faker;

$factory->define(Article::class, function (Faker $faker) {
    return [
        'title' => $faker->text,
        'subtitle' => $faker->text,
        'text' => $faker->text,
        'image' => $faker->imageUrl($width = 640, $height = 480),
        'category' => $faker->randomElement($categories = array('Comida','Arte', 'Atividade Física', 'Viagem')),
        'likes_count' => $faker->numberBetween($min = 0, $max = 100),
        'user_id' => factory('App\User')->create()->id,
    ];
});
