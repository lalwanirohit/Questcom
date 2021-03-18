<?php

namespace Model\Core;

class Url
{
    protected $request = null;

    public function __contruct()
    {
        $this->setRequest();
    }

    public function setRequest(){
        $this->request = \Mage::getModel('Model\Core\Request');
        return $this;
    }

    public function getRequest() {
        return $this->request;
    }

    public function getUrl ($actionName=null , $controllerName = NULL , $params = null , $resetparams = null) {

        $final = $_GET;

        if($resetparams) {
            $final = [];
        }

        if($controllerName==null) {
            $controllerName = $_GET['controller'];
        }

        if($actionName == null) {
            $actionName = $_GET['action'];
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

    public function baseUrl($subUrl = null)
    {
        $url = "http://localhost/projects/questecom/";
        if($subUrl) {
            $url .= $subUrl;
        }
        return $url;
    }
}

?>