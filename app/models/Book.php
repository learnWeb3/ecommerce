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
        return intval($this->category_id);
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
        $this->ht_price = number_format($this->price * (1 - $this->getTva()), 2);
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
        JOIN stocks ON books.id = stocks.book_id
        WHERE stocks.quantity >= 1
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
        categories.updated_at as category_updated_at,
        users.firstname as user_firstname,
        users.lastname as user_lastname,
        users.email as user_email,
        users.password as user_password,
        users.admin as user_admin,
        users.id as user_id,
        users.created_at as user_created_at,
        users.updated_at as user_updated_at,
        recommended_books.comment as recommended_books_comment
        FROM books 
        JOIN categories ON books.category_id = categories.id
        JOIN recommended_books ON recommended_books.book_id = books.id
        JOIN stocks ON books.id = stocks.book_id
        JOIN users ON users.id=recommended_books.user_id
        WHERE stocks.quantity >= 1
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
                "user" => new User($row["user_email"],$row["user_password"],$row["user_admin"], null, $row["user_firstname"], $row["user_lastname"], null, $row["user_id"], $row["user_created_at"], $row["user_updated_at"]),
                "recommended_books_comment"=>$row['recommended_books_comment']
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
        users.password as user_password,
        users.admin as user_admin,
        users.id as user_id,
        users.created_at as user_created_at,
        users.updated_at as user_updated_at,
        coup_de_coeur_books.comment as coup_de_coeur_books_comment
        FROM books 
        JOIN categories ON books.category_id = categories.id
        JOIN coup_de_coeur_books ON coup_de_coeur_books.book_id = books.id
        JOIN users ON coup_de_coeur_books.user_id = users.id
        JOIN stocks ON books.id = stocks.book_id
        WHERE stocks.quantity >= 1
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
                "user" => new User($row["user_email"],$row["user_password"],$row["user_admin"], null, $row["user_firstname"], $row["user_lastname"], null, $row["user_id"], $row["user_created_at"], $row["user_updated_at"]),
                "coup_de_coeur_books_comment"=>$row["coup_de_coeur_books_comment"]
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
        JOIN stocks ON books.id = stocks.book_id
        WHERE stocks.quantity >= 1
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
            "authorized_columns" => array(
                "book_title" => "books.title",
                "book_author" => "books.description",
                "book_collection" => "books.collection",
                "book_category" => "categories.name",
                "book_category_id" => "books.category_id",
                "book_description" => "books.description",
                "book_created_at" => "books.created_at",
                "book_updated_at" => "books.updated_at"
            ),
            "authorized_order" => array("DESC", "ASC")
        );
        if (!self::checkLimitAndOffset($limit, $offset)) {
            return false;
        }


        if (!in_array($column_name, array_keys($authorized_values["authorized_columns"])) || !(in_array($order_column, array_keys($authorized_values["authorized_columns"]))) || !in_array($order, array_keys($authorized_values["authorized_order"]))) {
            return false;
        }

        $column_name =  $authorized_values["authorized_columns"][$column_name];

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
        JOIN stocks ON books.id = stocks.book_id
        WHERE $column_name = ? AND stocks.quantity >= 1
        ORDER BY $order_column $order
        LIMIT $limit OFFSET $offset";
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
            "authorized_columns" => array(
                "book_title" => "books.title",
                "book_author" => "books.description",
                "book_collection" => "books.collection",
                "book_category" => "categories.name",
                "book_description" => "books.description",
                "book_created_at" => "books.created_at",
                "book_updated_at" => "books.updated_at"
            ),
            "authorized_order" => array("DESC", "ASC")
        );


        if (!self::checkLimitAndOffset($limit, $offset)) {
            return false;
        }
        if (!in_array($column_name, array_keys($authorized_values["authorized_columns"])) || !(in_array($order_column, array_keys($authorized_values["authorized_columns"]))) || !in_array($order, $authorized_values["authorized_order"])) {
            return false;
        }

        $column_name =  $authorized_values["authorized_columns"][$column_name];
        $order_column = $authorized_values["authorized_columns"][$order_column];

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
        JOIN stocks ON books.id = stocks.book_id
        WHERE $column_name LIKE ? AND stocks.quantity >= 1
        ORDER BY $order_column $order
        LIMIT $limit OFFSET $offset";
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
        JOIN stocks ON books.id = stocks.book_id
        WHERE books.price BETWEEN ? AND ? AND stocks.quantity >= 1
        ORDER BY books.price $order
        LIMIT $limit OFFSET $offset";
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
        return $prepared_statement->execute(array($this->getId(), $this->stripe_product_id, $this->stripe_price_id));
    }


    public function getStripePriceId()
    {
        $connection = Db::connect();
        $statement = "SELECT * FROM stripe_details WHERE book_id=?";
        $prepared_statement = $connection->prepare($statement);
        $prepared_statement->execute(array(
            $this->getId()
        ));
        $stripe_price_id = $prepared_statement->fetchAll(PDO::FETCH_ASSOC)[0]['stripe_price_id'];
        $this->stripe_price_id = $stripe_price_id;
        return $this->stripe_price_id;
    }

    public function setStripePriceId($quantity, $currency_symbol = 'eur')
    {
        $stripe = new AppStripe(STRIPE_SECRET_KEY);
        $stripe_obj = $stripe->createPrice($this->stripe_product_id, $quantity, $currency_symbol);
        $this->stripe_price_id = $stripe_obj->id;
        return $this->stripe_price_id;
    }

    public function getStripeProductId()
    {
        $connection = Db::connect();
        $statement = "SELECT * FROM stripe_details WHERE book_id=?";
        $prepared_statement = $connection->prepare($statement);
        $prepared_statement->execute(array(
            $this->getId()
        ));
        $stripe_product_id = $prepared_statement->fetchAll(PDO::FETCH_ASSOC)[0]['stripe_product_id'];
        $this->stripe_porduct_id = $stripe_product_id;
        return $this->stripe_product_id;
    }

    public function setStripeProductId()
    {

        $stripe = new AppStripe(STRIPE_SECRET_KEY);
        $stripe_obj = $stripe->createProduct($this->title, $this->description, array($this->image_path));
        $this->stripe_product_id = $stripe_obj->id;
        return $this->stripe_product_id;
    }

    public static function destroyStripeDetails()
    {
        $statement = "DELETE FROM stripe_details";
        $connection = Db::connect();
        $connection->query($statement);
        $connection->query("ALTER TABLE stripe_details AUTO_INCREMENT=1");
        return true;
    }


    public static function searchLikeResultToJson($search_matches)
    {
        return  json_encode(array_map(function ($el) {
            return array("book" => $el['book']->getObjectVars(), "category" => $el['category']->getObjectVars());
        }, $search_matches));
    }

    // creating stock entry for a specific product
    public function setStock(int $quantity)
    {
        $connection = Db::connect();
        $statement = "INSERT INTO stocks (book_id,quantity) VALUES (?,?)";
        $prepared_statement = $connection->prepare($statement);
        $prepared_statement->execute(array($this->getId(), $quantity));
        return $this->getStock();
    }

    // fetching stock entry for a specific product
    public function getStock()
    {
        $connection = Db::connect();
        $id = $this->getId();
        $statement = "SELECT * FROM stocks WHERE book_id=?";
        $prepared_statement = $connection->prepare($statement);
        $prepared_statement->execute(array(
            $this->getId()
        ));

        $results = $prepared_statement->fetchAll(PDO::FETCH_ASSOC);
        if (!empty($results)) {
            return intval($results[0]["quantity"]);
        } else {
            return false;
        };
    }

    // updating stock entry for a specific product
    public function updateStock(int $quantity)
    {
        $connection = Db::connect();
        $id = $this->getId();
        $statement = "UPDATE stocks SET quantity=? WHERE book_id=?";
        $prepared_statement = $connection->prepare($statement);
        $prepared_statement->execute(array(
            $quantity,
            $this->getId()
        ));
        return $this->getStock();
    }


    public function checkAvailable(int $requested_quantity): bool
    {
        if ($this->getStock() >= $requested_quantity) {
            return true;
        } else {
            return false;
        }
    }

    public static function filterSearchMenu($category_id, $price_min,$price_max,$order_column,$order, $limit, $offset)
    {
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
        JOIN stocks ON books.id = stocks.book_id
        WHERE category_id = ? 
        AND stocks.quantity >= 1
        AND books.price BETWEEN ? AND ?
        ORDER BY books.$order_column $order
        LIMIT $limit OFFSET $offset";

        $prepared_statement = $connection->prepare($statement);

        $prepared_statement->execute(
            array(intval($category_id), intval($price_min), intval($price_max))
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
}
