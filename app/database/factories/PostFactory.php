<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Post;
use Faker\Generator as Faker;
use App\User;
use App\Image;

$factory->define(Post::class, function (Faker $faker) {
    return [
        'content'       => $faker->text(),
        'deleted_at'    => null,
        'image_id'      => factory(Image::class)->create()->id,
        //for UnitTesting
        //'author_id' => factory(User::class)->create()->id,
    ];
});
