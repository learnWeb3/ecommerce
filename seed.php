


<?php


require_once 'app/assets/vendor/simple_html_dom_parser/simple_html_dom.php';


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




    // [

    //     "category"=>["name"=>, "subcategories"=>[["name"=>,"link"=>], ["name"=>,"link"=>], ["name"=>,"link"=>]]]

    // ]



    public function getDatas()
    {

        $html = file_get_html($this->url);

        foreach ($html->find('nav.row .col-md-12 ul.nav-arborescence li.nav-arborescence-item') as $navigation_menu_node) {
            foreach ($navigation_menu_node->find('a span.arborescence-level-1') as $category_title_node) {
                $category_name = $category_title_node->innertext;
            }

            foreach ($navigation_menu_node->find('div.arborescence-expand .wrapper-arborescence-level-2 a') as $subcategory_node) {
                $subcategories[] = array("name" => $subcategory_node->innertext, "link" => "https://www.mollat.com" . $subcategory_node->href);
            }


            foreach ($subcategories as $subcategory) {
                $html = file_get_html($subcategory["link"]);
                foreach ($html->find("section.bloc .bloc-content .row:nth-child(2)") as $section_product) {
                    var_dump($section_product->innertext);
                }
            }

            $datas[] = array($category_name => array("subcategories" => $subcategories));

            sleep(1);
        }




        return $datas;
    }
}



$scrapper = new Scrapper("https://www.mollat.com/");

$scrapper->getDatas();
