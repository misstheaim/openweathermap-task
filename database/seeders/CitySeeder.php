<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\City;


class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $created_at = $updated_at = now();
        $cities = [
            ['name' => 'Tashkent', 'latitude' => 41.2995, 'longitude' => 69.2401, 'created_at' => $created_at, 'updated_at' => $updated_at],
            ['name' => 'Samarkand', 'latitude' => 39.6542, 'longitude' => 66.9597, 'created_at' => $created_at, 'updated_at' => $updated_at],
            ['name' => 'Bukhara', 'latitude' => 39.7745, 'longitude' => 64.4286, 'created_at' => $created_at, 'updated_at' => $updated_at],
            ['name' => 'Khiva', 'latitude' => 41.3786, 'longitude' => 60.3560, 'created_at' => $created_at, 'updated_at' => $updated_at],
            ['name' => 'Nukus', 'latitude' => 42.4611, 'longitude' => 59.6164, 'created_at' => $created_at, 'updated_at' => $updated_at],
            ['name' => 'Andijan', 'latitude' => 40.7821, 'longitude' => 72.3442, 'created_at' => $created_at, 'updated_at' => $updated_at],
            ['name' => 'Namangan', 'latitude' => 40.9983, 'longitude' => 71.6726, 'created_at' => $created_at, 'updated_at' => $updated_at],
            ['name' => 'Fergana', 'latitude' => 40.3864, 'longitude' => 71.7864, 'created_at' => $created_at, 'updated_at' => $updated_at],
            ['name' => 'Termiz', 'latitude' => 37.2241, 'longitude' => 67.2783, 'created_at' => $created_at, 'updated_at' => $updated_at],
            ['name' => 'Kokand', 'latitude' => 40.5306, 'longitude' => 70.9428, 'created_at' => $created_at, 'updated_at' => $updated_at],
            ['name' => 'Antananarivo', 'latitude' => -18.8791, 'longitude' => 47.5079, 'created_at' => $created_at, 'updated_at' => $updated_at],
            ['name' => 'Sydney', 'latitude' => -33.8688, 'longitude' => 151.2092, 'created_at' => $created_at, 'updated_at' => $updated_at],
            ['name' => 'London', 'latitude' => 51.5073, 'longitude' => -0.1277, 'created_at' => $created_at, 'updated_at' => $updated_at],
            ['name' => 'Dublin', 'latitude' => 53.3498, 'longitude' => -6.2603, 'created_at' => $created_at, 'updated_at' => $updated_at],
        ];

        
        City::insert($cities);
    }
}
