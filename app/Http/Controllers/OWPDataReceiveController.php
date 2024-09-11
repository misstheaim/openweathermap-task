<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use App\Models\Weather;
use Illuminate\Http\Client\Response;
use Illuminate\Http\Client\RequestException;
use DateTime;
use DateTimeZone;

class OWPDataReceiveController extends Controller
{
    protected $api_key = '20932e6f5c19394b6c8df0ae99682c0e';

    protected $units = 'metric';

    public function __invoke()
    {
        $cities = DB::table('cities')->get();

        foreach ($cities as $city) {
            $city_name = $city->name;
            $info = $this->getRequest($city);
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

            //dd($info);
        }
    }




    private function getTime($info)
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

        $query = "https://api.openweathermap.org/data/2.5/weather?lat=$lat&lon=$lon&appid=$this->api_key&units=$this->units";

        $info = Http::get($query)->throw(function(Response $response, RequestException $e) {
            $message = "Status code: " . $response->status() . "\nMessage: " . $e->getMessage();
            dd($message);
        })->json();

        return $info;
    }

    
}