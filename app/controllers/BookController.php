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
            if (empty($book)) {
                renderError(404);
            } else {
                $book[0]->incrementViewCount();
                $page_book = $book[0];
                $similar_products = Book::searchBy("book_category_id", $page_book->getCategoryId(), 20, 0, "book_created_at", "DESC");
                $this->render("show", $page_book->getTitle(), "La nuit des temps, librairie engagée de proximitée: voir le détails du produit", array("page_book" => $page_book, "similar_products" => $similar_products));
            }
        } else {
            renderError(403);
        }
    }

    public function create()
    {

        if (isset($_POST["product_title"], $_POST['product_category_id'], $_POST["product_author"],  $_POST["product_collection"],  $_POST["product_price"],  $_POST["product_publication_date"],  $_POST["product_description"], $_POST['book_tva_id'], $_POST['product_quantity'])) {

            if (!empty($_POST["product_title"]) && !empty($_POST['product_author']) && !empty($_POST["product_collection"]) && !empty($_POST["product_price"]) && !empty($_POST["product_publication_date"]) && !empty($_POST["product_description"]) && !empty( $_POST['book_tva_id']) && !empty($_POST['product_quantity'])) {

                if (isset($_FILES["product_image_upload"])) {
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
                    $book = new Book($_POST["product_title"],  $_POST["product_author"],  $_POST["product_collection"],  $_POST["product_price"],  $_POST["product_publication_date"], $image_path,  $_POST["product_description"], intval($_POST['product_category_id']), intval( $_POST['book_tva_id']));

                    $book = $book->create();

                    // // STRIPE CREATION
                    $book->setStripeProductId();
                    $price_value = ceil($book->getPrice()) * 100;
                    $book->setStripePriceId($price_value);
                    $book->createStripeDetails();
                    $book->setStock(intval($_POST['product_quantity']));

                    // USER ALERT
                    $message = ["Produit ajouté avec succès"];
                    $type = "success";
                }
            } else {
                $message = ["Veuillez remplir l'ensemble des champs demandés"];
                $type = "info";
            }
        } else {
           renderError(403);
        }

        $alert = new Flash($message, $type);

        $alert->storeInSession();

        $path = "controller=admin&method=index";

        header("Location:" . REDIRECT_BASE_URL . $path);
    }
}
