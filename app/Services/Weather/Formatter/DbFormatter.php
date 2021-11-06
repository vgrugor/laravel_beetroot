<?php

namespace App\Services\Weather\Formatter;

use Illuminate\Contracts\Support\Arrayable;

class DbFormatter implements Arrayable
{
    private const DEFAULT_ROUND = 1;
    private string $city;
    private string $temperature;
    private string $humidity;
    private string $pressure;
    private string $windSpeed;
    private string $createdAt;

    public function __construct(string $city, array $weather)
    {
        $this->city = $city;
        $this->temperature = $weather['temperature'];
        $this->humidity = $weather['humidity'];
        $this->pressure = $weather['pressure'];
        $this->windSpeed = $weather['wind_speed'];
        $this->createdAt = $weather['created_at'];
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
            'createdAt' => $this->createdAt,
        ];
    }
}
