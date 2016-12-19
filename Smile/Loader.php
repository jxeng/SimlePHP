<?php
namespace Smile;

class Loader
{
    static public function autoload($class_name)
    {
        require_once BASEDIR . '/' . str_replace('\\', '/', $class_name) . '.php';
    }
}