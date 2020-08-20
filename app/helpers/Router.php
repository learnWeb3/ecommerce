<?php

require_once 'error_functions.php';

class Router
{
    public static function route()
    {
        if (isset($_GET["controller"])) {
            $controller = ucfirst($_GET["controller"]) . "Controller";
        }else{
            $controller = "";
        }

        if (isset($_GET["method"])) {
            $method = $_GET["method"];
        }else{
            $controller = "";
        }

        if (class_exists($controller)) {
            $controller = new $controller;
            if (method_exists($controller, $method)) {
                die($controller->$method);
            }
        }

        die(renderErrror(404));
    }
}
