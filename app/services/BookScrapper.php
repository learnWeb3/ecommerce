<?php 

use Symfony\Component\DomCrawler\Crawler;
class BookScrapper
{

    // ATTRIBUTES
    private $url;

    // CONSTRUCTOR
    public function __construct($url)
    {
        return $this->url = $url;
    }

    // SET DIFFERENT URL FOR A GIVEN SCRAPPER INSTANCE
    public function setUrl($url)
    {
        $this->url = $url;
    }

    // GET URL OF A CURRENT SCRAPPER
    public function getUrl($url)

    {
        return $this->url = $url;
    }

    // GET CATEGORIES AND BOOKS DATA ON livrenpoche.fr
    public function getDatas($limit_result_per_page = 10)
    {

        // CREATING INSTANCE OF CHROME EMULATED BROWSER THROUGH PANTHER/SELENIUM TO USE CHROMEWEBDRIVER AND PARSE JAVASCRIPT GENERATED CONTENT
        $client = \Symfony\Component\Panther\Client::createChromeClient();

        // TO GET CATEGORIES NO NEED TO USE PANTHER/SELENIUM SO BETTER UTO USE SIMPLE HTML DOM PARSER LIBRARY TO FETCH IT
        $html = file_get_html($this->url);

        // GETTING CATEGORIES
        foreach ($html->find("#wrapbg2 div ul#foldingList li.level0 a") as $targeted_node) {
            foreach ($targeted_node->find('span') as $title) {
                $title = $title->innertext;
            }
            $categories[] = array("name" => $title, "link" => $targeted_node->href . "?limit=$limit_result_per_page");
        }

        // TARGETING COMMON PARENT TO ALL TARGETED NODES IN THE DOM
        foreach ($categories as $index => $category) {
            $url = $category["link"];
            $crawler = $client->request("GET", $url);
            $categories[$index]["books"] = $crawler->filter("div.bookBox")->each(function (Crawler $node, $i) {
                // LINK OF BOOK TO GET DESCRIPTION LATER ON
                $link = $node->filter(".product-image-container a.product-image")->each(function (Crawler $link, $i) {
                    return $link->attr('href');
                });
                // IMAGE SRC TO HAVE COVER
                $image = $node->filter(".product-image-container a img")->each(function (Crawler $image, $i) {
                    return $image->attr('src');
                });
                // BOOK TITLE
                $title = $node->filter(".bookLink a")->each(function (Crawler $title, $i) {
                    return $title->text();
                });
                // BOOK AUTHOR
                $author = $node->filter(".author p a.authorLink")->each(function (Crawler $author, $i) {
                    return $author->text();
                });
                // BOOK COLLECTION
                $collection = $node->filter(".collection a")->each(function (Crawler $collection, $i) {
                    return $collection->text();
                });
                // BOOK PUBLICATION YEAR
                $year = $node->filter(".collection")->each(function (Crawler $year, $i) {
                    return $year->text();
                });

                // BOOK PRICE 
                $price = $node->filter(".buyBook div.price-box span.regular-price span.price")->each(function (Crawler $price, $i) {
                    return $price->text();
                });

                // GETIING RID OF ARRAY FORMAT
                if (!empty($image) && !empty($title) && !empty($author) && !empty($collection) && !empty($price) && !empty($year) && !empty($link)) {
                    return  array("image" => $image[0], "title" => $title[0], "author" => $author[0], "collection" => $collection[0], "year" => $year[0], "price" => $price[0], "link" => $link[0]);
                };
            });

            // FILTERING OUT INCOMPLETE DATAS
            $categories[$index]["books"] = array_filter($categories[$index]["books"], function ($el) {
                if (is_null($el) || empty($el["link"]) || empty($el["price"]) || empty($el["year"] || empty($el["author"]) || empty($el["collection"] || empty($el["image"] || empty($el["title"]))))) {
                    return false;
                } else {
                    return true;
                }
            });

            // FORMATTING PRICE AND YEAR ENTRIES AND GETTING DESCRIPTION OF EACH BOOK BY FOLLOWING PREVIOUSLY REGISTERED LINK TO BOOK SHOW PAGE
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

        // FILTERING OUT BOOK WITHOUT DESCRIPTION
        return array_map(function ($el) {

            $el["books"] = array_filter(
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

    // REGISTERING DATAS IN DATABASE
    public function registerDatas(int $entry_number_per_category)
    {
        // DESTROYING PREVIOUS ENTRIES TO AVOID DUPLICATE
        Db::destroyAll(array("categories", "books"));
        // RESETTING AUTOINCREMENT OF TABLES
        Db::resetAutoIncrement("categories");
        Db::resetAutoIncrement("books");

        // GETTING DATAS 
        $datas =  $this->getDatas($entry_number_per_category);

        // var_dump($datas);

        // CONSTRUCTING OBJECTS FROM DATAS AND POPULATING DATABASE WITH APPROPRIATE DATAS
        foreach ($datas as $index => $category) {
            $category_obj =  new Category($category['name']);
            $category_obj = $category_obj->create();
            var_dump($category_obj);
            foreach ($category["books"] as $i => $book) {
                $book = new Book($book["title"], $book["author"], $book["collection"], $book["price"], $book["year"], $book["image"], $book["description"], $category_obj->getId());
                var_dump($book->create());
            }
        }

        return $datas;
    }
}