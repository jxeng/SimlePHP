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
        extract($this->data);
        include $path;
    }
}