<?php

namespace Database\Seeders;

use App\Models\Weather;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class WeatherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Weather::factory()
            ->count(10)
            ->state(new Sequence(
                ['city' => 'Tashkent'],
                ['city' => 'Khiva']
            ))
            ->create();
    }
}
