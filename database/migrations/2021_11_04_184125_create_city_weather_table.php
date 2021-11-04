<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCityWeatherTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('city_weather', function (Blueprint $table) {
            $table->id();
            $table->foreignId('city_id')->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->tinyInteger('temperature');
            $table->unsignedTinyInteger('humidity');
            $table->unsignedSmallInteger('pressure');
            $table->unsignedFloat('wind_speed', 3, 1);
            $table->timestamp('created_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('city_weather');
    }
}
