<?php

use Faker\Generator as Faker;

/**
 * @var Illuminate\Database\Eloquent\Factory $factory
 *
 * @author  Gleb Karpushkin  <rugleb@gmail.com>
 */
$factory->define(App\Password::class, function (Faker $faker) {
    return [
        'email' => $faker->unique()->safeEmail,
    ];
});