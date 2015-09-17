<?php


class SermonPlugin_Controller_Base
{
    public static function getHeader($path = '_header')
    {
        return static::loadView($path);
    }

    public static function loadView($path, $params = array())
    {
        return SermonPlugin_Router::loadView($path, $params);
    }

}