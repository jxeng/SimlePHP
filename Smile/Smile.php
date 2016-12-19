<?php
namespace Smile;

class Smile
{
    public $configObj = null;
    static protected $instance = null;

    private function __construct()
    {
        $this->configObj = new Config();
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
        Router::route($this->configObj->offsetGet('modules'));
    }
}