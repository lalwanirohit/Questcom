<?php

namespace Controller\Core;

class Admin {

    protected $request = null;
    protected $layout = null;
    protected $message = null;

    public function __construct()
    {
        $this->setRequest();
        $this->setLayout();
        $this->setMessage();
    }

    public function setRequest(){
        $this->request = new \Model\Core\Request();
    }

    public function getRequest() {
        if(!$this->request) {
            $this->setRequest();
        }
        return $this->request;
    }

    public function redirect ($actionName=null , $controllerName = NULL , $params = null , $resetparams = null) {
        $url = $this->getUrl($actionName, $controllerName , $params , $resetparams);
        header("Location: {$url}");
        exit(0);
    }

    public function setLayout(\Block\Core\Layout $layout = null)
    {
        if (!$layout) {
            $layout = new \Block\Core\Layout();
        }
        $this->layout = $layout;
        return $this;
    }
    
    public function getLayout()
    {
        return $this->layout;
    }

    public function renderLayout() {
        echo $this->getlayout()->toHtml();
    }

    public function getUrl ($actionName=null , $controllerName = NULL , $params = null , $resetparams = null) {

        $final = $_GET;

        if($resetparams) {
            $final = [];
        }

        if($controllerName==null) {
            $controllerName = $this->getRequest()->getGet('controller');
        }

        if($actionName == null) {
            $actionName = $this->getRequest()->getGet('action');
        }

        $final['controller'] = $controllerName;
        $final['action'] = $actionName;
        if(is_array($params)) {
            $final = array_merge($final, $params);
        }
        $queryString = http_build_query($final);
        unset($final);

        return "http://localhost/projects/questecom/index.php?{$queryString}";   
    }

    public function setMessage()
    {
        $this->message = \Mage::getModel('Model\Admin\Message');
        return $this;
    }

    public function getMessage()
    {
        return $this->message;
    }
}

?>