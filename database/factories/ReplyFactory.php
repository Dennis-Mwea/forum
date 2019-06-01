<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\User;
use App\Reply;
use App\Thread;
use Faker\Generator as Faker;

$factory->define(Reply::class, function (Faker $faker) {
    return [
        'user_id' => function () {
            return factory(User::class)->create()->id;
        },
        'thread_id' => function () {
            return factory(Thread::class)->create()->id;
        },
        'body' => $faker->sentence(5),
    ];
});
