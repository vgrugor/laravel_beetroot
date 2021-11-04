<?php

namespace App\Services\Weather\Formatter;

use Illuminate\Contracts\Support\Arrayable;

class ConsoleFormatter implements Arrayable
{
    private const DEFAULT_ROUND = 1;
    private string $city;
    private string $temperature;
    private string $humidity;
    private string $pressure;
    private string $windSpeed;

    public function __construct(string $city, array $weather)
    {
        $this->city = $city;
        $this->temperature = $weather['main']['temp'];
        $this->humidity = $weather['main']['humidity'];
        $this->pressure = $weather['main']['pressure'];
        $this->windSpeed = $weather['wind']['speed'];
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'city' => $this->city,
            'temperature' => (int) $this->temperature,
            'humidity' => (int) $this->humidity,
            'pressure' => (int) $this->pressure,
            'windSpeed' => round($this->windSpeed,  self::DEFAULT_ROUND),
        ];
    }
}
