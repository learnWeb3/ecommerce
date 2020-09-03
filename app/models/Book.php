<?php

class Book extends DbRecords
{

    // ATTRIBUTES
    protected $title;
    protected $author;
    protected $collection;
    protected $price;
    protected $publication_year;
    protected $image_path;
    protected $description;
    protected $category_id;
    protected $tva_id;
    protected $ht_price;


    // CONSTRUCTOR
    public function __construct($title = null, $author = null, $collection = null, $price = null, $publication_year = null, $image_path = null, $description = null, $category_id = null, $tva_id = null, $id = null, $created_at = null, $updated_at = null)
    {
        if (func_get_args() != null) {
            $this->title = $title;
            $this->author = $author;
            $this->collection = $collection;
            $this->price = $price;
            $this->publication_year = $publication_year;
            $this->image_path = $image_path;
            $this->description = $description;
            $this->category_id = $category_id;
            $this->tva_id = $tva_id;
        }

        parent::__construct($id, $created_at, $updated_at);
    }


    public function getTitle()
    {
        return htmlspecialchars($this->title);
    }

    public function setTitle(string $title)
    {
        $this->title = $title;
        return $this;
    }

    public function getAuthor()
    {
        return htmlspecialchars($this->author);
    }

    public function setAuthor($author)
    {
        $this->author = $author;
        return $this;
    }


    public function getCollection()
    {
        return htmlspecialchars($this->collection);
    }

    public function setCollection(string $collection)
    {
        $this->collection = $collection;
        return $this;
    }


    public function getPrice()
    {
        return floatval($this->price);
    }

    public function setPrice(int $price)
    {
        $this->price = floatval($price);
        return $this;
    }



    public function getPublicationYear()
    {
        return strftime("%Y",  strtotime($this->publication_year));
    }

    public function setPublicationYear(int $publication_year)
    {
        $this->publication_year = $publication_year;
        return $this;
    }

    public function getImagePath()
    {
        return htmlspecialchars($this->image_path);
    }

    public function setImagePath(string $image_path)
    {
        $this->image_path = $image_path;
        return $this;
    }

    public function getDescription()
    {
        return htmlspecialchars($this->description);
    }

    public function setDescription(string $description)
    {
        $this->description = $description;
        return $this;
    }

    public function getCategoryId()
    {
        return intval($this->category_Id);
    }


    private function getTvaId()
    {
        return intval($this->tva_id);
    }


    public function getTva()
    {
        $connection = Db::connect();
        $statement = "SELECT * FROM tva WHERE id=?";

        $prepared_statement = $connection->prepare($statement);
        $prepared_statement->execute(array($this->getTvaId()));
        return floatval($prepared_statement->fetchAll(PDO::FETCH_ASSOC)[0]["value"]);
    }


    public function getHtPrice()
    {
        $this->ht_price = number_format($this->price * (1-$this->getTva()),2);
        return $this->ht_price;
    }


    public function setCategoryId(int $category_Id)
    {
        $this->category_Id = $category_Id;
        return $this;
    }


    public static function getMostRecentBoooks(int $limit, int $offset)
    {

        if (!self::checkLimitAndOffset($limit, $offset)) {
            return false;
        }

        $connection = Db::connect();
        $statement =
            "SELECT 
               books.id as book_id,
        books.created_at as book_created_at,
        books.updated_at as book_updated_at,
        books.title as book_title,
        books.author  as book_author,
        books.collection as book_collection,
        books.price as book_price,
        books.publication_year as book_year,
        books.category_id as book_category_id,
        books.image_path as book_image_path,
        books.description as book_description,
        books.tva_id as book_tva_id, 
        categories.name as category_name,
        categories.id as category_id,
        categories.created_at as category_created_at,
        categories.updated_at as category_updated_at
        FROM books 
        JOIN categories ON books.category_id = categories.id
        ORDER BY books.created_at DESC
        LIMIT $limit OFFSET $offset";
        $prepared_statement = $connection->prepare($statement);
        $prepared_statement->execute();
        $results = [];
        while ($row =  $prepared_statement->fetch()) {
            $results[] = array(
                "book" => new Book(
                    $row["book_title"],
                    $row["book_author"],
                    $row["book_collection"],
                    $row["book_price"],
                    $row["book_year"],
                    $row["book_image_path"],
                    $row["book_description"],
                    $row["book_category_id"],
                    $row["book_tva_id"],
                    $row["book_id"],
                    $row["book_created_at"],
                    $row["book_updated_at"]
                ),
                "category" => new Category($row["category_name"], $row["category_id"], $row["category_created_at"], $row["category_updated_at"])
            );
        }

        return $results;
    }


