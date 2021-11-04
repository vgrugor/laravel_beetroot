<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CitySeeder extends Seeder
{
    /**
     * @var array|string[]
     */
    private array $cities = ['Poltava', 'Kyiv', 'Myrhorod', 'Sumy', 'Odesa'];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        foreach ($this->cities as $cityTitle) {
            $city = new City();
            $city->city = $cityTitle;
            $city->save();
        }
    }
}
