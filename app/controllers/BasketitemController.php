<?php

class BasketitemController
{
    public function create()
    {

        if (isset($_POST['book_id'])) {

            // INITIALIZING QUANTITY BASKETITEM ATTRIBUTE TO 1
            $quantity = 1;

            // LOOKING FOR EXISTING BASKET IN SESSION
            if (isset($_SESSION['basket'])) {
                $basket = $_SESSION['basket'];
            } else {
                $basket = new Basket();
            }

            // IF USER SIGNED IN ADDING ATTRIBUTE USER_ID TO BASKET FOR LATER DATABASE REGISTRATION
            if (isset($_SESSION['current_user'])) {
                $user = $_SESSION['current_user'];
                $basket->setUserId($user->getId());
            }

            // GETTING BOOK ID TO PASS IT AS PARAMETER OF CONSTRUCTOR OF BOOKITEM CLASS
            $book_id = intval($_POST['book_id']);
            $book = Book::find($book_id);
            if (empty($book)) {
                return renderErrror(404);
            } else {
                $book = $book[0];
            }

            // CONSTRUCTING PROPER BASKETITEM OBJECT 
            $basket_items = array(new BasketItem($book_id, $quantity));

            // LINKING BASKET TO BASKETITEM
            $basket->setBasketItems($basket_items);

            if (isset($_POST["remote"])) {
            } else {
            }
        } else {
        }
    }

    public function destroy()
    {
        
        if (isset($_POST['book_id'])) {

            if (isset($_POST["remote"])) {
            } else {
            }
        } else {


        }

    }
}
