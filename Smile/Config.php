<?php
namespace Smile;

class Config implements \ArrayAccess
{
    protected $path = null;
    protected $config = [];

    public function __construct()
    {
        $config = require BASEDIR . '/config/application.config.php';
        if (count($config['config']) > 0) {
            foreach ($config['config'] as $val) {
                $item = require BASEDIR . '/config/autoload/' . $val . '.php';
                foreach ($item as $key=>$value) {
                    $config[$key] = $value;
                }
            }
        }
        $this->config = $config;
    }

    public function offsetExists($key)
    {
        return isset($this->config[$key]);
    }

    public function offsetGet($key)
    {
        if (empty($this->config[$key]))
        {
            $config = require BASEDIR . '/config/' . $key . '.php';;
            $this->config[$key] = $config;
        }
        return $this->config[$key];
    }

    public function offsetSet($key, $value)
    {
        throw new \Exception("请在配置文件中修改！");
    }

    public function offsetUnset($key)
    {
        unset($this->config[$key]);
    }
}