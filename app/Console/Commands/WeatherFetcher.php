<?php

namespace App\Console\Commands;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class WeatherFetcher extends Command
{
    private const DEFAULT_PRECISION = 1;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'weather:fetch {cities*}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Call current weather data for one location';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @throws Exception
     */
    public function handle(): void
    {
        $this->table(
            ['city', 'temp' , 'pressure', 'humidity', 'wind'],
            $this->getDataFromTable(),
        );
    }

    /**
     * @return array
     * @throws Exception
     */
    private function getDataFromTable(): array
    {
        $cities = $this->argument('cities');

        $weatherData = [];

        foreach ($cities as $city) {
            $urlAPI = sprintf("https://api.openweathermap.org/data/2.5/weather?q=%s&units=metric&APPID=%s",
                $city,
                config('app.openWeatherMapAppId')
            );

            $response = Http::get($urlAPI);
            $weather = json_decode($response, true);

            $responseCod = $weather['cod'] ?? null;

            if ($responseCod === \Illuminate\Http\Response::HTTP_OK) {
                $weatherData[] = $this->formatWeatherFromCity($city, $weather);
                continue;
            }
            throw new Exception('Error ' . $response['message']);
        }
        return $weatherData;
    }

    /**
     * @param string $city
     * @param array $weather
     * @return array
     */
    private function formatWeatherFromCity(string $city, array $weather): array
    {
        return [
            'city' => $city,
            'temp' => (int) $weather['main']['temp'],
            'pressure' => $weather['main']['pressure'],
            'humidity'  => $weather['main']['humidity'],
            'wind'  => round($weather['wind']['speed'], self::DEFAULT_PRECISION),
        ];
    }
}
