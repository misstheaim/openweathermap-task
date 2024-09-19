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
            'latitude' => rand()/100000000,
            'longitude' =>rand()/100000000,
            'temperature' =>rand()/100000000,
            'min_temperature' =>rand()/100000000,
            'max_temperature' =>rand()/100000000,
            'pressure' =>rand()/100000000,
            'humidity' =>rand()/100000000,
        ];
    }
}
