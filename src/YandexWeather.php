<?php

namespace Grechanyuk\YandexWeather;

use Grechanyuk\YandexWeather\Exceptions\NotValidApiKey;
use Grechanyuk\YandexWeather\Exceptions\UnknownError;
use Grechanyuk\YandexWeather\Utils\Utils;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\Cache;

class YandexWeather
{
    private $client;

    public function __construct()
    {
        if (config('yandexweather.api_key', '') == '') {
            throw new NotValidApiKey();
        }

        $this->client = new Client([
            'base_uri' => Utils::getTariffUri(),
            'headers' => [
                'X-Yandex-API-Key' => config('yandexweather.api_key', '')
            ]
        ]);
    }

    public function getWeather(float $lat, float $lon, $lang = false, $limit = 7, $hours = true, $extra = true)
    {
        if(config('yandexweather.cacheTime') && Cache::has($this->getCacheName($lat, $lon, $lang, $limit, $hours, $extra))) {
            return Cache::get($this->getCacheName($lat, $lon, $lang, $limit, $hours, $extra));
        }

        switch (config('yandexweather.tariff')) {
            case 2:
                $query = [
                    'lat' => $lat,
                    'lon' => $lon,
                    'lang' => $lang ? $lang : config('yandexweather.responseLang'),
                    'limit' => 7,
                    'hours' => $hours,
                    'extra' => $extra
                ];
                break;
            default:
                $query = [
                    'lat' => $lat,
                    'lon' => $lon,
                    'lang' => $lang ? $lang : config('yandexweather.responseLang')
                ];
        }

        try {
            $response = $this->client->get(null, [
                'query' => $query
            ]);
        } catch (ClientException $e) {
            if($e->getCode() == 403) {
                throw new NotValidApiKey($e->getMessage(), $e->getCode());
            }

            throw new UnknownError($e->getMessage(), $e->getCode());
        }

        $response = json_decode($response->getBody()->getContents());

        if(config('yandexweather.cacheTime')) {
            Cache::put($this->getCacheName($lat, $lon, $lang, $limit, $hours, $extra), $response, config('yandexweather.cacheTime'));
        }

        return $response;
    }

    private function getCacheName(float $lat, float $lon, $lang, $limit, $hours, $extra) {
        return implode('.', [
            'yandexWeather',
            $lat,
            $lon,
            $lang,
            $limit,
            $hours,
            $extra
        ]);
    }
}