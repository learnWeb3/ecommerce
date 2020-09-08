<?php


class BookController extends ApplicationController
{

    public function index()
    {

        if (isset($_POST['user_filter'], $_POST["user_input"], $_POST["order_by"], $_POST['order'])) {
            $search_engine = new SearchEngine($_POST['user_filter'], $_POST["user_input"], $_POST["order_by"], $_POST['order']);
        } elseif (isset($_POST["category_id"], $_POST['price_min'], $_POST['price_max'], $_POST["order_by"], $_POST['order'])) {
            $search_engine = new SearchEngine("", "", $_POST["order_by"], $_POST['order'], 20, 0, $_POST['price_min'], $_POST['price_max'], $_POST["category_id"]);
        } else {
            $search_engine = new SearchEngine("book_title", "");
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

        $this->render("index", "La Nuit des temps: les produits", "Livres neufs et d'occasion pour tous les âges, tous les goûts, et toutes les bourses", ["books" => $books, "start" => $start]);
    }

    public function show()
    {
        if (isset($_GET['id'])) {
            $book = Book::find($_GET['id']);
            if (empty($book)) {
                renderErrror(404);
            } else {
                $book = $book[0];
                $this->render("show", $book->getTitle(), "La nuit des temps, librairie engagée de proximitée: voir le détails du produit", array("book" => $book));
            }
        } else {
            renderErrror(403);
        }
    }
}
