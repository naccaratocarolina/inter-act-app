<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Comment;
use Faker\Generator as Faker;

$factory->define(Comment::class, function (Faker $faker) {
    return [
        'commentary' => $faker->sentence($nbWords = 10, $variableNbWords = true),
        //'user_id' => factory('App\User')->create()->id,
        //'article_id' => factory('App\Article')->create()->id,
    ];
});
