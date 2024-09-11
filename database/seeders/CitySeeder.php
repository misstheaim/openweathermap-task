<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cities = [
            ['name' => 'Tashkent', 'latitude' => 41.2995, 'longitude' => 69.2401],
            ['name' => 'Samarkand', 'latitude' => 39.6542, 'longitude' => 66.9597],
            ['name' => 'Bukhara', 'latitude' => 39.7745, 'longitude' => 64.4286],
            ['name' => 'Khiva', 'latitude' => 41.3786, 'longitude' => 60.3560],
            ['name' => 'Nukus', 'latitude' => 42.4611, 'longitude' => 59.6164],
            ['name' => 'Andijan', 'latitude' => 40.7821, 'longitude' => 72.3442],
            ['name' => 'Namangan', 'latitude' => 40.9983, 'longitude' => 71.6726],
            ['name' => 'Fergana', 'latitude' => 40.3864, 'longitude' => 71.7864],
            ['name' => 'Termiz', 'latitude' => 37.2241, 'longitude' => 67.2783],
            ['name' => 'Kokand', 'latitude' => 40.5306, 'longitude' => 70.9428],
            ['name' => 'Antananarivo', 'latitude' => -18.8791, 'longitude' => 47.5079],
            ['name' => 'Sydney', 'latitude' => -33.8688, 'longitude' => 151.2092],
            ['name' => 'London', 'latitude' => 51.5073, 'longitude' => -0.1277],
            ['name' => 'Dublin', 'latitude' => 53.3498, 'longitude' => -6.2603],
        ];

        
        DB::table('cities')->insert($cities);
    }
}
