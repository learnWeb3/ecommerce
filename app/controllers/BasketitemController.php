<?php

class BasketitemController
{
    public function create()
    {

        if (isset($_POST['book_id'])) {

            // GETTING APPROPRIATE BASKET
            $basket = Basket::getBasket();

            // GETTING BOOK ID TO PASS IT AS PARAMETER OF CONSTRUCTOR OF BOOKITEM CLASS
            $book_id = intval($_POST['book_id']);


            $requested_book = Book::find($book_id)[0];

            // fetching book quantity available to display it to user
            $book_available_quantity = $requested_book->getStock();
           
            $quantity = $basket->getWantedQuantity($book_id);
            // CHECKING IF BOOK IS AVAILABLE FOR THE REQUESTED QUANTITY
            $book_available = $requested_book->checkAvailable($quantity);

            if ($book_available) {
                // LINKING BASKET TO BASKETITEM AND RETURNING UDPATED BASKET
                $basket = $basket->addProduct($book_id);
                $basket->storeInSession();
            } else {
                // message alerte utilisateur no ajax
            }

            if (isset($_POST["remote"]) && $book_available) {

                $basket = Basket::getBasket();
                $added_product = $basket->getProduct($book_id);
                $added_product = array(
                    "book_id" => $added_product->getBook()->getId(),
                    "book_title" => $added_product->getBook()->getTitle(),
                    "book_image_path" => $added_product->getBook()->getImagePath(),
                    "book_price_ht" => $added_product->getBook()->getHtPrice(),
                    "book_price_ttc" => $added_product->getBook()->getPrice(),
                    "book_quantity" => $added_product->getQuantity(),
                    "basket_total_HT" => $basket->getTotalHT(),
                    "basket_total_TTC" => $basket->getTotalTTC()
                );

                echo json_encode($added_product);
                die();
            } else if (isset($_POST["remote"]) && !$book_available) {
                $message = $book_available_quantity > 0 ? "Plus que $book_available_quantity exemplaire(s) disponible(s)" : "Le livre souhaité n'est plus disponible";
                $book_not_available = array("book_not_available" => $message);
                echo json_encode($book_not_available);
                die();
            }
        } else {
        }
    }

    public function destroy()
    {

        if (isset($_POST['book_id'])) {

            // GETTING APPROPRIATE BASKET
            $basket = Basket::getBasket();
            $book_id = intval($_POST['book_id']);

            // GETTING BOOK ID TO PASS IT AS PARAMETER OF CONSTRUCTOR OF BOOKITEM CLASS

            $basket = $basket->removeProduct($book_id);

            $basket->storeInSession();

            if (isset($_POST["remote"])) {

                echo json_encode(array(
                    "book_id" => $book_id,
                    "message" => "Panier mis à jour avec succès",
                    "basket_total_HT" => $basket->getTotalHT(),
                    "basket_total_TTC" => $basket->getTotalTTC()
                ));
                die();
            } else {
            }
        } else {
        }
    }


    public function update()
    {
        if (isset($_POST['book_quantity'], $_POST['book_id'])) {

            // GETTING APPROPRIATE BASKET
            $basket = Basket::getBasket();

            $book_id = intval($_POST['book_id']);
            $quantity = intval($_POST['book_quantity']);

            $requested_book = Book::find($book_id)[0];

            // fetching book quantity available to display it to user
            $book_available_quantity = $requested_book->getStock();

            // CHECKING IF BOOK IS AVAILABLE FOR THE REQUESTED QUANTITY
            $book_available = $requested_book->checkAvailable($quantity);

            if ($book_available) {
                $basket = $basket->updateItem($book_id, $quantity);

                $basket->storeInSession();
            }


            if (isset($_POST["remote"]) && $book_available) {

                echo json_encode(array(
                    "book_id" => $book_id, "quantity" => $quantity,
                    "message" => "Panier mis à jour avec succès",
                    "basket_total_HT" => $basket->getTotalHT(),
                    "basket_total_TTC" => $basket->getTotalTTC()
                ));
                die();
            } else if (isset($_POST["remote"]) && !$book_available) {
                $message = $book_available_quantity > 0 ? "Plus que $book_available_quantity exemplaire(s) disponible(s)" : "Le livre souhaité n'est plus disponible";
                $book_not_available = array("book_not_available" => $message);
                echo json_encode($book_not_available);
                die();
            }
        } else {
        }
    }
}
