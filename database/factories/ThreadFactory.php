<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\User;
use App\Thread;
use Faker\Generator as Faker;

$factory->define(Thread::class, function (Faker $faker) {
    return [
        'user_id' => function () {
            return factory(User::class)->create()->id;
        },
        'title' => $faker->sentence,
        'body' => $faker->paragraph(2),
    ];
});
