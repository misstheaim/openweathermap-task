<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WeatherResource\Pages;
use App\Filament\Resources\WeatherResource\RelationManagers;
use App\Models\City;
use App\Models\Weather;
use Filament\Forms;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Livewire;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class WeatherResource extends Resource
{
    protected static ?string $model = Weather::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('city')
                    ->relationship('city', 'name')
                    ->live()
                    ->afterStateUpdated(function( Set $set, Get $get, ?string $state) {
                        $set('latitude', City::select('latitude')->where('name', $state)->get()->toArray()[0]['latitude']);
                        $set('longitude', City::select('longitude')->where('name', $state)->get()->toArray()[0]['longitude']);
                    })
                    //->searchable()
                    ->required(),
                DatePicker::make('date_time')
                    ->required()
                    ->maxDate(now()),
                TextInput::make('weather_name')
                    ->required(),
                TextInput::make('latitude')
                    ->numeric()
                    ->readOnly(),
                TextInput::make('longitude')
                    ->numeric()
                    ->readOnly(),
                TextInput::make('temperature')
                    ->numeric(),
                TextInput::make('min_temperature')
                    ->numeric(),
                TextInput::make('max_temperature')
                    ->numeric(),
                TextInput::make('pressure')
                    ->numeric(),
                TextInput::make('humidity')
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('city')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('date_time'),
                TextColumn::make('weather_name'),
                TextColumn::make('latitude'),
                TextColumn::make('longitude'),
                TextColumn::make('temperature')
                    ->sortable(),
                TextColumn::make('min_temperature')
                    ->label('Min Temp'),
                TextColumn::make('max_temperature')
                    ->label('Max Temp'),
                TextColumn::make('pressure')
                    ->sortable(),
                TextColumn::make('humidity')
                    ->sortable(),
            ])
            ->defaultSort('city', 'asc')
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListWeather::route('/'),
            'create' => Pages\CreateWeather::route('/create'),
            'edit' => Pages\EditWeather::route('/{record}/edit'),
        ];
    }
}
