<?php

namespace App\Repositories;

use App\Models\CityWeather;

class CityWeatherRepository
{
    public function saveWeather(int $cityId, array $weather): void
    {
        $model = new CityWeather();

        $model->city_id = $cityId;
        $model->temperature = $weather['temperature'];
        $model->humidity = $weather['humidity'];
        $model->pressure = $weather['pressure'];
        $model->wind_speed = $weather['windSpeed'];

        $model->save();
    }
}
