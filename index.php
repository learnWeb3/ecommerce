<?php
require_once 'app/config/paths.php';
require_once 'app/config/db_credentials.php';
require_once 'app/config/db_naming_conventions.php';
require_once 'app/config/autoloader.php';
require_once 'app/helpers/Autoloader.php';

Autoloader::register();

Session::init();

Router::route();


