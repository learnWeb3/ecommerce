<?php

if ($_SERVER['DOCUMENT_ROOT'] == '/var/www/ecommerce') {
    define("ROOT_PATH", $_SERVER['DOCUMENT_ROOT']);
    define("ABSOLUTE_ASSET_PATH", "http://" . $_SERVER["SERVER_NAME"] . "/app/assets");
    define("REDIRECT_BASE_URL", "http://" . $_SERVER["SERVER_NAME"] . "/index.php?");
    define("ABSOLUTE_UPLOAD_PATH", "http://" . $_SERVER["SERVER_NAME"] . "/app/public/upload");
    // DEFINE STRIPE URL 
    
} else {
    define("ROOT_PATH", $_SERVER['DOCUMENT_ROOT'] . "/" . "ecommerce");
    define("ABSOLUTE_ASSET_PATH", "http://" . $_SERVER["SERVER_NAME"] . "/ecommerce/app/assets");
    define("REDIRECT_BASE_URL", "http://" . $_SERVER["SERVER_NAME"] . "/ecommerce/index.php?");
    define("ABSOLUTE_UPLOAD_PATH", "http://" . $_SERVER["SERVER_NAME"] . "/ecommerce/app/public/upload");
    define("STRIPE_SUCCESS_URL", "http://".$_SERVER['SERVER_NAME']."/ecommerce/index.php?controller=checkout&method=success");
    define("STRIPE_CANCEL_URL", "http://".$_SERVER['SERVER_NAME']."/ecommerce/index.php?controller=checkout&method=error");

}

define("APP_PATH", ROOT_PATH . "/app");
define("CONTROLLER_PATH", APP_PATH . "/controllers");
define("VIEW_PATH", APP_PATH . "/views");
define("MODEL_PATH", APP_PATH . "/models");
define("SERVICE_PATH", APP_PATH . "/services");
define("HELPER_PATH", APP_PATH . "/helpers");
define("LAYOUT_PATH", APP_PATH . "/layouts");
define("ERROR_PATH", APP_PATH . "/layouts/errors");
define("UPLOAD_PATH", APP_PATH . "/public/upload");


