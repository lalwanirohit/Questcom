<?php

spl_autoload_register(__NAMESPACE__ . 'Mage::LoadFileByClassName');

class Mage
{
    public static function init()
    {
        self::loadFileByClassName("Controller\Core\Front");
        \Controller\Core\Front::init();
    }

    public static function getController($className)
    {
        self::loadFileByClassName($className);
        $className = str_replace('\\', ' ', $className);
        $className = ucwords($className);
        $className = str_replace(' ', '\\', $className);
        return new $className();
    }

    public static function loadFileByClassName($className)
    {
        $className = str_replace('\\', ' ', $className);
        $className = ucwords($className);
        $className = str_replace(' ', '/', $className);
        $className = $className . '.php';
        $className . "<br>";
        require_once $className;
    }

    public static function getBlock($className)
    {
        return Mage::getController($className);
    }

    public static function getModel($className)
    {
        return Mage::getController($className);
    }
}

Mage::init();
