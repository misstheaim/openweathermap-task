<?php

use App\Filament\Resources\CityResource;
use App\Filament\Resources\CityResource\Pages\ListCities;
use App\Filament\Resources\CityResource\Pages\CreateCity;
use App\Filament\Resources\CityResource\Pages\EditCity;
use App\Models\City;
use Filament\Actions\DeleteAction;

use function Pest\Livewire\livewire;


it('can render index page', function () {
    
    $this->get(CityResource::getUrl('index'))->assertSuccessful();
    
});

it ('can render edit page', function () {
    $this->get(CityResource::getUrl(('edit'), [
        'record' => City::factory()->create()
    ]))->assertSuccessful();
});


it('can list cities', function () {
    $cities = City::factory()->count(10)->create();
    livewire(ListCities::class)->assertCanSeeTableRecords($cities);
});

it ('can create data in database', function () {
    $newData = City::factory()->make();

    livewire(CreateCity::class)
        ->fillForm([
            'name' => $newData->name,
            'latitude' => $newData->latitude,
            'longitude' => $newData->longitude
        ])
        ->call('create')
        ->assertHasNoFormErrors();

    $this->assertDatabaseHas(City::class, [
            'name' => $newData->name,
            'latitude' => $newData->latitude,
            'longitude' => $newData->longitude
    ]);
});

it ('can validate input', function () {
    livewire(CreateCity::class)
        ->fillForm([
            'name' => null
        ])
        ->call('create')
        ->assertHasFormErrors();
});


it ('can retrive data', function () {
    $city = City::factory()->create();

    livewire(EditCity::class, [
        'record' => $city->getRouteKey()
    ])
    ->assertFormSet([
        'name' => $city->name,
        'latitude' => $city->latitude,
        'longitude' => $city->longitude
    ]);
});


it ('can delete', function () {
    $city = City::factory()->create();
    livewire(EditCity::class, [
        'record' => $city->getRouteKey()
    ])
    ->callAction(DeleteAction::class);

    $this->assertModelMissing($city);
});
