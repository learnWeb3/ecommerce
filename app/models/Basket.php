<?php

class Basket extends DbRecords
{
    // ATTRIBUTES
    protected $user_id;
    protected $state_id;
    protected $basket_items = [];



    // CONSTRUCTOR
    public function __construct($user_id = null, $state_id = null, $basket_items = null, $id = null, $created_at = null, $updated_at = null)
    {

        if ($user_id != null) {
            $this->user_id = $user_id;
        }

        if ($state_id != null) {
            $this->state_id = $state_id;
        }

        if ($basket_items != null) {
            $this->basket_items = $basket_items;
        }
        parent::__construct($id, $created_at, $updated_at);
    }

    // SETTER FOR BASKET ITEMS ATTRIBUTE
    public function setBasketItems(array $basket_items): object
    {
        $this->basket_items = $basket_items;
        return $this;
    }

    // SETTER FOR BASKET ITEMS ATTRIBUTE
    public function setUserId($user_id): object
    {
        $this->user_id = $user_id;
        return $this;
    }


    // BASKET ITEMS IS AN ARRAY OF OBJECT OF CLASSE BASKETITEMS SO MERGING NEW ITEMS WITH PREVIOUS ONES
    public function addProduct(array $new_products)
    {
        $basket_items = array_merge($this->basket_items, $new_products);
        $this->setBasketItems($basket_items);
        return $this;
    }

    // BASKET ITEMS IS AN ARRAY OF OBJECT OF CLASSE BASKETITEMS SO GETTING DIFFERENCE BETWEEN BASKET CONTENT AND PRODUCT I WNAT TO REMOVE
    public function removeProduct(array $products)
    {
        $basket_items = array_diff($this->basket_items, $products);
        $this->setBasketItems($basket_items);
        return $this;
    }


    public static function getBasket()
    {
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

        return $basket;
    }


    public function getProduct($id)
    {

        $basket_items = $this->basket_items;
        $basket_items = array_filter($basket_items, function ($book_object) use ($id) {
            if ($book_object->getId() == $id) {
                return true;
            } else {
                return false;
            }
        });

        if (empty($basket_items)) {
            return false;
        } else {
            return $basket_items[0];
        }
    }

    public function updateItem($book_id, $quantity)
    {
        $basket_item = $this->getProduct($book_id);
        $basket_item = $basket_item->setQuantity($quantity);

        $basket_items = $this->basket_items;


        $non_updated_items = array_diff($basket_items, array($basket_item));

        $basket_items = array_merge($non_updated_items, array($basket_item));

        return $this->setBasketItems($basket_items);
    }


    public function storeInSession()
    {
        $_SESSION['basket'] = $this;
        return $this;
    }

}
