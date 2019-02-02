<?php

namespace Grechanyuk\YandexWeather\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static getWeather(float $lat, float $lon, string|bool $lang = false, int $limit = 7, bool $hours = true, bool $extra = true)
 */
class YandexWeather extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'yandexweather';
    }
}
