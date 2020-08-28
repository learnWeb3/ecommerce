


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

        set_time_limit(0);

        $client = \Symfony\Component\Panther\Client::createChromeClient();

        $html = file_get_html($this->url);

        foreach ($html->find("#wrapbg2 div ul#foldingList li.level0 a") as $targeted_node) {
            $categories[] = array("name" => $targeted_node->innertext, "link" => $targeted_node->href . "?limit=$limit_result_per_page");
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
        }



        return array_map(function ($el) use ($client) {
            $el["books"] = array_map(function ($e) use ($client) {
                preg_match_all("/\d+,\d+/", $e["price"], $price);
                preg_match_all("/\d{4}/", $e["year"], $year);
                $e["price"] = floatval(str_replace(',', '.',$price[0][0]));
                $e["year"] = strftime("%Y",strtotime($year[0]));

                $crawler = $client->request("GET", $e["link"]);


                $e["description"] = $crawler->filter('.liWrap > span > .bookDesc')->each(function (Crawler $description, $i) {
                    return $description->text();
                });


                if (isset($e["description"][0])) {
                    $e["description"] = $e["description"][0];
                } else {
                    $e["description"] = "";
                }

                return $e;
            }, $el["books"]);
            return $el;
        }, $categories);
    }
}



$scrapper = new Scrapper("https://www.livrenpoche.com/genres");
var_dump($scrapper->getDatas(20));