    public static function getRecommendations(int $limit, int $offset)
    {

        if (!self::checkLimitAndOffset($limit, $offset)) {
            return false;
        }

        $connection = Db::connect();
        $statement =
            "SELECT 
               books.id as book_id,
        books.created_at as book_created_at,
        books.updated_at as book_updated_at,
        books.title as book_title,
        books.author  as book_author,
        books.collection as book_collection,
        books.price as book_price,
        books.publication_year as book_year,
        books.category_id as book_category_id,
        books.image_path as book_image_path,
        books.description as book_description,
        books.tva_id as book_tva_id,  
        categories.name as category_name,
        categories.id as category_id,
        categories.created_at as category_created_at,
        categories.updated_at as category_updated_at
        FROM books 
        JOIN categories ON books.category_id = categories.id
        JOIN recommended_books ON recommended_books.book_id = books.id
        ORDER BY books.created_at DESC
        LIMIT $limit OFFSET $offset";
        $prepared_statement = $connection->prepare($statement);
        $prepared_statement->execute();
        $results = [];
        while ($row =  $prepared_statement->fetch()) {
            $results[] = array(
                "book" => new Book(
                    $row["book_title"],
                    $row["book_author"],
                    $row["book_collection"],
                    $row["book_price"],
                    $row["book_year"],
                    $row["book_image_path"],
                    $row["book_description"],
                    $row["book_category_id"],
                    $row["book_tva_id"],
                    $row["book_id"],
                    $row["book_created_at"],
                    $row["book_updated_at"]
                ),
                "category" => new Category($row["category_name"], $row["category_id"], $row["category_created_at"], $row["category_updated_at"])
            );
        }

        return $results;
    }


    public static function getCoupDeCoeur(int $limit, int $offset)
    {

        if (!self::checkLimitAndOffset($limit, $offset)) {
            return false;
        }

        $connection = Db::connect();
        $statement =
            "SELECT 
               books.id as book_id,
        books.created_at as book_created_at,
        books.updated_at as book_updated_at,
        books.title as book_title,
        books.author  as book_author,
        books.collection as book_collection,
        books.price as book_price,
        books.publication_year as book_year,
        books.category_id as book_category_id,
        books.image_path as book_image_path,
        books.description as book_description,
        books.tva_id as book_tva_id,  
        categories.name as category_name,
        categories.id as category_id,
        categories.created_at as category_created_at,
        categories.updated_at as category_updated_at,
        users.firstname as user_firstname,
        users.lastname as user_lastname,
        users.email as user_email,
        users.id as user_id,
        users.created_at as user_created_at
        users.udpated_at as user_updated_at
        FROM books 
        JOIN categories ON books.category_id = categories.id
        JOIN coup_de_coeur_books ON recommended_books.book_id = books.id
        JOIN users ON coups_de_coeur_books.user_id = users.id
        ORDER BY books.created_at DESC
        LIMIT $limit OFFSET $offset";
        $prepared_statement = $connection->prepare($statement);
        $prepared_statement->execute();
        $results = [];
        while ($row =  $prepared_statement->fetch()) {
            $results[] = array(
                "book" => new Book(
                    $row["book_title"],
                    $row["book_author"],
                    $row["book_collection"],
                    $row["book_price"],
                    $row["book_year"],
                    $row["book_image_path"],
                    $row["book_description"],
                    $row["book_category_id"],
                    $row["book_tva_id"],
                    $row["book_id"],
                    $row["book_created_at"],
                    $row["book_updated_at"]
                ),
                "category" => new Category($row["category_name"], $row["category_id"], $row["category_created_at"], $row["category_updated_at"]),
                "user" => new User($row["user_email"], null, $row["user_firstname"], $row["user_lastname"], null, $row["user_id"], $row["user_created_at"], $row["user_updated_at"])
            );
        }

        return $results;
    }


