<?php
namespace Smile;

use Smile\Database\MySQLi;
use Smile\Database\PDO;
use Smile\Database\Proxy;

class Factory
{
    static public $proxy = null;

    static public function getDb($mode = 'master')
    {
        if ($mode == 'proxy') {
            if (!self::$proxy) {
                self::$proxy = new Proxy();
            }
            return self::$proxy;
        }
        $config = Register::get('config')['db'];

        if ($mode == 'master') {
            $db_config = $config['master'];
        }
        if ($mode == 'slave') {
            $slaves = $config['slave'];
            $db_config = $slaves[array_rand($slaves)];
        }

        $key = 'db_' . $mode;
        $db = Register::get($key);

        if (!$db) {
            $type = strtolower($config['type']);
            $db = $type == 'pdo' ? new PDO() : new MySQLi();
            $db->connect($db_config['host'], $db_config['dbname'], $db_config['user'], $db_config['password']);
            Register::set($key, $db);
        }
        return $db;
    }

    static public function getModel($namespace, $name, $mode = 'master')
    {
        $arr = explode('\\', $namespace);
        $key = 'model_' . str_replace('\\', '_', $namespace) . '_' . $name;
        $model = Register::get($key);
        if (!$model) {
            $model_class = '\\'.$arr[0] . '\\Model\\' . Utility::getUCwords($name) . 'Model';
            $model = new $model_class($mode);
            Register::set($key, $model);
        }
        return $model;
    }

    static public function getConfig()
    {
        $config = Register::get('config');
        if (!$config) {
            $config = Config::getInstance();
            Register::set('config', $config);
        }
        return $config;
    }

    static public function getRouter()
    {
        $router = Register::get('router');
        if (!$router) {
            $router = Router::getInstance();
            Register::set('router', $router);
        }
        return $router;
    }
}