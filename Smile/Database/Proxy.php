<?php
namespace Smile\Database;

use Smile\Factory;

class Proxy
{
    public function query($sql)
    {
        if (substr(ltrim($sql), 0, 6) == 'select')
        {
            return Factory::getDb('slave')->query($sql);
        }
        return Factory::getDb('master')->query($sql);
    }
}