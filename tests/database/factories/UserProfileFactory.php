<?php

use KitLoong\PowerJoins\Tests\Models\User;
use KitLoong\PowerJoins\Tests\Models\UserProfile;

$factory->define(UserProfile::class, function (Faker\Generator $faker) {
    return [
        'user_id' => factory(User::class),
        'city' => $faker->city,
    ];
});
