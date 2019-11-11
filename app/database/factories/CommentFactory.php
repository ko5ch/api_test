<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Comment;
use Faker\Generator as Faker;
use App\Post;

$factory->define(Comment::class, function (Faker $faker) {
    return [
        'content' => $faker->text(),
        //for UnitTesting
        //'post_id'           => factory(Post::class)->create()->id,
        //'commentator_id'    => factory(Comment::class)->create()->id,
    ];
});
