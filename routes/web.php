<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WeatherController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::view('/', 'home')->name('home');

Route::prefix('/weather')->group(function () {

    //Відповідь на 1 та 2 завдання, бо Київ за замовчуванням, а інше місто можна передати в get параметрі
    Route::get('/city/{city?}', [WeatherController::class, 'showWeatherInCity'])
        ->name('weatherCity');

    Route::get('/select/{city?}', [WeatherController::class, 'selectCity'])
        ->name('selectCity');
});
