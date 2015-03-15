<?php
require_once 'Request.php';
require_once 'View.php';

class Channel
{
    /**
     * Channel a received request. 
     */
    public function channelRequest()
    {
        try
        {
            $request = new Request(array_merge($_GET, $_POST));
            $controler = $this->createControler($request);
            $action = $this->createAction($request);
            $controler->executeAction($action);
        }
        catch (Exception $ex)
        {
            $this->error($ex);
        }
    }
    
    private function createControler(Request $request)
    {
        $controler = Configuration::get('defaultPage', 'Home');
        if ($request->exists('controler'))
        {
            $controler = $request->get('controler');
            $controler = ucfirst(strtolower($controler));
        }
        
        $controlerPrefix = Configuration::get('controlerPrefix', 'Controler');
        $classControler = $controlerPrefix.$controler;
        $controlerFile = $controlerPrefix."/".$classControler.".php";
        
        if (file_exists($controlerFile))
        {
            require($controlerFile);
            $controler = new $classControler();
            $controler->setRequest($request);
            return $controler;
        }
        else
            throw new Exception("File '$controlerFile' not found");
    }
    
    private function createAction(Request $request)
    {
        $action = "index";
        if ($request->exists('action'))
            $action = $request->get('action');
        
        return $action;
    }
    
    /**
     * Open an error page.
     * 
     * @param Exception $ex
     */
    private function error(Exception $ex)
    {
        $view = new View(Configuration::get('errorPage', 'error'));
        $view->manage(array('errorMessage' => $ex->getMessage()));
    }
}