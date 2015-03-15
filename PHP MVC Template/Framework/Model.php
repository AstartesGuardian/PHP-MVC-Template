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
    protected function executeRequest($sql, $params = null)
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