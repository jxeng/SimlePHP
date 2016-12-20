<?php
namespace Smile;

class Utility
{
    static public function parseURI()
    {
        $request_uri = trim($_SERVER['REQUEST_URI'], '/');
        $arr = explode('/', $request_uri);
        $arr[] = '';
        $arr[] = '';
        list($module_name, $controller_name, $action_name) = $arr;
        $controller_name = $controller_name ? self::getUCwords($controller_name) : 'Index';
        $action_name = $action_name ? (strtolower(explode('?', $action_name)[0])) : 'index';
        $module_name = $module_name ? self::getUCwords($module_name) : 'Application';
        return compact('controller_name', 'action_name', 'module_name');
    }

    static public function getUCwords($str)
    {
        return ucwords(strtolower($str));
    }
}