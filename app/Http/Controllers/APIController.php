<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Weather;
use App\Models\City;
use App\Http\Resources\CityCollection;
use App\Http\Resources\WeatherCollection;
use App\Http\Resources\WeatherResource;

class APIController extends Controller
{
    public function getCities() 
    {
        $cities = new CityCollection(City::all());
        return $cities;
    }

    public function getHistoricalInfo(string $city_name) 
    {
        $validate = Weather::where('city', $city_name)->exists();
        if ($validate) {
            $data = new WeatherCollection(Weather::where('city', $city_name)->orderBy('date_time')->get());
        } else {
            $data = "<div>The city doesn't exist</div>\nPlease check if you write the name correctly or try another!"; //Later there could be some kind of JSON response with status code 404
        }
        
        return $data;
    }

    public function getLatestInfo(string $city_name) 
    {
        $validate = Weather::where('city', $city_name)->exists();
        if ($validate) {
            $data = new WeatherResource(Weather::where('city', $city_name)->latest('date_time')->first());
        } else {
            $data = "<div>The city doesn't exist</div>\nPlease check if you write the name correctly or try another!";
        }
        
        return $data;
    }

    public function getAllInfo() 
    {
        $data = new WeatherCollection(Weather::paginate(5));

        return $data;
    }
}