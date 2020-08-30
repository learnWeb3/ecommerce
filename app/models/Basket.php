<?php

class Basket
{

    protected $user_id;
    protected $book_id;
    protected $state_id;

    use Db;


    public function getUserId()
    {
        return intval($this->user_id);
    }

    public function getBookId()
    {
        return intval($this->book_id);
    }

    public function getStateId()
    {
        return intval($this->state_id);
    }


    public function getContent()
    {
        $connection = 
        $statement = "SELECT * FROM baskets 
            JOIN users ON baskets.user_id=users.id 
            JOIN books ON books.id=baskets.book_id 
            JOIN states ON states.id=baskets.state_id 
        WHERE states.name = 'current'";

        
    }
}
