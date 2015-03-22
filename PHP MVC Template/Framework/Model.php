<?php
require_once 'Configuration.php';

abstract class Model
{
    /**
     * Data base
     *
     * @var PDO
     */
    private static $db;
    
    /**
     * Execute a query to the data base.
     * 
     * @param String $sql
     * @param Array $params
     * @return PDOStatement
     */
    private function executeRequest($sql, $params = null)
    {
        if ($params == null)
            $result = self::getDB()->query($sql);
        else
        {
            $result = self::getDB()->prepare($sql);
            $result->execute($params);
        }
        return $result;
    }
    
    /**
     * Return a tuple.
     * 
     * @param String $sql
     * @param Array $params
     * @return Array
     */
    protected static function getOne($sql, $params = null)
    {
        $result = self::executeRequest($sql, $params);
        
        if ($result->rowCount() == 1)
            return $result->fetch();
        else
            return null;
    }
    
    /**
     * Return an object.
     * 
     * @param String $sql
     * @param Array $params
     * @return Object
     */
    protected static function getOneObject($sql, $params = null)
    {
        $result = self::getOne($sql, $params);
        
        if($result != null)
        {
            $class = get_called_class();
            return new $class($result);
        }
        else
            return null;
    }
    
    /**
     * Return an array of tuple.
     * 
     * @param String $sql
     * @param Array $params
     * @return ArrayArray
     */
    protected static function getMany($sql, $params = null)
    {
        return self::executeRequest($sql, $params);
    }
    
    /**
     * Return an array of object.
     * 
     * @param String $sql
     * @param Array $params
     * @return Array
     */
    protected static function getManyObject($sql, $params = null)
    {
        $r = self::getMany($sql, $params);
        
        if($r != null)
        {
            $class = get_called_class();
            $a = array();
            foreach($r as $k => $v)
                $a[] = new $class($v);
            return $a;
        }
        else
            return array();
    }
    
    /**
     * Return the result of the math calculation.
     * Example : SUM(x) or COUNT(*) ...
     * 
     * @param String $sql
     * @param Array $params
     * @return int
     */
    protected static function getMath($sql, $params = null)
    {
        return reset(self::getOne($sql, $params));
    }
    
    /**
     * Get the data base manager.
     * 
     * @return PDO
     */
    private static function getDB()
    {
        if (self::$db === null)
        {
            $dsn = Configuration::get("dsn");
            $login = Configuration::get("login");
            $password = Configuration::get("password");
            
            self::$db = new PDO($dsn, $login, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        }
        return self::$db;
    }
}