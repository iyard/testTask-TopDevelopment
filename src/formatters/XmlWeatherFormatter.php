<?php


namespace App\formatters;


use Spatie\ArrayToXml\ArrayToXml;

class XmlWeatherFormatter extends WeatherFormatter
{
    public function convertData(array $weather) : string
    {
        return ArrayToXml::convert($weather);
    }

    public function getOrderSort() : array
    {
        return [
            'obs_time',
            'wind_speed',
            'temp'
        ];
    }

}
