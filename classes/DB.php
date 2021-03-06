<?php 
class DB {
    private static $_instance = null;
    private $_pdo,
            $_query,
            $_error = false,
            $_results,
            $_count = 0,
            $operators = array('=', '>', '<', '>=', "<=");
    private function __construct(){
        try {
            $this->_pdo = new PDO('mysql:host='.Config::get('mysql/host'). ';dbname='.Config::get('mysql/db'),Config::get('mysql/username'),Config::get('mysql/password'));
        } catch(PDOexception $e) {
            die($e -> getMessage());
        }
    }
    public static function getInstance(){
        if(!isset(self::$_instance)){
            self::$_instance = new DB();
        }
        return self::$_instance;
    }
    public function query($sql, $params = array()){
        $this->_error = false;
        if($this->_query = $this->_pdo->prepare($sql)){
            if(count($params)){
                $x = 1;
                foreach ($params as $param){
                    $this->_query->bindValue($x, $param);
                    $x++;
                }
            }
            if($this->_query->execute()){
                $this->_results = $this->_query->fetchAll(PDO::FETCH_OBJ);
                $this->_count = $this->_query->rowCount();
            } else {
                $this->_error = true;
            }
        }
        return $this;
    }
    public function action($action, $table, $where=array()){
        if(count($where) === 3){
            $field = $where[0];
            $operator = $where[1];
            $value = $where[2];
            if(in_array($operator, $this->operators)){
                $sql = "{$action} FROM {$table} WHERE {$field} {$operator} ?";

                if(!$this->query($sql, array($value))->error()){
                    return $this;
                }
            }
        }
        elseif (!count($where)){
            $sql = "{$action} FROM {$table}";

            if(!$this->query($sql)->error()){
                return $this;
            }
        }
        return false;
    }
    public function get($table, $where){
        return $this->action("SELECT *", $table, $where);
    }
    public function getAll($table){
        return $this->action("SELECT *", $table);
    }
    public function delete($table, $where){
        return $this->action("DELETE", $table, $where);
    }
    public function insert($table, $fields = array())
    {
        if(count($fields) && isset($table)){
            $keys = array_keys($fields);
            $values = '';
            $index = 1;
            foreach ($fields as $field){
                $values .= '?';
                if($index < count($fields)){
                    $values .= ', ';
                }
                $index++;
            }
            $sql = "INSERT INTO {$table} (`". implode('`, `', $keys) ."`) VALUES ({$values})";
            if(!$this->query($sql, $fields)->error()){
                return true;
            }
        }
        return false;
    }
    public function update($table, $where = array(), $fields = array()){
        if(isset($table) && count($where) === 3){
            $set = '';
            $index = 1;
            $field = $where[0];
            $operator = $where[1];
            $value = $where[2];
            foreach ($fields as $key => $values){
                $set .= "{$key} = ?";
                if($index < count($fields)){
                    $set .= ", ";
                }
                $index++;
            }
            if(in_array($operator, $this->operators)){
                $sql = "UPDATE {$table} SET {$set} WHERE {$field} {$operator} {$value}";
                if(!$this->query($sql, $fields)->error()){
                    return true;
                }
            }
        }
        return false;
    }
    public function count(){
        return $this->_count;
    }
    public function results(){
        return $this->_results;
    }
    public function first(){
        return $this->results()[0];
    }
    public function error(){
        return $this->_error;
    }
}