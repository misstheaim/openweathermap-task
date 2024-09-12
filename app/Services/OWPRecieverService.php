<?php

namespace App\Services;

use App\Contracts\WeatherDataReciever;
use App\Models\Weather;
use DateTime;
use DateTimeZone;
use Exception;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class OWPRecieverService implements WeatherDataReciever 
{

    protected $api_key;
    protected $units;

    public function __construct()
    {
        $this->api_key = env('OWP_API_KEY', 11);
        $this->units = env('OWP_UNITS', 11);
    }


    public function recieveData() : bool
    {

        $cities = $this->getCities();
        

        foreach ($cities as $city) {
            $city_name = $city->name;
            $info = $this->getRequest($city);

            $this->createData($city_name, $info);
            
            //dd($info);
        }

        dump('Data succefully recieved!');
        return true;
    }



    //=============Private functions=================

    private function createData($city_name, $info) 
    {
        $date_time = $this->getTime($info);

        try {

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

        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
    


    private function getCities() 
    {
        try {
            return DB::table('cities')->get();
        } catch (Exception $e) {
            dd($e->getMessage());
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
        try {
            $lat = $city->latitude;
            $lon = $city->longitude;

            $query = "https://api.openweathermap.org/data/2.5/weather?lat=$lat&lon=$lon&appid=$this->api_key&units=$this->units";

            $info = Http::get($query)->throw(function(Response $response, RequestException $e) {
                $message = "Status code: " . $response->status() . "\nMessage: " . $e->getMessage();
                dd($message);
            })->json();

            return $info;
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
}