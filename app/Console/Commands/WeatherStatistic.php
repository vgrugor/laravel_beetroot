<?php

namespace App\Console\Commands;

use App\Models\City;
use App\Models\CityWeather;
use App\Repositories\CityWeatherRepository;
use App\Services\Weather\Formatter\ConsoleFormatter;
use App\Services\Weather\WeatherClient;
use Illuminate\Console\Command;
use JsonException;

class WeatherStatistic extends Command
{
    /**
     * Console table headers
     */
    private const TABLE_HEADER = [
        'city',
        'temp' ,
        'pressure',
        'humidity',
        'wind_speed',
    ];

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
     * @var CityWeatherRepository
     */
    protected CityWeatherRepository $cityWeatherRepository;

    /**
     * @var WeatherClient
     */
    protected WeatherClient $weatherClient;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(CityWeatherRepository $cityWeatherRepository, WeatherClient $weatherClient)
    {
        parent::__construct();
        $this->cityWeatherRepository = $cityWeatherRepository;
        $this->weatherClient = $weatherClient;
    }

    /**
     * @throws JsonException
     */
    public function handle(): void
    {
        $this->table(
            self::TABLE_HEADER,
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
            $weather = $this->weatherClient->getWeather($city->city);
            $weatherInCities[] = (new ConsoleFormatter($city->city, $weather))->toArray();
            $this->cityWeatherRepository->saveWeather($city->id, end($weatherInCities));
        }

        return $weatherInCities;
    }
}
