<?php

namespace App\Services;

use App\Contracts\WeatherDataReciever;
use App\Models\City;
use App\Models\Weather;
use DateTime;
use DateTimeZone;
use Exception;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class OWPReciever_v2Service implements WeatherDataReciever 
{

    protected $api_key;
    protected $units;

    public function __construct()
    {
        $this->api_key = config('app.api_key');
        $this->units = config('app.units');
    }


    public function recieveData(City $city) : bool
    {
        $city_name = $city->name;
        $info = $this->getRequest($city);

        $this->createData($city_name, $info);

        return true;
    }



    //=============Private functions=================

    private function createData($city_name, $info) 
    {
        $date_time = $this->getTime($info);

        Weather::create([
            'city' => $city_name,
            'date_time' => $date_time,
            'weather_name' => $info['weather'][0]['main'],
            'latitude' => $info['coord']['lat'],
            'longitude' => $info['coord']['lon'],
            'temperature' => $info['main']['temp'],
            'min_temperature' => $info['main']['temp_min'],
            'max_temperature' => $info['main']['temp_max'],
            'pressure' => $info['main']['pressure'],
            'humidity' => $info['main']['humidity']
        ]);

    }


    private function getTime($info) : DateTime
    {
        $date_time = new DateTime();
        $date_time = $date_time->setTimestamp($info['dt']);
        $timezone = '+'.date('hi', mktime(0, 0, $info['timezone']));
        $date_timezone = new DateTimeZone($timezone);
        $date_time->setTimezone($date_timezone);
        return $date_time;
    }



    private function getRequest($city)
    {
        $lat = $city->latitude;
        $lon = $city->longitude;

        $query = "https://api.openweathermap.org/data/2.5/weather";

        $info = Http::get($query, [
            'lat' => $lat,
            'lon' => $lon,
            'appid' => $this->api_key,
            'units' => $this->units
        ])->throw()->json();

        return $info;
    }
}