<?php
namespace Smile\Database;

class PDO implements DbInterface
{
    protected $conn = null;

    public function connect($host, $dbname, $user, $passwd, $port = 3306, $charset = 'utf8')
    {
        $conn = new \PDO("mysql:host={$host};port={$port};dbname={$dbname};charset={$charset}", $user, $passwd);
        $this->conn = $conn;
    }

    public function query($sql)
    {
        return $this->conn->query($sql, \PDO::FETCH_ASSOC);
    }

    public function lastInsertId()
    {
        return $this->conn->lastInsertId();
    }

    public function close()
    {
        unset($this->conn);
    }
}