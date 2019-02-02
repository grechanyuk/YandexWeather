<?php
namespace Grechanyuk\YandexWeather\Utils;

class Utils {
    public static function getTariffUri() {
        switch (config('yandexweather.tariff')) {
            case 1:
                $uri = 'informers';
                break;
            case 2:
                $uri = 'forecast';
                break;
            default:
                $uri = 'informers';
        }

        return 'https://api.weather.yandex.ru/v1/' . $uri;
    }
}