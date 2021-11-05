<?php

namespace App\Services\Weather;

use Exception;
use Illuminate\Support\Facades\Http;
use JsonException;
use Symfony\Component\HttpFoundation\Response;

class WeatherClient
{
    /**
     * @param string $city
     * @return array
     * @throws JsonException
     * @throws Exception
     */
    public function getWeather(string $city): array
    {
        $urlAPI = sprintf("https://api.openweathermap.org/data/2.5/weather?q=%s&units=metric&APPID=%s",
            $city,
            config('app.openWeatherMapAppId')
        );

        $response = Http::get($urlAPI);

        if ($response->status() !== Response::HTTP_OK) {
            throw new Exception('Invalid response ' . $response->body());
        }

        return json_decode($response->body(), true, 512, JSON_THROW_ON_ERROR);
    }
}
