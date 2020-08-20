<?php

class Autoloader
{
    public static function register()
    {
        spl_autoload_register(array(__CLASS__, "getPath"));
    }

    private static function getPath($class)
    {

        $helpers_classes = HELPERS_CLASSES;
        $services_classes = SERVICES_CLASSES;
        $controllers_classes = CONTROLLERS_CLASSES;
        $models_classes = MODELS_CLASSES;

        if (in_array($class, $controllers_classes)) {
            require_once CONTROLLER_PATH . "/" . $class . '.php';
        } elseif (in_array($class, $helpers_classes) && !in_array($class, $services_classes)) {
            require_once HELPER_PATH . "/" . $class . '.php';
        } elseif (in_array($class, $services_classes) && !in_array($class, $helpers_classes)) {
            require_once SERVICE_PATH . "/" . $class . ".php";
        } elseif (in_array($class, $models_classes)) {
            require_once MODEL_PATH . "/" . $class . '.php';
        }
    }
}
