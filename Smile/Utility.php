<?php
namespace Smile;

class Utility
{
    static public function parseURI()
    {
        $request_uri = $_SERVER['REQUEST_URI'];
        $arr = explode('/', $request_uri);
        $controller_name = isset($arr[2]) && $arr[2] ? self::getUCwords($arr[2]) : 'Index';
        $action_name = isset($arr[3]) && $arr[3] ? (strtolower(explode('?', $arr[3])[0])) : 'index';
        $module_name = $arr[1] ? self::getUCwords($arr[1]) : 'Application';
        return compact('controller_name', 'action_name', 'module_name');
    }

    static public function getUCwords($str)
    {
        return ucwords(strtolower($str));
    }
}