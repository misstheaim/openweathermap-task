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

    protected $seeder = WeatherSeeder::class;

    public function test_recieve_cities_test() 
    {
        $this->seed(CitySeeder::class);

        $response = $this->get('/api/cities');

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
        $this->seed(CitySeeder::class);
        $city = City::first()->toArray()['name'];
        $url = '/api/weather/' . $city;
        $response = $this->get($url);

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

    // public function test_recieve_city_weather_bad_request_test()
    // {
    //     Exceptions::fake();
    //     $this->seed(CitySeeder::class);

    //     $response = $this->get('/api/weather/NotExistingCity');
    //     Exceptions::assertReported(ValidationException::class);

    //     $response->assertStatus(302);
    //     $response->assertJson(function (AssertableJson $json) {
    //         $json->has('message');
    //     });
    // }

    public function test_recieve_city_latest_weather_test()
    {
        $this->seed(CitySeeder::class);
        $city = City::first()->toArray()['name'];
        $url = '/api/weather/' . $city . '/latest';
        $response = $this->get($url);

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

        // $response->assertJsonPath('data.0.date_time', fn (DateTimeZone $date) =>
        //     $date == Weather::select('date_time')->latest()
        // );
    }

    // public function test_recieve_city_latest_weather_bad_request_test()
    // {
    //     $this->seed(CitySeeder::class);
    //     $response = $this->withoutExceptionHandling()->get('/api/weather/NotExistingCity/latest');
    //     $response->assertStatus(302);
    //     $response->assertJson(function (AssertableJson $json) {
    //         dump($json);
    //         $json->has('message');
    //     });
    // }

    public function test_recieve_all_weather_data_test()
    {
        $response = $this->get('/api/weather/');

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
