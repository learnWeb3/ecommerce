


<?php
require_once 'vendor/autoload.php';
require_once 'app/config/paths.php';
require_once 'app/config/stripe_credentials.php';
require_once 'app/config/db_credentials.php';
require_once 'app/config/db_naming_conventions.php';
require_once 'app/config/autoloader.php';
require_once 'app/helpers/Autoloader.php';
require_once 'vendor/autoload.php';
require_once 'app/assets/vendor/simple_html_dom_parser/simple_html_dom.php';

Autoloader::register();

use Symfony\Component\DomCrawler\Crawler;


// $scrapper = new BookScrapper("https://www.livrenpoche.com/genres");
// $scrapper->registerDatas(50);


$books = Book::findAll("created_at");

foreach($books as $book)
{
    $book_stripe_product_id = $book->setStripeProductId();
    $book->setStripePriceId($quantity, $currency_symbol = 'eur');
    $book->createStripeDetails();
}



