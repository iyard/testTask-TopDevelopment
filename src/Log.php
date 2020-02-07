<?php


namespace App;


abstract class Log
{
    const LOGS_DIR = 'logs';
    const LOG_FILE_NAME = 'weather.txt';

    /**
     * @param $data string
     */
    public static function save($data)
    {
        file_put_contents(self::getFileName(), $data, FILE_APPEND);
    }

    /**
     * @return string
     */
    private static function getFileName() : string
    {
        return self::getPath() . '/' . self::LOG_FILE_NAME;
    }

    /**
     * @return string
     */
    private static function getPath() : string
    {
        return __DIR__ . '/../' . self::LOGS_DIR;
    }

}
