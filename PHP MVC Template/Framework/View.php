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
                    'webRoot' => $webRoot);
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