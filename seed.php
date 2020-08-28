


<?php


require_once 'vendor/autoload.php';
require_once 'app/assets/vendor/simple_html_dom_parser/simple_html_dom.php';

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

        $client = \Symfony\Component\Panther\Client::createChromeClient();

        $html = file_get_html($this->url);

        foreach ($html->find("#wrapbg2 div ul#foldingList li.level0 a") as $targeted_node) {
            $categories[] = array("name" => $targeted_node->innertext, "link" => $targeted_node->href . "?limit=$limit_result_per_page");
        }

        foreach ($categories as $index => $category) {
            $url = $category["link"];
            $crawler = $client->request("GET", $url);
            $categories[$index]["books"] = $crawler->filter("div.bookBox")->each(function (Crawler $node, $i) {
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
                    preg_match_all("/\d+/", $year->text(), $year);
                    return intval($year[0]);
                });

                $price = $node->filter(".buyBook div.price-box span.regular-price span.price")->each(function (Crawler $price, $i) {
                    return $price->text();
                });


                if (!empty($image) && !empty($title) && !empty($author)) {
                    return  array("image" => $image, "title" => $title, "author" => $author, "collection" => $collection, "year" => $year, "price" => $price);
                };
            });

            $categories[$index]["books"] = array_filter($categories[$index]["books"], function ($el) {
                if (is_null($el)) {
                    return false;
                } else {
                    return true;
                }
            });
        }

        return $categories;
    }
}



$scrapper = new Scrapper("https://www.livrenpoche.com/genres");
var_dump($scrapper->getDatas(10));
