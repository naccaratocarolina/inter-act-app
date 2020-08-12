<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Article;
use Faker\Generator as Faker;

$factory->define(Article::class, function (Faker $faker) {
    return [
        'title' => $faker->text,
        'subtitle' => $faker->text,
        'text' => $faker->text,
        'category' => $faker->randomElement($categories = array('Comida','Arte', 'Atividade Física', 'Viagem')),
        'user_id' => factory('App\User')->create()->id,
    ];
});
