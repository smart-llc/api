<?php

use Faker\Generator as Faker;

/**
 * @var Illuminate\Database\Eloquent\Factory $factory
 *
 * @author  Gleb Karpushkin  <rugleb@gmail.com>
 */
$factory->define(App\User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
    ];
});
