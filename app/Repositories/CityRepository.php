<?php

namespace App\Repositories;

use App\Models\City;

class CityRepository
{
    public static function all()
    {
        return City::all();
    }

    public function getCityWeatherHistory(string $city): ?City
    {
        return City::with('weather')->where('city', $city)->first();
    }
}
