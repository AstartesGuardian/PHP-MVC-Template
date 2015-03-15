<?php

/**
 * Manage the global constants from ini files in Config folder.
 */
class Configuration
{
    /**
     * Stored parameters.
     * 
     * @var Array
     */
    private static $parameters;

    /**
     * Get a parameter according to its $name. If the parameter doesn't exist,
     * it returns $defaultValue.
     * 
     * @param String $name
     * @param var $defaultValue
     * @return var
     */
    public static function get($name, $defaultValue = null)
    {
        if(isset(self::getParameters()[$name]))
            $values = self::getParameters()[$name];
        else
            $values = $defaultValue;
        
        return $values;
    }
    
    /**
     * Get the parameters from "Config/prod.ini". If this file is missing, it
     * will get parameters from "Config/dev.ini".
     * 
     * @return Array
     * @throws Exception
     */
    private static function getParameters()
    {
        if(self::$parameters == null)
        {
            $filePath = "Config/prod.ini";
            if (!file_exists($filePath))
                $filePath = "Config/dev.ini";
            
            if (!file_exists($filePath))
                throw new Exception("No configuration file found");
            else
                self::$parameters = parse_ini_file($filePath);
        }
        return self::$parameters;
    }
}