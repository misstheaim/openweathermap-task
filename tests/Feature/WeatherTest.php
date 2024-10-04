<?php

use App\Filament\Resources\WeatherResource;
use App\Filament\Resources\WeatherResource\Pages\CreateWeather;
use App\Filament\Resources\WeatherResource\Pages\EditWeather;
use App\Filament\Resources\WeatherResource\Pages\ListWeather;
use App\Models\City;
use App\Models\Weather;
use Filament\Actions\DeleteAction;
use Illuminate\Database\Eloquent\Factories\Sequence;

use function Pest\Livewire\livewire;


it('can render index page', function () {
    
    $this->get(WeatherResource::getUrl('index'))->assertSuccessful();
    
});


it('can list weather data', function () {
    $weather = Weather::factory()->count(10)
        ->state(new Sequence(
            ['city' => 'Tashkent'],
            ['city' => 'Khiva']
        ))->create();
    livewire(ListWeather::class)->assertCanSeeTableRecords($weather);
});


it ('can create weather data in database', function () {
    $city = City::factory()->create();
    $weather = Weather::factory()
        ->state(new Sequence(
            ['city' => $city->name]
        ))->create();

    livewire(CreateWeather::class)
        ->fillForm([
            'city' => $weather->city,
            'date_time' => $weather->date_time,
            'weather_name' => $weather->weather_name,
            'temperature' => $weather->temperature,
            'min_temperature' => $weather->min_temperature,
            'max_temperature' => $weather->max_temperature,
            'pressure' => $weather->pressure,
            'humidity' => $weather->humidity
        ])
        ->call('create')
        ->assertHasNoFormErrors();

    $this->assertDatabaseHas(Weather::class, [
        'city' => $weather->city,
        'latitude' => $weather->latitude,
        'longitude' => $weather->longitude,
        'date_time' => $weather->date_time,
        'weather_name' => $weather->weather_name,
        'temperature' => $weather->temperature,
        'min_temperature' => $weather->min_temperature,
        'max_temperature' => $weather->max_temperature,
        'pressure' => $weather->pressure,
        'humidity' => $weather->humidity
    ]);
});

it ('can validate input', function () {
    $city = City::factory()->create();
    livewire(CreateWeather::class)
        ->fillForm([
            'weather_name' => null
        ])
        ->call('create')
        ->assertHasFormErrors();
});

it ('can retrive data', function () {
    $weather = Weather::factory()
        ->state(new Sequence(
            ['city' => 'Tashkent']
        ))->create();

    livewire(EditWeather::class, [
        'record' => $weather->getRouteKey()
    ])
    ->assertFormSet([
        'city' => $weather->city,
        'latitude' => $weather->latitude,
        'longitude' => $weather->longitude,
        'date_time' => $weather->date_time,
        'weather_name' => $weather->weather_name,
        'temperature' => $weather->temperature,
        'min_temperature' => $weather->min_temperature,
        'max_temperature' => $weather->max_temperature,
        'pressure' => $weather->pressure,
        'humidity' => $weather->humidity
    ]);
});


it ('can delete', function () {
    $weather = Weather::factory()
        ->state(new Sequence(
            ['city' => 'Tashkent'],
            ['city' => 'Khiva']
        ))->create();
    livewire(EditWeather::class, [
        'record' => $weather->getRouteKey()
    ])
    ->callAction(DeleteAction::class);

    $this->assertModelMissing($weather);
});


// it ('', function () {
    
// });
