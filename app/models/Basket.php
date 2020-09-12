<?php

require_once 'BasketItem.php';

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


    public function getBasketItems()
    {
        return $this->basket_items;
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
    public function addProduct(int $book_id)
    {
        $book_in_basket_ids = array_map(function ($basket_item_obj) {
            return $basket_item_obj->getBook()->getId();
        }, $this->basket_items);

        if (in_array($book_id, $book_in_basket_ids)) {
            $quantity = $this->getProduct($book_id)->getQuantity() + 1;
            $this->updateItem($book_id, $quantity);
        } else {
            $book = Book::find($book_id)[0];
            $this->basket_items[] = new BasketItem($book_id, null, $book);
        }

        return $this;
    }

    public function removeProduct(int $old_product_id)
    {
        $this->basket_items = array_filter($this->basket_items, function ($basket_item_obj) use ($old_product_id) {
            if ($basket_item_obj->getBookId() == $old_product_id) {
                return false;
            } else {
                return true;
            }
        });
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


    public function getAllProducts()
    {
        return $this->basket_items;
    }


    public function getBasketItemNumber()
    {
        return count($this->basket_items);
    }

    public function getProduct($id)
    {

        $basket_items = $this->basket_items;
        $basket_items = array_filter($basket_items, function ($book_object) use ($id) {
            if ($book_object->getBookId() == $id) {
                return true;
            } else {
                return false;
            }
        });


        if (empty($basket_items)) {
            return false;
        } else {
            return array_values($basket_items)[0];
        }
    }

    public function updateItem($book_id, $quantity)
    {
        $basket_item = $this->getProduct($book_id);
        $basket_item = $basket_item->setQuantity($quantity);

        $basket_items = $this->basket_items;

        return $this->setBasketItems($basket_items);
    }


    public function getLastProduct()
    {
        return $this->basket_items[count($this->basket_items) - 1];
    }


    public function storeInSession()
    {
        $_SESSION['basket'] = $this;
        return $this;
    }


    public function empty()
    {
        return (empty($this->basket_items) == true);
    }

    public function notEmpty()
    {
        return (empty($this->basket_items) == false);
    }


    public function getTotalTTC()
    {
        $total_ttc = array_sum(array_map(function ($el) {
            return $el->getBook()->getPrice() * $el->getQuantity();
        }, $this->basket_items));
        return number_format($total_ttc, 2);
    }

    public function getTotalHT()
    {
        $total_ht = array_sum(array_map(function ($el) {
            return $el->getBook()->getHtPrice() * $el->getQuantity();
        }, $this->basket_items));

        return number_format($total_ht, 2);
    }

    //  $products =[
    // [
    //     'price' => $price_id,
    //     'quantity' => $quantity,
    //   ],
    // ]
    public function checkout()
    {
        $products = $this->getBasketItems();

        return array_map(function ($el) {
            return  array(
                'price' => $el->getBook()->getStripePriceId(),
                'quantity' => $el->getQuantity()
            );
        }, $products);
    }


    public function getPriceZoneDisplay()
    {
        if ($this->notEmpty()) {
            return "block";
        } else {
            return "none";
        }
    }

    public function getWantedQuantity(int $book_id)
    {
        $basket_item = $this->getProduct($book_id);
        return  $basket_item != false ?  $basket_item->getQuantity() + 1 : 1;
    }


    public static function findCurrentOwnerBasket(int $owner_id, string $basket_state_name)
    {
        // database query 
        $connection = Db::connect();
        $statement = "SELECT basket_items.*
        FROM baskets 
        JOIN basket_items ON basket.id=basket_items.basket_id 
        JOIN states ON states.id=baskets.state_id WHERE user_id=? AND states.name=?";
        $prepared_statement = $connection->prepare($statement);
        $prepared_statement->execute(array($owner_id, $basket_state_name));

        // initlaizing empty aray to store basketItems fetched
        $basketItems = [];

        // fetching all basketItems registered for a specific basket
        while ($row = $prepared_statement->fetch()) {
            if (!empty($row["book_id"])) {
                $book = Book::find(intval($row["book_id"]))[0];
                $basketItems[] = new BasketItem($row["book_id"], $row["basket_id"], $book, $row["quantity"], $row['id'], $row['created_at'], $row['updated_at']);
            }
        }

        // constructing instance of basket
        if (!empty($basketItems)) {
            return  new Basket($owner_id, $basket_state_name, $basketItems, $basketItems[0]->getBasketId());
        } else {
            return new Basket();
        }
    }
}
