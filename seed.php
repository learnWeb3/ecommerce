


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

// SCRAPPING BOOKS 

// $scrapper = new BookScrapper("https://www.livrenpoche.com/genres");
// $scrapper->registerDatas(50);


// SEEDING PRODUCTS FROM SHOP ON STRIPE AND LINKING STRIPE IDS TO BOOK ON SPECIFIC TABLE

$books = Book::findAll("created_at");
$book = $books[0];
foreach($books as $book)
{
    $book->setPrice(ceil($book->getPrice()));
    $book->update();
    $book_stripe_product_id = $book->setStripeProductId();
    $price_value = ceil($book->getPrice()) * 100;
    $book->setStripePriceId($price_value);
    $book->createStripeDetails();
    sleep(.5);
}



