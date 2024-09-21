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
            'date_time' => date('Y-m-d H:i:s', rand(1205467224, 1255467224)),
            'weather_name' => Str::random(10),
            'latitude' => rand(-4000, 4000)/100,
            'longitude' =>rand(-4000, 4000)/100,
            'temperature' =>rand(-4000, 4000)/100,
            'min_temperature' =>rand(-4000, 4000)/100,
            'max_temperature' =>rand(-4000, 4000)/100,
            'pressure' =>rand(-4000, 4000)/100,
            'humidity' =>rand(-4000, 4000)/100,
        ];
    }
}
