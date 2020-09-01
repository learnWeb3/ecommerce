<?php

class BasketitemController
{
    public function create()
    {

        if (isset($_POST['book_id'])) {

            $book_id = intval($_POST['book_id']);
            $book = Book::find($book_id);

            if( empty($book))
            {
                return renderErrror(404);
            }
            if (isset($_POST["remote"])) {

            } else {


            }
        }else{
            
        }
    }
}
