<?php

namespace App\Console\Commands;

use App\Services\Weather\Formatter\DbFormatter;
use Illuminate\Console\Command;
use App\Models\City;
use App\Repositories\CityRepository;

class CityWeather extends Command
{
    private const TABLE_HEADER = [
        'city',
        'temp' ,
        'pressure',
        'humidity',
        'wind_speed',
        'created_at',
    ];

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'weather:city {city}';

    protected CityRepository $cityRepository;

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Retrieves the weather history for the city from the database';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(City $city, CityRepository $cityRepository)
    {
        parent::__construct();
        $this->cityRepository = $cityRepository;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $city = $this->argument('city');
        $cityModel = $this->cityRepository->getCityWeatherHistory($city);

        if ($cityModel === null) {
            dd("Weather for $city was not found");
        }

        $this->table(
            self::TABLE_HEADER,
            $this->getDataFromTable($city, $cityModel->weather->toArray()),
        );
    }

    private function getDataFromTable($city, $weatherHistory): array
    {
        $table = [];

        foreach ($weatherHistory as $weather) {
            $table[] = (new DbFormatter($city, $weather))->toArray();
        }

        return $table;
    }
}
