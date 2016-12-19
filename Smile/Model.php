<?php
namespace Smile;

//模型基类
class Model
{
    protected $db = null;
    protected $primary_key = 'id';  //默认主键为'id'

    public function __construct($mode = 'master')
    {
        $this->db = Factory::getDb($mode);
    }

    /**
     * 新增和修改，数组中有主键为修改，否则为新增
     * @param array $data
     * @return bool|mixed|\mysqli_result
     */
    public function save($data = [])
    {
        if (isset($data[$this->primary_key]) && $data[$this->primary_key]) {
            $primary_key_value = $data[$this->primary_key];
            unset($data[$this->primary_key]);
            return self::update($primary_key_value, $data);
        }
        $keys = array_keys($data);
        $values = array_values($data);
        $sql = 'INSERT INTO '.self::getTableName().'('.implode(',', $keys).') VALUES(\''.implode('\',\'', $values).'\')';
        return $this->db->query($sql);
    }

    public function fetchAll($columns = [], $where = [], $order = [])
    {
        $sql = 'SELECT '.self::handleColumns($columns).' FROM '.self::getTableName().self::handleWhere($where).self::handleOrder($order);
        $res = $this->db->query($sql);
        return $res ? $res->fetchAll() : null;
    }

    public function fetchOne($columns = [], $where = [], $order = [])
    {
        $sql = 'SELECT '.self::handleColumns($columns).' FROM '.self::getTableName().self::handleWhere($where).self::handleOrder($order).' LIMIT 1';
        $res = $this->db->query($sql);
        return $res ? $res->fetchAll()[0] : null;
    }

    public function fetchLimit($offset = 0, $rows = 20, $columns = [], $where = [], $order = [])
    {
        $sql = 'SELECT '.self::handleColumns($columns).' FROM '.self::getTableName().self::handleWhere($where).self::handleOrder($order)." LIMIT $offset,$rows";
        $res = $this->db->query($sql);
        return $res ? $res->fetchAll() : null;
    }

    public function count($columns = [], $where = [], $order = [])
    {
        $sql = 'SELECT '.self::handleColumns($columns).' FROM '.self::getTableName().self::handleWhere($where).self::handleOrder($order);
        $res = $this->db->query($sql);
        return $res ? count($res->fetchAll()) : 0;
    }

    public function lastInsertId()
    {
        return $this->db->lastInsertId();
    }

    public function get($primary_key_value)
    {
        return self::fetchOne([], [$this->primary_key => $primary_key_value]);
    }

    public function delete($primary_key_value)
    {
        $sql = 'DELETE FROM '.self::getTableName().self::handleWhere([$this->primary_key => $primary_key_value]).' LIMIT 1';
        return $this->db->query($sql);
    }

    public function deleteWhere($where = [])
    {
        $sql = 'DELETE FROM '.self::getTableName().self::handleWhere($where);
        return $this->db->query($sql);
    }

    public function queryBySQL($sql)
    {
        return $this->db->query($sql);
    }

    private function update($primary_key_value, $update = [])
    {
        $sql = 'UPDATE '.self::getTableName().self::handleUpdate($update).self::handleWhere([$this->primary_key => $primary_key_value]).' LIMIT 1';
        return $this->db->query($sql);
    }

    static public function getTableName()
    {
        list(,,$model_name) = explode('\\', get_called_class());
        return substr(strtolower($model_name),0,-5);
    }

    static private function handleColumns($columns)
    {
        if (count($columns) == 0) {
            return '*';
        }
        return implode(',', $columns);
    }

    static private function handleWhere($where)
    {
        if (count($where) == 0) {
            return ' ';
        }
        if (!is_array(reset($where))) {
            return ' WHERE '.self::andAssmble($where);
        } else {
            $where_string = ' ( ';
            foreach ($where as $item) {
                $where_string .= self::andAssmble($item) . ' OR ';
            }
            $where_string = substr($where_string, 0, -3) . ' ) ';
            return ' WHERE ' . $where_string;
        }
    }

    static private function handleOrder($order)
    {
        if (count($order) == 0) {
            return ' ';
        }
        $order_string = ' ORDER BY ';
        foreach ($order as $key=>$value) {
            $order_string .= $key . ' ' . $value . ', ';
        }
        return substr($order_string, 0, -2);
    }

    static private function handleUpdate($update)
    {
        if (count($update) == 0) {
            return ' ';
        }
        $update_string = ' SET ';
        foreach ($update as $key=>$value) {
            $update_string .= "$key='$value',";
        }
        return substr($update_string, 0, -1);
    }

    static private function andAssmble($arr)
    {
        $where_string = ' ( ';
        foreach ($arr as $key => $value) {
            if (strpos($key, '?') === false) {
                $where_string .= " $key='$value' AND ";
            } else {
                $where_string .= str_replace('?', "'$value'", $key) . ' AND ';
            }
        }
        $where_string = substr($where_string, 0, -4) . ' ) ';
        return $where_string;
    }
}