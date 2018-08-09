<?php

use Faker\Generator as Faker;

$factory->define(App\Producto::class, function (Faker $faker) {
    return [
        'nombre' => $faker->text(100),
        'descripcion' => $faker->paragraph,
        'valor' => $faker->randomDigit,
        'cantidad' => $faker->randomDigit,
    ];
});
