<?php
class ApplicationController
{

    public function __construct()
    {
    }

    public function render($view_name, $title, $description, $vars = [], $admin_template = false)
    {

        // GETTING CURRENT USER IF EXISTS ACCESSIBLE IN ALL VIEWS
        if (isset($_SESSION['current_user'])) {
            $current_user = Session::getCurrentUser();
        }

        $search_filters = Db::getSearchFilters();

        // GETTING BASKET ACCESSIBLE IN ALL VIEWS
        $basket = Basket::getBasket();

        $categories = Category::findAll("categories.created_at");

        $basket_products = $basket->notEmpty() ? $basket->getAllProducts() : array();

        // EXTRACTING VIEW SPECIFIC VARIABLES 
        extract($vars);
        // GETTING PATH TO VIEW
        $folder_name = strtolower(str_replace("Controller", "", get_called_class()));
        // STRATING CACHING TEMPLATE VIEW
        ob_start();
        // REQUIRING VIEW REQUESTED BY CONTROLLER AND STORING IT IN CACHE
        require_once VIEW_PATH . "/" . $folder_name . "/" . $view_name . ".php";
        // ATTRIBUTING CACHE TO CONTENT TO VARIABLE AND CLOSING BUFFER
        $yield  = ob_get_clean();

        if (!$admin_template)
        // REQUIRING BASE LAYOUT IN LAST STEP TO ACCESS CONTENT VARIABLE PREVIOUSLY INITIALIZED
        {
            require_once LAYOUT_PATH . "/base.php";
        } else {
            require_once LAYOUT_PATH . "/admin_template.php";
        }
    }
}
