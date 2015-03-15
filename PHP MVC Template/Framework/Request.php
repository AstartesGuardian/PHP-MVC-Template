<?php

/**
 * Parameter manager
 */
class Request
{
    /**
     * Contains the parameters obtained from a GET or POST request.
     *
     * @var Array
     */
    private $parameters;

    /**
     * Create a parameter manager with an array of parameters.
     * 
     * @param Array $parameters
     */
    public function __construct($parameters)
    {
        $this->parameters = $parameters;
    }
    
    /**
     * Test if a parameter exists.
     * 
     * @param String $name
     * @return bool
     */
    public function exists($name)
    {
        return (isset($this->parameters[$name]) && $this->parameters[$name] != "");
    }

    /**
     * Set a parameter value.
     * 
     * @param String $name
     * @param var $value
     */
    public function set($name, $value)
    {
        $this->parameters[$name] = $value;
    }

    /**
     * Get a parameter value from its $name. If the parameter doesn't exist,
     * it returns $defaultValue.
     * 
     * @param String $name
     * @param var $defaultValue
     * @return var
     */
    public function get($name, $defaultValue = null)
    {
        if ($this->exists($name))
            return $this->parameters[$name];
        else
            return $defaultValue;
    }
}