<?php
class ApplicationController
{

    public function __construct()
    {
    }

    public function render($view_name, $title, $description, $vars = [])
    {
        extract($vars);
        $folder_name = strtolower(str_replace("Controller", "", get_called_class()));
        ob_start();
        require_once VIEW_PATH . "/" . $folder_name . "/" . $view_name . ".php";
        $yield  = ob_get_clean();
        require_once LAYOUT_PATH . "/base.php";
    }
}
