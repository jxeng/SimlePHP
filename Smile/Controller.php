<?php
namespace Smile;

abstract class Controller
{
    protected $data;
    protected $controller_name;
    protected $action_name;
    protected $template_dir;

    function __construct()
    {
        $arr = Utility::parseURI();
        $this->controller_name = $arr['controller_name'];
        $this->action_name = $arr['action_name'];
        $this->template_dir = BASEDIR . '/' . $arr['module_name'] . '/View';
    }

    function assign($key, $value)
    {
        $this->data[$key] = $value;
    }

    function display($file = '')
    {
        if (empty($file))
        {
            $file = strtolower($this->controller_name).'/'.$this->action_name;
        }
        $path = $this->template_dir.'/'.$file.'.php';
        if ($this->data) {
            extract($this->data);
        }
        if (!file_exists($path)) {
            if (Register::get('debug')) die("模板文件{$path}不存在！");
            Router::notFound();
        }
        include_once $path;
    }

    /**
     * 跳转
     * /module[/controller[/action]]
     * action
     * controller/action
     * module/controller/action
     * @param $url
     */
    function toUrl($url)
    {
        $url = trim($url);
        if (substr($url, 0, 1) == '/') {
            $url = trim($url, '/');
            $arr = explode('/', $url);
            $arr[] = '';
            $arr[] = '';
            list($module, $controller, $action) = $arr;
            $controller = $controller ? : 'index';
            $action = $action ? : 'index';
        } else {
            $url = trim($url, '/');
            $arr = array_reverse(explode('/', $url));
            $arr[] = '';
            $arr[] = '';
            list($action, $controller, $module) = $arr;

            $called_class = get_called_class();
            list($module_defaut,,$controller_default) = explode('\\', $called_class);
            $controller = $controller ? : substr($controller_default, 0, -10);
            $module = $module ? : $module_defaut;
        }
        list($module, $controller, $action) = array_map('strtolower',[$module, $controller, $action]);
        header("Location:/{$module}/{$controller}/{$action}");
    }

    function jsonRespon($code = 200, $data = [], $msg = 'ok')
    {
        $arr = compact('code', 'data', 'msg');
        return json_encode($arr);
    }
}