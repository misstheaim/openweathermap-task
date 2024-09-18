<?php

namespace App\Contracts;

use App\Models\City;

interface WeatherDataReciever 
{
    public function recieveData(City $city);
}