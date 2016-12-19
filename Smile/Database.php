<?php
namespace Smile;

class Database
{
    static private $db = null;
    private function __construct()
    {

    }

    static public function getInstance()
    {
        if (!self::$db) {
            self::$db = new self();
        }
        return self::$db;
    }
}