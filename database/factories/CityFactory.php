<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\City>
 */
class CityFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => Str::random(10),
            'latitude' => rand(-4000, 4000)/100,
            'longitude' => rand(-4000, 4000)/100
        ];
    }
}
