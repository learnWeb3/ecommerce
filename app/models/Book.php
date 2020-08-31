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


    // CONSTRUCTOR
    public function __construct($title = null, $author = null, $collection = null, $price = null, $publication_year = null, $image_path = null, $description = null, $category_id = null, $id = null, $created_at = null, $updated_at = null)
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
        }

        parent::__construct($id, $created_at, $updated_at);
    }


    public function getTitle()
    {
        return htmlspecialchars($this->title);
    }

    public function setTitle($title)
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

    public function setCollection($collection)
    {
        $this->collection = $collection;
        return $this;
    }


    public function getPrice()
    {
        return floatval($this->price);
    }

    public function setPrice($price)
    {
        $this->price = floatval($price);
        return $this;
    }


    public function getPublicationYear()
    {
        return strftime("%Y",  strtotime($this->publication_year));
    }

    public function setPublicationYear($publication_year)
    {
        $this->publication_year = $publication_year;
        return $this;
    }

    public function getImagePath()
    {
        return htmlspecialchars($this->image_path);
    }

    public function setImagePath($image_path)
    {
        $this->image_path = $image_path;
        return $this;
    }

    public function getDescription()
    {
        return htmlspecialchars($this->description);
    }

    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    public function getCategoryId()
    {
        return intval($this->category_Id);
    }

    public function setCategoryId($category_Id)
    {
        $this->category_Id = $category_Id;
        return $this;
    }


    public static function getMostRecentBoooks($limit, $offset)
    {
        
        if (!self::checkLimitAndOffset($limit, $offset))
        {
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
                "book" => new Book($row["book_title"], $row["book_author"], $row["book_collection"], $row["book_price"], $row["book_year"], $row["book_image_path"], $row["book_description"], $row["book_category_id"], $row["book_id"], $row["book_created_at"], $row["book_updated_at"]),
                "category" => new Category($row["category_name"], $row["category_id"], $row["category_created_at"], $row["category_updated_at"])
            );
        }

        return $results;
    }


    public static function getRecommendations($limit, $offset)
    {
         
        if (!self::checkLimitAndOffset($limit, $offset))
        {
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
                "book" => new Book($row["book_title"], $row["book_author"], $row["book_collection"], $row["book_price"], $row["book_year"], $row["book_image_path"], $row["book_description"], $row["book_category_id"], $row["book_id"], $row["book_created_at"], $row["book_updated_at"]),
                "category" => new Category($row["category_name"], $row["category_id"], $row["category_created_at"], $row["category_updated_at"])
            );
        }

        return $results;
    }


    public static function getCoupDeCoeur($limit, $offset)
    {
    
        if (!self::checkLimitAndOffset($limit, $offset))
        {
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
                "book" => new Book($row["book_title"], $row["book_author"], $row["book_collection"], $row["book_price"], $row["book_year"], $row["book_image_path"], $row["book_description"], $row["book_category_id"], $row["book_id"], $row["book_created_at"], $row["book_updated_at"]),
                "category" => new Category($row["category_name"], $row["category_id"], $row["category_created_at"], $row["category_updated_at"]),
                "user"=>new User($row["user_email"], null, $row["user_firstname"], $row["user_lastname"], null, $row["user_id"], $row["user_created_at"], $row["user_updated_at"])
            );
        }

        return $results;
    }


}
