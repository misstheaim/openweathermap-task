<?php

namespace Tests\Feature;

use App\Models\City;
use Database\Seeders\CitySeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class OWPRecieverServiceReatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_http_client_must_run_correctly_with_valid_data(): void
    {
        $this->seed(CitySeeder::class);
        Http::preventStrayRequests();

        Http::fake([
            'https://api.openweathermap.org/*' => Http::response($this->jsonResp, 200)
        ]);

        $this->artisan('app:recieve-weather')->assertSuccessful();

        Http::assertSent(function (Request $request){
            return ( is_float($request['lat']) || is_int($request['lat']) ) &&
            ( is_float($request['lon']) || is_int($request['lat']) ) && 
            !empty($request['appid']);
        });

        Http::assertSentCount(City::all()->count());
    }


    protected $jsonResp = <<< JSON_RESP
{
    "coord": {
        "lon": 7.367,
        "lat": 45.133
    },
    "weather": [
        {
            "id": 501,
            "main": "Rain",
            "description": "moderate rain",
            "icon": "10d"
        }
    ],
    "base": "stations",
    "main": {
        "temp": 284.2,
        "feels_like": 282.93,
        "temp_min": 283.06,
        "temp_max": 286.82,
        "pressure": 1021,
        "humidity": 60,
        "sea_level": 1021,
        "grnd_level": 910
    },
    "visibility": 10000,
    "wind": {
        "speed": 4.09,
        "deg": 121,
        "gust": 3.47
    },
    "rain": {
        "1h": 2.73
    },
    "clouds": {
        "all": 83
    },
    "dt": 1726660758,
    "sys": {
        "type": 1,
        "id": 6736,
        "country": "IT",
        "sunrise": 1726636384,
        "sunset": 1726680975
    },
    "timezone": 7200,
    "id": 3165523,
    "name": "Province of Turin",
    "cod": 200
    }  
JSON_RESP;
}
