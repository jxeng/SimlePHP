<?php
namespace Smile\Database;

interface DbInterface
{
    function connect($host, $dbname, $user, $passwd, $port, $charset);
    function query($sql);
    function lastInsertId();
    function close();
}