<?php

class Basket extends DbRecords
{

    protected $user_id;
    protected $book_id;
    protected $state_id;
    protected $quantity;


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

    public function getQuantity()
    {
        return intval($this->quantity);
    }

    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
        return $this;
    }


    private static function findBasket($book_id, $user_id)
    {
        $connection = Db::connect();
        $statement = "SELECT * FROM baskets WHERE book_id=? AND user_id=? ORDER BY created_at DESC LIMIT 1";
        $prepared_statement = $connection->prepare($statement);
        $prepared_statement->execute(array($book_id, $user_id));
        $basket = $prepared_statement->fetchAll(PDO::FETCH_CLASS, __CLASS__)[0];
        return $basket;
    }



    public function addProduct($user_id, $book_id, $state_id, $quantity = 1)
    {
        $basket = new Basket($user_id, $book_id, $state_id, $quantity);
        return $basket->create();
    }


    public function removeProduct($user_id, $book_id)
    {
        $basket = Basket::findBasket($book_id, $user_id);

        return $basket->destroy();
    }


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
