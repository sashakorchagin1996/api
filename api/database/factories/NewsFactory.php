<?php

use Faker\Generator as Faker;

$factory->define(App\News::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence,
        'body' => $faker->sentence,
        'user_id' => function () {
            return factory(\App\User::class);
        }
    ];
});