    public static function getPopular(int $limit, int $offset)
    {
        if (!self::checkLimitAndOffset($limit, $offset)) {
            return false;
        }

        $connection = Db::connect();
        $statement =
            "SELECT 
               books.id as book_id,
        books.created_at as book_created_at,
        books.updated_at as book_updated_at,
        books.title as book_title,
        books.author  as book_author,
        books.collection as book_collection,
        books.price as book_price,
        books.publication_year as book_year,
        books.category_id as book_category_id,
        books.image_path as book_image_path,
        books.description as book_description,
        books.tva_id as book_tva_id,  
        categories.name as category_name,
        categories.id as category_id,
        categories.created_at as category_created_at,
        categories.updated_at as category_updated_at,
        COUNT(books.id) as book_sales_count
        FROM books 
        JOIN categories ON books.category_id = categories.id
        JOIN basket_items ON basket_items.book_id = books.id
        JOIN baskets ON basket_items.basket_id = baskets.id
        JOIN orders ON orders.basket_id = baskets.id
        GROUP BY books.id
        LIMIT $limit OFFSET $offset
        ORDER BY book_sales_count DESC";
        $prepared_statement = $connection->prepare($statement);
        $prepared_statement->execute();
        $results = [];
        while ($row =  $prepared_statement->fetch()) {
            $results[] = array(
                "book" => new Book(
                    $row["book_title"],
                    $row["book_author"],
                    $row["book_collection"],
                    $row["book_price"],
                    $row["book_year"],
                    $row["book_image_path"],
                    $row["book_description"],
                    $row["book_category_id"],
                    $row["book_tva_id"],
                    $row["book_id"],
                    $row["book_created_at"],
                    $row["book_updated_at"]
                ),
                "category" => new Category($row["category_name"], $row["category_id"], $row["category_created_at"], $row["category_updated_at"]),
                "book_sales_count" => $row["book_sales_count"]
            );
        }

        return $results;
    }


    public static function searchBy(string $column_name, $value, int $limit, int $offset, string $order_column, string $order)
    {
        $authorized_values = array(
            "autorized_columns" => array(
                "book_id",
                "book_created_at",
                "book_updated_at",
                "book_title",
                "book_author",
                "book_collection",
                "book_price",
                "book_year",
                "book_category_id",
                "category_name"
            ),
            "authorized_order" => array("DESC", "ASC")
        );

        if (!self::checkLimitAndOffset($limit, $offset)) {
            return false;
        }
        if (!in_array($column_name, $authorized_values["authorized_columns"]) || !(in_array($order_column, $authorized_values["authorized_columns"])) || !in_array($order, $authorized_values["authorized_order"])) {
            return false;
        }

        $connection = Db::connect();
        $statement =
            "SELECT 
               books.id as book_id,
        books.created_at as book_created_at,
        books.updated_at as book_updated_at,
        books.title as book_title,
        books.author  as book_author,
        books.collection as book_collection,
        books.price as book_price,
        books.publication_year as book_year,
        books.category_id as book_category_id,
        books.image_path as book_image_path,
        books.description as book_description,
        books.tva_id as book_tva_id,  
        categories.name as category_name,
        categories.id as category_id,
        categories.created_at as category_created_at,
        categories.updated_at as category_updated_at
        FROM books 
        JOIN categories ON books.category_id = categories.id
        WHERE $column_name = ?
        LIMIT $limit OFFSET $offset
        ORDER BY $order_column $order";
        $prepared_statement = $connection->prepare($statement);
        $prepared_statement->execute(
            array($value)
        );
        $results = [];
        while ($row =  $prepared_statement->fetch()) {
            $results[] = array(
                "book" => new Book(
                    $row["book_title"],
                    $row["book_author"],
                    $row["book_collection"],
                    $row["book_price"],
                    $row["book_year"],
                    $row["book_image_path"],
                    $row["book_description"],
                    $row["book_category_id"],
                    $row["book_tva_id"],
                    $row["book_id"],
                    $row["book_created_at"],
                    $row["book_updated_at"]
                ),
                "category" => new Category($row["category_name"], $row["category_id"], $row["category_created_at"], $row["category_updated_at"]),
            );
        }

        return $results;
    }


