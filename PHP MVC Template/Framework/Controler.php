<?php
require_once 'Request.php';
require_once 'View.php';

abstract class Controler
{
    /**
     * @var String
     */
    private $action;
    
    /**
     * Controler name
     * 
     * @example "Home" (for ControlerHome)
     * @var String
     */
    private $controler;
    
    /**
     * Contains the parameters sent with GET or POST
     * 
     * @var Request 
     */
    protected $parameters;
    
    /**
     * Contains the values which will be given to the View
     * 
     * @var Array
     */
    protected $viewData = array();


    /**
     * @deprecated Internal use only
     * 
     * @param Request $request Request received
     */
    public function setRequest(Request $request)
    {
        $this->parameters = $request;
    }
    
    /**
     * Call the controler action.
     * 
     * @deprecated Internal use only
     * @param String $action
     * @throws Exception
     */
    public function executeAction($action)
    {
        $controlerClass = get_class($this);
        
        if (method_exists($this, $action))
        {
            $this->action = $action;
            
            $this->controler = str_replace(Configuration::get('controlerPrefix', 'Controler'), "", $controlerClass);
            
            $this->{$this->action}();
            
            $this->runView();
        }
        else
        {
            throw new Exception("Action '$action' not defined in the class $controlerClass");
        }
    }
    
    /**
     * Default call when no action specified.
     * 
     * @return void
     */
    public abstract function index();
    
    /**
     * Set the view which will be called.
     * 
     * @param String $actionName
     * @param String $controlerName
     */
    protected function setView($actionName, $controlerName = null)
    {
        if($controlerName != null)
            $this->controler = $controlerName;
        
        $this->action = $actionName;
    }

    /**
     * Run the selected or default view.
     */
    private function runView()
    {
        $view = new View($this->action, $this->controler);
        $view->manage($this->viewData);
    }
    
    /**
     * Show the error page instead of the selected view.
     * 
     * @param var $errorMessage
     */
    protected function error($errorMessage)
    {
        $view = new View(Configuration::get('errorPage', 'error'));
        $view->manage(array('errorMessage' => $errorMessage));
    }
}