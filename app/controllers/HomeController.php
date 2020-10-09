<?php


class HomeController extends ApplicationController
{
    public function index()
    {

        $new_books =  Book::getMostRecentBoooks(20, 0);

        $recommended_books = Book::getRecommendations(2, 0);

        $coup_de_coeur_books = Book::getCoupDeCoeur(2,0);

        $best_sales_books = Book::getPopular(20, 0);

        $most_viewed = Book::getMostViewed(20,0);

        $popular_books = array_merge($most_viewed,$best_sales_books);

        $this->render(
            "index",
            "La Nuit des temps ",
            "Bienvenue à La Nuit des temps: livres anciens et d'occasion, esprit miliatant et engagé",
            array(
                "new_books" => $new_books,
                "recommended_books" => $recommended_books,
                "coup_de_coeur_books" => $coup_de_coeur_books,
                "popular_books" => $popular_books
            )
        );




        // var_dump(Basket::getBasket());
    }
}
