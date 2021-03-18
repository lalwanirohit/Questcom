<?php
namespace Controller\Core; 

class Front {
    public static function init() {
        $request =  \Mage::getModel('Model\Core\Request');
        $controllerName = ucFirst($request->getControllerName());
        $actionName = $request->getActionName().'Action';
        $controllerClassName = self::prepareClassName($controllerName, 'controller');
        $controller = \Mage::getController($controllerClassName);
        $controller;
        $controller->$actionName();
    }

    public static function prepareClassName($key, $namespace)
	{
		$className = $namespace." ".$key;
		$className = str_replace('_',' ',$className);
		$className = ucwords($className);
		$className = str_replace(' ','\\',$className);
		return $className;
	}
}

?>