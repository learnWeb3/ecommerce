<?php
require_once 'app/config/paths.php';
require_once 'app/config/db_credentials.php';
require_once 'app/config/autoloader.php';
require_once 'app/helpers/Autoloader.php';

Autoloader::register();
Router::route();
