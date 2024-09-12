<?php

namespace App\Http\Controllers;

use App\Http\Requests\WeatherCityRequest;
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
        return new CityCollection(City::all());
    }

    public function getHistoricalInfo(WeatherCityRequest $req)
    {
        return new WeatherCollection(Weather::where('city', $req->route('city'))->orderBy('date_time')->get());
    }

    public function getLatestInfo(WeatherCityRequest $req) 
    {
        return new WeatherResource(Weather::where('city', $req->route('city'))->latest('date_time')->first());
    }

    public function getAllInfo() 
    {
        return new WeatherCollection(Weather::paginate(5));
    }
}