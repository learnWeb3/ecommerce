<?php

class BasketItem
{
    // ATTRIBUTES
    protected $book_id;
    protected $basket_id;
    protected $quantity;

    // USING COMMON METHODS
    use Db;

    // CONSTRUCTOR
    public function __construct($book_id = null, $basket_id = null, $book = null, $quantity = 1, $id = null, $created_at = null, $updated_at = null)
    {
        if ($book_id != null) {
            $this->book_id = $book_id;
        }

        if ($book != null) {
            $this->book = $book;
        }

        if ($basket_id != null) {
            $this->basket_id = $basket_id;
        }

        $this->quantity = $quantity;

        if ($id != null) {
            $this->id = $id;
        }

        if ($created_at != null) {
            $this->created_at = $created_at;
        }

        if ($updated_at != null) {
            $this->updated_at = $updated_at;
        }
    }

    // GET USER ID
    public function getBasketId()
    {
        return intval($this->basket_id);
    }

    // GET USER ID
    public function getBook()
    {
        return $this->book;
    }


    public function setBook(object $book)
    {
        $this->book = $book;
        return $this;
    }
    // GET BOOK ID 
    public function getBookId()
    {
        return intval($this->book_id);
    }

    // GET QUANTITY
    public function getQuantity()
    {
        return intval($this->quantity);
    }


    // SET NEW QUANTITY
    public  function setQuantity($quantity)
    {
        $this->quantity = $quantity;
        return $this;
    }
}
