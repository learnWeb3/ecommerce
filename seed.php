


<?php

require_once 'app/config/paths.php';
require_once 'app/config/db_credentials.php';
require_once 'app/config/db_naming_conventions.php';
require_once 'app/config/autoloader.php';
require_once 'app/helpers/Autoloader.php';
require_once 'vendor/autoload.php';
require_once 'app/assets/vendor/simple_html_dom_parser/simple_html_dom.php';

Autoloader::register();

use Symfony\Component\DomCrawler\Crawler;


class Scrapper
{


    private $url;


    public function __construct($url)
    {
        return $this->url = $url;
    }

    public function setUrl($url)
    {
        $this->url = $url;
    }


    public function getUrl($url)

    {
        return $this->url = $url;
    }


    public function getDatas($limit_result_per_page = 10)
    {

        set_time_limit(0);

        $client = \Symfony\Component\Panther\Client::createChromeClient();

        $html = file_get_html($this->url);

        foreach ($html->find("#wrapbg2 div ul#foldingList li.level0 a") as $targeted_node) {
            foreach ($targeted_node->find('span') as $title) {
                $title = $title->innertext;
            }
            $categories[] = array("name" => $title, "link" => $targeted_node->href . "?limit=$limit_result_per_page");
        }

        foreach ($categories as $index => $category) {
            $url = $category["link"];
            $crawler = $client->request("GET", $url);
            $categories[$index]["books"] = $crawler->filter("div.bookBox")->each(function (Crawler $node, $i) {

                $link = $node->filter(".product-image-container a.product-image")->each(function (Crawler $link, $i) {
                    return $link->attr('href');
                });
                $image = $node->filter(".product-image-container a img")->each(function (Crawler $image, $i) {
                    return $image->attr('src');
                });

                $title = $node->filter(".bookLink a")->each(function (Crawler $title, $i) {
                    return $title->text();
                });

                $author = $node->filter(".author p a.authorLink")->each(function (Crawler $author, $i) {
                    return $author->text();
                });

                $collection = $node->filter(".collection a")->each(function (Crawler $collection, $i) {
                    return $collection->text();
                });

                $year = $node->filter(".collection")->each(function (Crawler $year, $i) {
                    return $year->text();
                });

                $price = $node->filter(".buyBook div.price-box span.regular-price span.price")->each(function (Crawler $price, $i) {
                    return $price->text();
                });



                if (!empty($image) && !empty($title) && !empty($author) && !empty($collection) && !empty($price) && !empty($year) && !empty($link)) {
                    return  array("image" => $image[0], "title" => $title[0], "author" => $author[0], "collection" => $collection[0], "year" => $year[0], "price" => $price[0], "link" => $link[0]);
                };
            });

            $categories[$index]["books"] = array_filter($categories[$index]["books"], function ($el) {
                if (is_null($el) || empty($el["link"]) || empty($el["price"]) || empty($el["year"] || empty($el["author"]) || empty($el["collection"] || empty($el["image"] || empty($el["title"]))))) {
                    return false;
                } else {
                    return true;
                }
            });

            foreach ($categories[$index]["books"] as $i => $book) {
                preg_match_all("/\d+,\d+/", $book["price"], $price);
                preg_match_all("/\d{4}/", $book["year"], $year);
                $book["price"] = floatval(str_replace(',', '.', $price[0][0]));


                if (isset($year[0])) {
                    if (count($year[0]) > 1) {
                        if (isset($year[0][1])) {
                            $book["year"] = strftime("%Y-%m-%d",strtotime($year[0][1]));
                        }
                    } else {
                        if (isset($year[0][0])) {
                            $book["year"] =  strftime("%Y-%m-%d",strtotime($year[0][0]));
                        }
                    }
                }

                $crawler = $client->request("GET", $book["link"]);


                $book["description"] = $crawler->filter('.liWrap > span > .bookDesc')->each(function (Crawler $description, $i) {
                    return $description->text();
                });


                if (isset($book["description"][0])) {
                    $book["description"] = $book["description"][0];
                } else {
                    unset($book);
                }
                if (isset($book)) {
                    $categories[$index]["books"][$i] = $book;
                }
            };
        };

        return array_map(function ($el) {

            array_filter(
                $el["books"],
                function ($e) {
                    if (empty($e["description"])) {
                        return false;
                    } else {
                        return true;
                    }
                }
            );

            return $el;
        }, $categories);
    }


    public function registerDatas(int $entry_number_per_category)
    {

        DbRecords::destroyAll(array("categories", "books"));
        $datas =  $this->getDatas($entry_number_per_category);
        foreach ($datas as $index => $category) {
            $category_obj =  new Category($category['name']);
            foreach ($category["books"] as $i => $book) {
                $book = new Book($book["title"], $book["author"], $book["editor"], $book["price"], $book["year"], $book["image"], $book["description"], $category_obj->getId());
                var_dump($book->create());
            }
        }
    }
}



$scrapper = new Scrapper("https://www.livrenpoche.com/genres");
$scrapper->registerDatas(5);



