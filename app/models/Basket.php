<?php 

class Basket
{

    protected $user_id;
    protected $book_id;
    protected $sate_id;

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
        
    }


}