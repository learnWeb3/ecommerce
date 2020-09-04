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


            // LINKING BASKET TO BASKETITEM AND RETURNING UDPATED BASKET
            $basket = $basket->addProduct($book_id);

            $basket->storeInSession();


            if (isset($_POST["remote"])) {

                $basket = Basket::getBasket();
                $added_product = $basket->getProduct($book_id);
                $added_product = array(
                    "book_id" => $added_product->getBook()->getId(),
                    "book_title" => $added_product->getBook()->getTitle(),
                    "book_image_path" => $added_product->getBook()->getImagePath(),
                    "book_price" => $added_product->getBook()->getPrice(),
                    "book_quantity" => $added_product->getQuantity(),
                    "basket_total_HT" => $basket->getTotalHT(),
                    "basket_total_TTC" => $basket->getTotalTTC()
                );

                echo json_encode($added_product);
                die();
            } else {
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


            $basket = $basket->updateItem($book_id, $quantity);

            $basket->storeInSession();


            if (isset($_POST["remote"])) {

                echo json_encode(array(
                    "book_id" => $book_id, "quantity" => $quantity,
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
}
