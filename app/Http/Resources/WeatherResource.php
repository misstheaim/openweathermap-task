<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WeatherResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'city' => $this->city,
            'date_time' => $this->date_time,
            'weather_name' => $this->weather_name,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'temperature' => $this->temperature,
            'min_temperature' => $this->min_temperature,
            'max_temperature' => $this->max_temperature,
            'pressure' => $this->pressure,
            'humidity' => $this->humidity,
        ];
    }
}