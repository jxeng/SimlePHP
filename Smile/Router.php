<?php
namespace Smile;

class Router
{
    static public function route($allow_modules)
    {
        $arr = Utility::parseURI();
        if (!in_array($arr['module_name'], $allow_modules)) {
            throw new \Exception("模块{$arr['module_name']}无法加载！");
        }
        include BASEDIR . '/'.$arr['module_name'].'/Controller/'.ucfirst($arr['controller_name']).'Controller.php';
        $controller = '\\'.$arr['module_name'].'\\Controller\\'.ucfirst($arr['controller_name']).'Controller';
        call_user_func_array([new $controller, $arr['action_name'].'Action'], []);
    }
}