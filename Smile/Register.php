<?php
namespace Smile;

class Register
{
    static public $objs = [];

    static public function set($key, $value)
    {
        self::$objs[$key] = $value;
    }

    static public function get($key)
    {
        return isset(self::$objs[$key]) ? self::$objs[$key] : false;
    }

    static public function _unset($key)
    {
        unset(self::$objs[$key]);
    }
}