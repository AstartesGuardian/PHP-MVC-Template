<?php
include_once 'Framework/Controler.php';

abstract class ControlerSession extends Controler
{
    /**
     * Session values.
     *
     * @var Array
     */
    protected $sessions;
    
    /**
     * Coockie values
     *
     * @var Array
     */
    protected $cookies;
    
    /**
     * @deprecated Internal use only
     * 
     * @param Request $request Request received
     */
    public function setRequest(Request $request)
    {
        parent::setRequest($request);
        $this->sessions = new Request($_SESSION);
        $this->cookies = new Request($_COOKIE);
    }
}

