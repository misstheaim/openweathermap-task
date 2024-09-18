<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Weather>
 */
class WeatherFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'date_time' => now(),
            'weather_name' => Str::random(10),
            'latitude' => rand(),
            'longitude' =>rand(),
            'temperature' =>rand(),
            'min_temperature' =>rand(),
            'max_temperature' =>rand(),
            'pressure' =>rand(),
            'humidity' =>rand(),
        ];
    }
}
