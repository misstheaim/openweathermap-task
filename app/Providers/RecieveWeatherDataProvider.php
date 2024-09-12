<?php

namespace App\Providers;

use App\Contracts\WeatherDataReciever;
use App\Services\OWPReciever_v2Service;
use App\Services\OWPRecieverService;
use Illuminate\Support\ServiceProvider;

class RecieveWeatherDataProvider extends ServiceProvider
{
    public $bindings = [
        WeatherDataReciever::class => OWPReciever_v2Service::class
    ];


    public function providers() : array
    {
        return [
            WeatherDataReciever::class,
            OWPRecieverService::class,
            OWPReciever_v2Service::class
        ];
    }
}
