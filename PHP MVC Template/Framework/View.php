<?php
require_once 'Configuration.php';

class View
{
    /**
     * File to use.
     *
     * @var String
     */
    private $file;
    
    /**
     * Title of the page.
     *
     * @var String
     */
    private $title;
    
    /**
     * Action.
     *
     * @var String
     */
    private $action;
    
    /**
     * Controler.
     *
     * @var String
     */
    private $controler;
    
    /**
     * Warning message(s).
     *
     * @var Array
     */
    private $msgWarning;
    
    /**
     * Error message(s).
     *
     * @var Array
     */
    private $msgError;
    
    /**
     * Success message(s).
     *
     * @var Array
     */
    private $msgSuccess;
    
    /**
     * Info message(s).
     *
     * @var Array
     */
    private $msgInfo;
    
    /**
     * Constructor.
     * 
     * @param String $action
     * @param String $controler
     */
    public function __construct($action, $controler = "")
    {
        $file = Configuration::get('viewFolder', 'View').'/';
        if ($controler != "")
            $file = $file.$controler."/";
        $this->file = $file.$action.".php";
        
        $this->action = $action;
        $this->controler = $controler;
        $this->msgInfo = array();
        $this->msgError = array();
        $this->msgWarning = array();
        $this->msgSuccess = array();
    }
    
    /**
     * Create an array of variables usable in the template.
     * 
     * @return Array
     */
    protected function toArray($fromControlerData)
    {
        $content = $this->manageFile($this->file, $fromControlerData);
        $webRoot = Configuration::get("webRoot", "/");
        
        return array('title' => $this->title,
                    'content' => $content,
                    'webRoot' => $webRoot,
                    'messages' => array(
                        array('data' => $this->msgInfo,       'name' => 'info'),
                        array('data' => $this->msgError,      'name' => 'danger'),
                        array('data' => $this->msgWarning,    'name' => 'warning'),
                        array('data' => $this->msgSuccess,    'name' => 'success'),
                    ),
                    'action' => $this->action,
                    'controler' => $this->controler);
    }
	
    /**
     * Compute the view with the array $data
     * 
     * @param Array $fromControlerData
     */
    public function manage($fromControlerData = null)
    {
        $view = $this->manageFile(Configuration::get('viewFolder', 'View').'/'.Configuration::get('templateName', 'template').'.php', $this->toArray($fromControlerData));
        echo $view;
    }
	
    /**
     * Return the content computed of the view.
     * 
     * @param String $file
     * @param Array $data
     * @return String
     * @throws Exception
     */
    private function manageFile($file, $data)
    {
        if (file_exists($file))
        {
            if($data !== null)
                extract($data);
            ob_start();
            require $file;
            return ob_get_clean();
        }
        else
            throw new Exception("File '$file' not found");
    }

    /**
     * Clean a string for html use.
     * 
     * @param String $value
     * @return String
     */
    private function clean($value)
    {
        return htmlspecialchars($value, ENT_QUOTES, 'UTF-8', false);
    }
}