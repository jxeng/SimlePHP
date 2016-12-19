<?php
namespace Smile\Database;

class MySQLi implements DbInterface
{
    protected $conn = null;

    public function connect($host, $dbname, $user, $passwd, $port = 3306, $charset = 'utf8')
    {
        $conn = mysqli_connect($host, $user, $passwd, $dbname);
        $this->conn = $conn;
        $this->query("SET NAMES '{$charset}'");
    }

    public function query($sql)
    {
        return mysqli_query($this->conn, $sql);
    }

    public function lastInsertId()
    {
        return $this->conn->insert_id;
    }

    public function close()
    {
        mysqli_close($this->conn);
    }
}