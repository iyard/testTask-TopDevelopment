<?php


namespace App\formatters;


abstract class Formatter
{
    const DEFAULT_FORMAT = 'json';

    public static function getInstance(string $format)
    {
        $configPath = __DIR__ . '/../config.php';
        $config = include ($configPath);
        $configFormatters = $config['formatters'];
        $className = array_key_exists($format, $configFormatters) ? $configFormatters[$format] : $configFormatters[self::DEFAULT_FORMAT];
        return new $className;
    }

    public abstract function format(array $weather) : string;
}
