<?php

namespace App\Console\Commands;

use App\Contracts\WeatherDataReciever;
use Illuminate\Console\Command;

class RecieveWeather extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:recieve-weather';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Recieve weather data from 3-party application via API key';

    /**
     * Execute the console command.
     */
    public function handle(WeatherDataReciever $dataReciever)
    {
        $dataReciever->recieveData();
    }
}
