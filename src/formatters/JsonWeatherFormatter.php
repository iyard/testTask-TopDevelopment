<?php


namespace App\formatters;


class JsonWeatherFormatter extends WeatherFormatter
{

    public function convertData(array $weather) : string
    {
        return json_encode($weather);
    }

    public function getOrderSort() : array
    {
        return [
            'obs_time',
            'temp',
            'wind_dir'
        ];
    }

}
