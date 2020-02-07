<?php


namespace App\formatters;


abstract class WeatherFormatter
{
    const DEFAULT_FORMAT = 'json';

    /**
     * @param string $format
     * @return WeatherFormatter
     */
    public static function getInstance(string $format)
    {
        $configPath = __DIR__ . '/../config.php';
        $config = include ($configPath);
        $configFormatters = $config['formatters'];
        $className = array_key_exists($format, $configFormatters) ? $configFormatters[$format] : $configFormatters[self::DEFAULT_FORMAT];
        return new $className;
    }

    /**
     * @param array $weather
     * @return string
     */
    public function format(array $weather) : string
    {
        $sortedWeather = $this->sort($weather);
        return $this->convertData($sortedWeather);
    }

    /**
     * @param array $data
     * @return array
     */
    private function sort(array $data) : array
    {
        return array_merge(array_fill_keys($this->getOrderSort(), ''), $data);
    }

    /**
     * @param array $data
     * @return string
     */
    public abstract function convertData(array $data) : string;

    /**
     * @return array
     */
    public abstract function getOrderSort() : array;

}
