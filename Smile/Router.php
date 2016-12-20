<?php
namespace Smile;

class Router
{
    static protected $router = null;

    private function __construct()
    {

    }

    static public function getInstance()
    {
        if (!self::$router) {
            self::$router = new self();
        }
        return self::$router;
    }

    public function route()
    {
        $arr = Utility::parseURI();
        $this->dispatch($arr['module_name'], $arr['controller_name'], $arr['action_name']);
    }

    public function dispatch($module, $controller, $action)
    {
        $this->checkModule($module);
        $path = BASEDIR . '/'.$module.'/Controller/'.ucfirst($controller).'Controller.php';
        if (!file_exists($path)) {
            if (Register::get('debug')) die("控制器{$controller}不存在！");
            self::notFound();
        }
        include_once BASEDIR . '/'.$module.'/Controller/'.ucfirst($controller).'Controller.php';
        $controller = '\\'.$module.'\\Controller\\'.ucfirst($controller).'Controller';
        if (!is_callable([new $controller, $action.'Action'])) {
            if (Register::get('debug')) die("{$action}Action不存在！");
            self::notFound();
        }
        call_user_func_array([new $controller, $action.'Action'], []);
    }

    private function checkModule($module)
    {
        if (!in_array($module, Register::get('config')['modules'])) {
            if (Register::get('debug')) die("模块{$module}无法加载！");
            self::notFound();
        }
    }

    static public function notFound()
    {
        header('Location:/404.html');
    }
}