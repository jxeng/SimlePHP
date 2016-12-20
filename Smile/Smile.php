<?php
namespace Smile;

class Smile
{
    static protected $instance = null;

    private function __construct()
    {
        Factory::getConfig();
    }

    static public function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function start()
    {
        $router = Factory::getRouter();
        $router->route();
    }
}