

<?php

class RecommendationController extends ApplicationController
{
    public function index()
    {

        $view_name = 'index';
        $title = "La Nuit des temps: les recommandations";
        $description =  "Tous les mois: retrouvez nos recommandations et coup de coeurs séléctionné avec amours par nos experts";

        if (isset($_GET['book'])) {
            if ($_GET['book'] == "recommended") {
                $recommended_books = Book::getRecommendations(100, 0);
                $datas =  array(
                    "recommended_books" => $recommended_books
                );
            } elseif ($_GET['book'] == "coup_de_coeur") {
                $coup_de_coeur_books = Book::getCoupDeCoeur(100, 0);
                $datas =  array(
                    "coup_de_coeur_books" => $coup_de_coeur_books
                );
            }
        } else {
            renderError(404);
        }

        $this->render(
            $view_name,
            $title,
            $description,
            $datas
        );
    }
}
