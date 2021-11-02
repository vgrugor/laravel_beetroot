<?php

namespace App\Http\Controllers;

use App\Console\Commands\WeatherFetcher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Exception;

class WeatherController extends Controller
{
    private const DEFAULT_PRECISION = 1;

    /**
     * @param string $city
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * @throws Exception
     */
    public function showWeatherInCity(string $city = 'Kyiv')
    {
        return view('cityWeather')->with($this->getWeather($city));
    }

    /**
     * @param string $city
     * @return array
     * @throws Exception
     */
    private function getWeather(string $city): array
    {
        $response = Http::get($this->getUrlApi($city));
        $weather = json_decode($response, true);
        $responseCod = $weather['cod'] ?? null;

        if ($responseCod === \Illuminate\Http\Response::HTTP_OK) {

            return $this->getDataToView($city, $weather);
        }
        throw new Exception('Error ' . $response['message']);
    }

    /**
     * @param string $city
     * @return string
     */
    private function getUrlApi(string $city): string
    {
        return sprintf("https://api.openweathermap.org/data/2.5/weather?q=%s&units=metric&APPID=%s",
            $city,
            config('app.openWeatherMapAppId')
        );
    }

    /**
     * @param string $city
     * @param array $weather
     * @return array
     */
    private function getDataToView(string $city, array $weather): array
    {
        return ['city' => $city,
            'temp' => (int) $weather['main']['temp'],
            'pressure' => $weather['main']['pressure'],
            'humidity' => $weather['main']['humidity'],
            'wind' => round($weather['wind']['speed'], self::DEFAULT_PRECISION),
        ];
    }

    /**
     * @param string $city
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * @throws Exception
     */
    public function selectCity(Request $request, string $city = '')
    {
        $city = $request->get('city');

        if ($city) {

            return view('select')->with($this->getWeather($city));
        }
        return view('select')->with(['city' => $city]);
    }
}
