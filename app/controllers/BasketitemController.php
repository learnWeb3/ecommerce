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
            $book = Book::find($book_id);
            if (empty($book)) {
                return renderErrror(404);
            } else {
                $book = $book[0];
            }

            // CONSTRUCTING PROPER BASKETITEM OBJECT 
            $basket_items = array(new BasketItem($book_id));

            // LINKING BASKET TO BASKETITEM AND RETURNING UDPATED BASKET
            $basket = $basket->addProduct($basket_items);

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

            // GETTING BOOK ID TO PASS IT AS PARAMETER OF CONSTRUCTOR OF BOOKITEM CLASS
            $book_id = intval($_POST['book_id']);
            $book = Book::find($book_id);
            if (empty($book)) {
                return renderErrror(404);
            } else {
                $book = $book[0];
            }

            $basket_items =  array(new BasketItem($book_id));
            $basket = $basket->removeProduct($basket_items);

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


            // if (isset($_POST["remote"])) {

            // } else {
            // }
        } else {
        }
    }
}
