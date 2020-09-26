<?php


define("HELPERS_CLASSES", ["Autoloader", "Router", "Db", "DbRecords", "Session", "SearchEngine","Validator", "Flash"]);
define("SERVICES_CLASSES", ["BookScrapper", "AppStripe"]);
define("CONTROLLERS_CLASSES", ["ApplicationController", "AdminController","HomeController", "UserController", "SessionController", "BookController", "BasketitemController", "CheckoutController", "SearchController","RecommendationController","OrderController","InvoiceController"]);
define("MODELS_CLASSES", ["Category", "Book", "Basket", "BasketItem", "User", "Invoice"]);
