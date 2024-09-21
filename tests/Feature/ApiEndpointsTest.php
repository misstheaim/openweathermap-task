<?php

namespace Tests\Feature;

use App\Models\City;
use App\Models\Weather;
use Database\Seeders\CitySeeder;
use Database\Seeders\WeatherSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class ApiEndpointsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed( CitySeeder::class );
        $this->seed( WeatherSeeder::class );
    }

    public function test_recieve_cities_test() 
    {
        $response = $this->getJson('/api/cities');

        $response->assertStatus(200);
        $response->assertJson(function (AssertableJson $json) {
            $json->has('data.0', fn (AssertableJson $json) => 
                $json->has('city_name')
                ->has('latitude')
                ->has('longitude')
            );
        });
    }

    public function test_recieve_city_weather_test()
    {
        $city = City::first()->toArray()['name'];
        $url = '/api/weather/' . $city;
        $response = $this->getJson($url);

        $response->assertStatus(200);
        $response->assertJson(function (AssertableJson $json) {
            $json->has('data.0', fn (AssertableJson $json) => 
                $json->has('city')
                ->has('latitude')
                ->has('longitude')
                ->has('date_time')
                ->etc()
            );
        });
    }

    public function test_recieve_city_weather_bad_request_test()
    {
        $response = $this->getJson('/api/weather/NotExistingCity');
        $response->assertStatus(422);
    }

    public function test_recieve_city_latest_weather_test()
    {
        $city = City::first()->toArray()['name'];
        $url = '/api/weather/' . $city . '/latest';
        $response = $this->getJson($url);

        $response->assertStatus(200);
        $response->assertJson(function (AssertableJson $json) {
            $json->has(1)->first(fn (AssertableJson $json) => 
                $json->has('city')
                ->has('latitude')
                ->has('longitude')
                ->has('date_time')
                ->etc()
            );
        });

        $response->assertJsonPath('data.date_time', function (string $date) use ($city) {
            $date_time = Weather::where('city', $city)->latest('date_time')->first()->toArray();
            return $date == $date_time['date_time'];
        });

        
    }

    public function test_recieve_city_latest_weather_bad_request_test()
    {
        $response = $this->getJson('/api/weather/NotExistingCity/latest');
        $response->assertStatus(422);
    }

    public function test_recieve_all_weather_data_test()
    {
        $response = $this->getJson('/api/weather/');

        $response->assertStatus(200);
        $response->assertJson(function (AssertableJson $json) {
            $json->has('data.0', fn (AssertableJson $json) => 
                $json->has('city')
                ->has('latitude')
                ->has('longitude')
                ->has('date_time')
                ->etc()
            )
            ->has('links')
            ->has('meta');
        });
    }
}
