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

    
            // if (isset($_POST["remote"])) {
            // } else {
            // }
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


            // if (isset($_POST["remote"])) {
            // } else {
            // }
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


                $basket_prepared_json = $basket->
                echo json_encode();

            } else {

            }
        } else {
        }
    }
}
