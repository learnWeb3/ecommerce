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
        if (func_get_args() != null) {
            $this->user_id = $user_id;
            $this->state_id = $state_id;
            $this->basket_items = $basket_items;
        }
        parent::__construct($id, $created_at, $updated_at);
    }

    // SETTER FOR BASKET ITEMS ATTRIBUTE
    public function setBasketItems($basket_items)
    {
        $this->basket_items = $basket_items;
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
}
