<?php


class BookController extends ApplicationController
{

    public function index()
    {
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
