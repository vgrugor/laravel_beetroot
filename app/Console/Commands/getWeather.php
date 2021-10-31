<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class getWeather extends Command
{
    /**
     * @var string API key for https://openweathermap.org/
     */
    private string $apiKey = '89e57043cce948394af7b45c8bd819ad';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'weather_in {--city=Kyiv}';

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
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        $city = $this->option('city');
        $urlAPI = "https://api.openweathermap.org/data/2.5/weather?q=$city&APPID=$this->apiKey";
        $weather = Http::get($urlAPI);

        $response = json_decode($weather, true);
        $responseCod = $response['cod'] ?? null;

        if ($responseCod === 200) {
            $this->newLine();
            $this->info($weather);
            $this->newLine();

            return Command::SUCCESS;
        }

        $errorMessage = $response['message'] ?? null;
        $this->newLine();
        $this->error('ERROR! ' . $errorMessage);
        $this->newLine();

        return Command::INVALID;
    }
}
