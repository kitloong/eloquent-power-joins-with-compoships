<?php

use KitLoong\PowerJoins\Tests\Models\Category;
use KitLoong\PowerJoins\Tests\Models\Post;
use KitLoong\PowerJoins\Tests\Models\User;

$factory->define(Post::class, function (Faker\Generator $faker) {
    return [
        'user_id' => factory(User::class),
        'category_id' => factory(Category::class),
        'title' => $faker->words(3, true),
    ];
});

$factory->state(Post::class, 'published', ['published' => true]);
$factory->state(Post::class, 'unpublished', ['published' => false]);
