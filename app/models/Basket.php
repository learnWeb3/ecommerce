<?php

class Basket extends DbRecords
{
    // ATTRIBUTES
    protected $user_id;
    protected $book_id;
    protected $state_id;
    protected $quantity;

    // CONSTRUCTOR
    public function __construct($user_id = null, $book_id = null, $state_id = null, $quantity = null, $id = null, $created_at = null, $updated_at = null)
    {
        if (func_get_args() != null) {
            $this->user_id = $user_id;
            $this->book_id = $book_id;
            $this->state_id = $state_id;
            $this->quantity = $quantity;
        }
        parent::__construct($id, $created_at, $updated_at);
    }

    // GET USER ID
    public function getUserId()
    {
        return intval($this->user_id);
    }

    // GET BOOK ID 
    public function getBookId()
    {
        return intval($this->book_id);
    }

    // GET STATE ID
    public function getStateId()
    {
        return intval($this->state_id);
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

    // SET NEW STATE ID 
    private function setStateId($state_id)
    {
        $this->state_id = $state_id;
        return $this;
    }

    // FIND BASKET IN DATABASE FOR A SPECIFIC USER AND PRODUCT
    private static function findBasket($book_id, $user_id)
    {
        $connection = Db::connect();
        $statement = "SELECT * FROM baskets WHERE book_id=? AND user_id=? ORDER BY created_at DESC LIMIT 1";
        $prepared_statement = $connection->prepare($statement);
        $prepared_statement->execute(array($book_id, $user_id));
        $basket = $prepared_statement->fetchAll(PDO::FETCH_CLASS, __CLASS__)[0];
        return $basket;
    }


    // ADD PRODUCT IN BASKET
    public function addProduct($user_id, $book_id, $state_id, $quantity = 1)
    {
        $basket = new Basket($user_id, $book_id, $state_id, $quantity);
        return $basket->create();
    }

    // REMOVE PRODUCT FROM BASKET (ERASE IT)
    public function removeProduct($user_id, $book_id)
    {
        $basket = Basket::findBasket($book_id, $user_id);

        return $basket->destroy();
    }

    // CHANGE STATE OF BASKET (USEFUL FOR MANAGEMENT OF ORDERS AND INVOICES LATER ON THE BUYING PROCESS)
    public function changeState($book_id, $user_id, $state_id)
    {
        $basket = Basket::findBasket($book_id, $user_id);
        $basket = $basket->setStateId($state_id);
        return $basket->update();
    }

    // UDPATE QUANTITY OF A PRODUCT IN BASKET
    public function updateQuantity($user_id, $book_id, $quantity)
    {
        $basket = Basket::findBasket($book_id, $user_id);
        if ($quantity > 0) {
            $basket = $basket->setQuantity($quantity);
            return $basket->update();
        } else {
            $basket->destroy();
        }
    }
}
