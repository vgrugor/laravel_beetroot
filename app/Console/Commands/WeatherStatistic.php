<?php

namespace App\Console\Commands;

use App\Models\City;
use App\Models\CityWeather;
use App\Services\Weather\Formatter\ConsoleFormatter;
use App\Services\Weather\WeatherClient;
use Illuminate\Console\Command;
use JsonException;

class WeatherStatistic extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'weather:statistic';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Saves weather statistics for different cities to a database';

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
     * @throws JsonException
     */
    public function handle(): void
    {
        $this->table(
            ['city', 'temp' , 'pressure', 'humidity', 'wind_speed'],
            $this->getWeatherInCities(),
        );

    }

    /**
     * @return array
     * @throws JsonException
     */
    private function getWeatherInCities(): array
    {
        $weatherInCities = [];

        foreach (City::all() as $city) {
            $weather = (new WeatherClient())->getWeather($city->city);
            $weatherInCities[] = (new ConsoleFormatter($city->city, $weather))->toArray();
            $this->save($city->id, end($weatherInCities));
        }

        return $weatherInCities;
    }

    /**
     * @param int $cityId
     * @param array $weather
     */
    private function save(int $cityId, array $weather): void
    {
        $cityWeather = new CityWeather();

        $cityWeather->city_id = $cityId;
        $cityWeather->temperature = $weather['temperature'];
        $cityWeather->humidity = $weather['humidity'];
        $cityWeather->pressure = $weather['pressure'];
        $cityWeather->wind_speed = $weather['windSpeed'];

        $cityWeather->save();
    }
}
