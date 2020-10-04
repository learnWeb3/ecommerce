<?php


class BookController extends ApplicationController
{

    public function index()
    {

        if (isset($_GET['user_filter'], $_GET["user_input"], $_GET["order_by"], $_GET['order'])) {
            $search_filters = "&user_filter=" . $_GET['user_filter'] . "&user_input=" . $_GET['user_input'] . "&order_by=" . $_GET['order_by'] . "&order=" . $_GET['order'];
            $search_engine = new SearchEngine($_GET['user_filter'], $_GET["user_input"], $_GET["order_by"], $_GET['order']);
        } elseif (isset($_GET["category_id"], $_GET['price_min'], $_GET['price_max'], $_GET["order_by"])) {
            $search_engine = new SearchEngine("", "", $_GET["order_by"], "DESC", 20, 0, $_GET['price_min'], $_GET['price_max'], $_GET["category_id"]);
            $search_filters = "&price_min=" . $_GET['price_min'] . "&price_max=" . $_GET['price_max'] . "&order_by=" . $_GET['order_by'] . "&category_id=" . $_GET["category_id"];
        } else {
            $search_engine = new SearchEngine("book_title", "");
            $search_filters = "";
        }
        $start = isset($_POST['start']) ? $_POST['start'] : 0;

        if (isset($_POST['next_page'])) {
            $search_engine->getNextPage($start);
            $start += 20;
        }
        if (isset($_POST['previous_page'])) {
            $search_engine->getPreviousPage($start);
            $start -= 20;
        }

        $books = $search_engine->getSearchresult();

        $this->render("index", "La Nuit des temps: les produits", "Livres neufs et d'occasion pour tous les âges, tous les goûts, et toutes les bourses", ["books" => $books, "start" => $start, "search_filters" => $search_filters]);
    }

    public function show()
    {
        if (isset($_GET['id'])) {
            $book = Book::find($_GET['id']);
            $book[0]->incrementViewCount();
            if (empty($book)) {
                renderErrror(404);
            } else {
                $page_book = $book[0];
                $similar_products = Book::searchBy("book_category_id", $page_book->getCategoryId(), 20, 0, "book_created_at", "DESC");
                $this->render("show", $page_book->getTitle(), "La nuit des temps, librairie engagée de proximitée: voir le détails du produit", array("page_book" => $page_book, "similar_products" => $similar_products));
            }
        } else {
            renderErrror(403);
        }
    }

    public function create()
    {

        if (isset($_POST["product_title"],  $_POST["product_author"],  $_POST["product_collection"],  $_POST["product_price"],  $_POST["product_year"],  $_POST["product_description"], $_POST['product_category_id'])) {
            if (!empty($_POST["product_title"]) && !empty($_POST['product_author']) && !empty($_POST["product_collection"]) && !empty($_POST["product_price"]) && !empty($_POST["product_year"]) && !empty($_POST["product_description"])) {

                if (isset($_POST["product_image_upload"])) {
                    try {
                        $image_path = Book::uploadImage("product_image_upload");
                    } catch (Exception $e) {
                        $message = [$e->getMessage()];
                        $type = "danger";
                    }
                } else {
                    $image_path = $_POST["product_image_url"];
                }

                if (!isset($message)) {

                    // DATABASE CREATION
                    $book = new Book($_POST["product_title"],  $_POST["product_author"],  $_POST["product_collection"],  $_POST["product_price"],  $_POST["product_year"], $image_path,  $_POST["product_description"], intval($_POST['product_category_id']));
                    $book->create();

                    // STRIPE CREATION
                    $book->setStripeProductId();
                    $price_value = ceil($book->getPrice()) * 100;
                    $book->setStripePriceId($price_value);
                    $book->createStripeDetails();

                    // USER ALERT
                    $message = ["Produit ajouté avec succès"];
                    $type = "success";
                }
            } else {
                $message = ["Veuillez remplir l'ensemble des champs demandés"];
                $type = "info";
            }
        } else {
           renderErrror(403);
        }

        $alert = new Flash($message, $type);

        $alert->storeInSession();

        $path = "controller=admin&method=index";

        header("Location:" . REDIRECT_BASE_URL . $path);
    }
}
