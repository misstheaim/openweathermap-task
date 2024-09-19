<?php

namespace Tests\Feature;

use App\Models\City;
use App\Models\Weather;
use Database\Seeders\CitySeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OWPRecieverServiceReatureTest extends TestCase
{
    use RefreshDatabase;

    public function tes_recieve_data(): void
    {
        $this->seed(CitySeeder::class);
        $this->artisan('app:recieve-weather')->assertSuccessful(); // Issue is it okey to use real API request during testing
    }
}
