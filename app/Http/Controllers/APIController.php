<?php

namespace App\Http\Controllers;

use OpenApi\Annotations as OA;

define('API_HOST', config('app.host_name'));

/**
 * @OA\Info(
 *   title="API for getting weather data about cities around the world",
 *   version="0.1.0",
 *   @OA\Contact(
 *      name="Alex"
 *   )
 * )
 * 
 * @OA\Server(
 *    url=API_HOST,
 *    description="Local server for developing uses test data"
 * )
 * 
 * @OA\Components(
 *    @OA\Schema(
 *       schema="weather_data_json",
 *       type="object",
 *       @OA\Property(property="id", type="int"),
 *       @OA\Property(property="city", type="string"),
 *       @OA\Property(property="date_time", type="string"),
 *       @OA\Property(property="weather_name", type="string"),
 *       @OA\Property(property="latitude", type="float"),
 *       @OA\Property(property="longitude", type="float"),
 *       @OA\Property(property="temperature", type="float"),
 *       @OA\Property(property="min_temperature", type="float"),
 *       @OA\Property(property="max_temperature", type="float"),
 *       @OA\Property(property="pressure", type="float"),
 *       @OA\Property(property="humidity", type="float"),
 *    )
 * )
 */

use App\Http\Requests\WeatherCityRequest;
use App\Models\Weather;
use App\Models\City;
use App\Http\Resources\CityCollection;
use App\Http\Resources\WeatherCollection;
use App\Http\Resources\WeatherResource;

class APIController extends Controller
{
    /**
     * @OA\Get(
     *   path="/cities",
     *   summary="Return a list of all cities in database",
     *   @OA\Response(
     *     response=200,
     *     description="OK",
     *     @OA\JsonContent(
     *       type="array",
     *       @OA\Items(
     *         type="object",
     *         @OA\Property(property="city_name", type="string"),
     *         @OA\Property(property="latitude", type="float"),
     *         @OA\Property(property="longitude", type="float"),
     *       )
     *     )
     * ),
     *   @OA\Response(response=404, description="Not Found")
     * )
     */
    public function getCities() 
    {
        return new CityCollection(City::all());
    }

    /**
     * @OA\Get(
     *   path="/weather/{city}",
     *   summary="Return a list of all data by City parametr",
     *   @OA\Parameter(
     *       in="path",
     *       name="city",
     *       @OA\Schema(
     *          type="string"
     *       ),
     *       description="The city name"
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="OK",
     *     @OA\JsonContent(
     *       type="array",
     *       @OA\Items(
     *         ref="#/components/schemas/weather_data_json"
     *       )
     *       
     *     )
     *   ),
     *   @OA\Response(response=404, description="Not Found")
     * )
     */
    public function getHistoricalInfo(WeatherCityRequest $req)
    {
        return new WeatherCollection(Weather::where('city', $req->route('city'))->orderBy('date_time')->get());
    }

    /**
     * @OA\Get(
     *   path="/weather/{city}/latest",
     *   summary="Return latest weather record by City parametr ordered by date_time",
     *   @OA\Parameter(
     *       in="path",
     *       name="city",
     *       @OA\Schema(
     *          type="string"
     *       ),
     *       description="The city name"
     *   ),
     *   @OA\Response(
     *     response=200, 
     *     description="OK",
     *     @OA\JsonContent(ref="#/components/schemas/weather_data_json")
     *   ),
     *   @OA\Response(response=404, description="Not Found"),
     *   @OA\Response(response=422, description="Unprocessable Content")
     * )
     */
    public function getLatestInfo(WeatherCityRequest $req) 
    {
        return new WeatherResource(Weather::where('city', $req->route('city'))->latest('date_time')->first());
    }

    /**
     * @OA\Get(
     *   path="/weather",
     *   summary="Returns all data from database 5 records by page",
     *   @OA\Parameter(
     *     name="page",
     *     in="query",
     *     @OA\Schema(
     *       type="int"
     *     )
     *   ),
     *   @OA\Response(
     *     response=200, 
     *     description="OK",
     *     @OA\JsonContent(
     *       type="object",
     *       @OA\Property(
     *         property="data",
     *         type="array",
     *         @OA\Items(ref="#/components/schemas/weather_data_json")
     *       ),
     *       @OA\Property(
     *         property="links",
     *         type="object",
     *         @OA\Property(
     *           property="first",
     *           type="string",
     *           example="http://localhost/api/weather?page=1",
     *         ),
     *        ),
     *        @OA\Property(
     *           property="meta",
     *           type="object",
     *        )
     *       ),
     *     )
     *   ),
     *   @OA\Response(response=404, description="Not Found"),
     *   @OA\Response(response=422, description="Unprocessable Content")
     * )
     */
    public function getAllInfo() 
    {
        return new WeatherCollection(Weather::paginate(5));
    }
}