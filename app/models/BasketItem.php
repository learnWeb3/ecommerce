<?php

class BasketItem extends DbRecords
{
    // ATTRIBUTES
    protected $book_id;
    protected $basket_id;
    protected $quantity;


    // CONSTRUCTOR
    public function __construct($book_id = null, $basket_id = null, $quantity = null, $id = null, $created_at = null, $updated_at = null)
    {
        if ($book_id != null) {
            $this->book_id = $book_id;
        }

        if ($basket_id != null) {
            $this->basket_id = $basket_id;
        }

        if ($quantity != null) {
            $this->quantity = $quantity;
        }
        
        parent::__construct($id, $created_at, $updated_at);
    }

    // GET USER ID
    public function getBasketId()
    {
        return intval($this->basket_id);
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
    private function setQuantity($quantity)
    {
        $this->quantity = $quantity;
        return $this;
    }


}
