<?php 


class HomeController extends ApplicationController
{
    public function index()
    {

        $new_books = 
        $this->render(
            "index", "La Nuit des temps ", "Bienvenue à La Nuit des temps: livres anciens et d'occasion, esprit miliatant et engagé", 
            array(
                "new_books"=>$new_books,
                "recommended_books"=>$recommended_books
            )
        );
    }
}