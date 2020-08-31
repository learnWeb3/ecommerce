<?php


class HomeController extends ApplicationController
{
    public function index()
    {

        $book_most_recent_limit = (isset($_POST["book_most_recent_limit"])) ? $_POST["book_most_recent_limit"] : 5;
        $book_most_recent_offset = (isset($_POST["book_most_recent_offset"])) ? $_POST["books_most_recent_offset"] : 0;

        $book_coup_de_coeur_limit = (isset($_POST["book_coup_de_coeur_limit"])) ? $_POST["book_coup_de_coeur_limit"] : 2;
        $book_coup_de_coeur_offset = (isset($_POST["book_coup_de_coeur_offset"])) ? $_POST["book_coup_de_coeur_offset"] : 0;


        $book_recommandation_limit = (isset($_POST["book_recommandation_limit"])) ? $_POST["book_recommandation_limit"] : 2;
        $book_recommandation_offset = (isset($_POST["book_recommandation_offset"])) ? $_POST["books_recommendation_offset"] : 0;

        $book_best_sales_limit = (isset($_POST["book_best_sales_limit"])) ? $_POST["book_best_sales_limit"] : 2;;
        $book_best_sales_offset =  (isset($_POST["book_best_sales_offset"])) ? $_POST["book_best_sales_offset"] : 0;

        $new_books =  Book::getMostRecentBoooks($book_most_recent_limit, $book_most_recent_offset);

        $recommended_books = Book::getRecommendations($book_recommandation_limit, $book_recommandation_offset);

        $coup_de_coeur_books = Book::getCoupDeCoeur($book_coup_de_coeur_limit, $book_coup_de_coeur_offset);

        $best_sales_books = Book::getPopular($book_best_sales_limit, $book_best_sales_offset);


        $this->render(
            "index",
            "La Nuit des temps ",
            "Bienvenue à La Nuit des temps: livres anciens et d'occasion, esprit miliatant et engagé",
            array(
                "new_books" => $new_books,
                "recommended_books" => $recommended_books,
                "coup_de_coeur_books" => $coup_de_coeur_books,
                "best_sales_books" => $best_sales_books,
            )
        );
    }
}
