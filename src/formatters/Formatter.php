<?php


namespace App\formatters;


abstract class Formatter
{


    public static function getInstance($format)
    {
        return;
    }

    public abstract function format();

}