    public static function searchLike(string $column_name, $value, int $limit, int $offset, string $order_column, string $order)
    {
        $authorized_values = array(
            "autorized_columns" => array(
                "book_title",
                "book_author",
                "book_collection",
                "category_name"
            ),
            "authorized_order" => array("DESC", "ASC")
        );

        if (!self::checkLimitAndOffset($limit, $offset)) {
            return false;
        }
        if (!in_array($column_name, $authorized_values["authorized_columns"]) || !(in_array($order_column, $authorized_values["authorized_columns"])) || !in_array($order, $authorized_values["authorized_order"])) {
            return false;
        }

        $connection = Db::connect();
        $statement =
            "SELECT 
               books.id as book_id,
        books.created_at as book_created_at,
        books.updated_at as book_updated_at,
        books.title as book_title,
        books.author  as book_author,
        books.collection as book_collection,
        books.price as book_price,
        books.publication_year as book_year,
        books.category_id as book_category_id,
        books.image_path as book_image_path,
        books.description as book_description,
        books.tva_id as book_tva_id,  
        categories.name as category_name,
        categories.id as category_id,
        categories.created_at as category_created_at,
        categories.updated_at as category_updated_at
        FROM books 
        JOIN categories ON books.category_id = categories.id
        WHERE $column_name LIKE ?
        LIMIT $limit OFFSET $offset
        ORDER BY $order_column $order";
        $prepared_statement = $connection->prepare($statement);
        $prepared_statement->execute(
            array("%" . $value . "%")
        );
        $results = [];
        while ($row =  $prepared_statement->fetch()) {
            $results[] = array(
                "book" => new Book(
                    $row["book_title"],
                    $row["book_author"],
                    $row["book_collection"],
                    $row["book_price"],
                    $row["book_year"],
                    $row["book_image_path"],
                    $row["book_description"],
                    $row["book_category_id"],
                    $row["book_tva_id"],
                    $row["book_id"],
                    $row["book_created_at"],
                    $row["book_updated_at"]
                ),
                "category" => new Category($row["category_name"], $row["category_id"], $row["category_created_at"], $row["category_updated_at"]),
            );
        }

        return $results;
    }


    public static function searchByPrice(int $price_min, int $price_max, int $limit, int $offset, $order)
    {
        if (!self::checkLimitAndOffset($limit, $offset)) {
            return false;
        }

        if (!in_array($order, array("DESC", "ASC"))) {
            return false;
        }

        $connection = Db::connect();
        $statement =
            "SELECT 
               books.id as book_id,
        books.created_at as book_created_at,
        books.updated_at as book_updated_at,
        books.title as book_title,
        books.author  as book_author,
        books.collection as book_collection,
        books.price as book_price,
        books.publication_year as book_year,
        books.category_id as book_category_id,
        books.image_path as book_image_path,
        books.description as book_description,
        books.tva_id as book_tva_id,  
        categories.name as category_name,
        categories.id as category_id,
        categories.created_at as category_created_at,
        categories.updated_at as category_updated_at
        FROM books 
        JOIN categories ON books.category_id = categories.id
        WHERE books.price BETWEEN ? AND ?
        LIMIT $limit OFFSET $offset
        ORDER BY books.price $order";
        $prepared_statement = $connection->prepare($statement);
        $prepared_statement->execute(
            array($price_min, $price_max)
        );
        $results = [];
        while ($row =  $prepared_statement->fetch()) {
            $results[] = array(
                "book" => new Book(
                    $row["book_title"],
                    $row["book_author"],
                    $row["book_collection"],
                    $row["book_price"],
                    $row["book_year"],
                    $row["book_image_path"],
                    $row["book_description"],
                    $row["book_category_id"],
                    $row["book_tva_id"],
                    $row["book_id"],
                    $row["book_created_at"],
                    $row["book_updated_at"]
                ),
                "category" => new Category($row["category_name"], $row["category_id"], $row["category_created_at"], $row["category_updated_at"]),
            );
        }

        return $results;
    }


    public function createStripeDetails()
    {   
        $connection = Db::connect();
        $statement = "INSERT INTO stripe_details (book_id,stripe_product_id,stripe_price_id) VALUES (?,?,?)";
        $prepared_statement = $connection->prepare($statement);
        return $prepared_statement->execute(array($this->book_id, $this->stripe_product_id,$this->stripe_price_id));
    }


    public function getStripePriceId()
    {
        return $this->stripe_price_id;

    }

    public function setStripeProductId()
    {

        $stripe = new AppStripe(STRIPE_SECRET_KEY);
        $stripe_obj = $stripe->createProduct($this->title);
        $this->stripe_product_id = $stripe_obj->id;
        return $this->stripe_product_id;
    }


    public function setStripePriceId($quantity, $currency_symbol = 'eur')
    {
        $stripe = new AppStripe(STRIPE_SECRET_KEY);
        $stripe_obj= $stripe->createPrice($this->stripe_product_id, $quantity, $currency_symbol);
        $this->stripe_price_id = $stripe_obj->id;
        return $this->stripe_price_id;

    }

    public function getStripeProductId()
    {
        return $this->stripeProductId;
    }
}
