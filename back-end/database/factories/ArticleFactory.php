<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Article;
use Faker\Generator as Faker;

$factory->define(Article::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence($nbWords = 5, $variableNbWords = true),
        'subtitle' => $faker->sentence($nbWords = 10, $variableNbWords = true),
        'text' => $faker->paragraph($nbSentences = 5, $variableNbSentences = true),
        'image' => $faker->imageUrl($width = 640, $height = 480),
        'category' => $faker->randomElement($categories = array('Comida','Arte', 'Atividade Física', 'Viagem')),
        'date' => $faker->dateTimeBetween($startDate = '-2 years', $endDate = 'now', $timezone = 'America/Sao_Paulo'),
        'likes_count' => $faker->numberBetween($min = 0, $max = 100),
        'user_id' => factory('App\User')->create()->id,
    ];
});
