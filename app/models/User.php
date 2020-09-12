<?php

class User extends DbRecords
{
    // ATTRIBUTES
    protected $email;
    protected $password;

    protected $first_name;
    protected $last_name;
    protected $date_of_birth;
    protected $age;

    // CONSTRUCTOR
    public function __construct($email = null, $password = null, $first_name = null, $last_name = null, $date_of_birth = null, $id = null, $created_at = null, $updated_at = null)
    {

        if ($email != null) {
            $this->email = $email;
        }
        if ($password != null) {
            $this->password = $password;
        }
        if ($first_name != null) {
            $this->first_name = $first_name;
        }
        if ($last_name != null) {
            $this->last_name = $last_name;
        }
        if ($date_of_birth != null) {
            $this->date_of_birth = $date_of_birth;
        }

        parent::__construct($id, $created_at, $updated_at);
    }


    // GET BASKET CONTENT FOR A SPECIFC USER
    public function getBasketContent()
    {
        $connection = Db::connect();
        $statement =

            "SELECT 
            -- CATEGORIES
            categories.id as category_id,
            categories.name as category_name,
            categories.created_at as category_created_at,
            categories.updated_at as category_updated_at,
            -- BOOKS
            books.id as book_id,
            books.created_at as book_created_at,
            books.updated_at as book_updated_at,
            books.title as book_title,
            books.author as book_author,
            books.collection as books_collection,
            books.description as book_description,
            books.price as book_price,
            books.publication_year as book_publication_year,
            books.image_path as book_image_path,
            books.category_id as book_category_id,
            -- TVA
            books.tva_id as book_tva_id,
        FROM users 
            JOIN baskets ON baskets.user_id=users.id 
            JOIN books ON books.id=baskets.book_id 
            JOIN categories ON categories.id=books.category_id
            JOIN states ON states.id=baskets.state_id 
        WHERE states.name = 'current'
        AND users.id= ?";

        $prepared_statement = $connection->prepare($statement);
        $prepared_statement->execute(array($this->getId()));

        $results = [];
        while ($row = $prepared_statement->fetch()) {
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
                "category" => new Category($row['category_name'], $row['category_id'], $row['category_created_at'], $row['category_updated_at'])
            );
        }

        return $results;
    }


    public static function signIn(string $email, string $password)
    {

        $potential_user = User::where("email", $email, "created_at");
        if (!empty($potential_user)) {
            $potential_user = $potential_user[0];
            if (password_verify($password, $potential_user->password)) {
                $_SESSION['current_user'] = $potential_user;
                return array("message" => "user successfully connected", "type" => "success");
            } else {
                return array("message" => "user password is not correct", "type" => "danger");
            }
        } else {
            return array("message" => "user does not exists", "type" => "info");
        }
    }


    public function signUp(string $password_confirmation)
    {
        $errors =  array_merge(Validator::validatePassword($this->password, $password_confirmation), Validator::validateEmail($this->email));
        if (empty($errors)) {
            if ($this->createUser()) {
                return array("message" => array("user account successfully created"), "type" => "success");
            }
        } else {
            return array("message" => $errors, "type" => "danger");
        }
    }


    public function getEmail()
    {
        return htmlspecialchars($this->email);
    }

    public function getPassword()
    {
        return htmlspecialchars($this->password);
    }



    private function createUser()
    {
        $connection = Db::connect();

        $statement = "INSERT INTO users (email,password) VALUES (?,?)";

        $prepared_statement  = $connection->prepare($statement);

        $prepared_statement->execute(array($this->getEmail(), $this->getPassword()));

        return $this->lastCreated();
    }


    public static function doesUserExists(string $email)
    {
        if (!empty(self::where("email", $email, "created_at"))) {
            return true;
        } else {
            return false;
        }
    }


    public static function isUserSignedIn()
    {
        return isset($_SESSION['current_user']);
    }


    public static function getCurrentUser()
    {
        return $_SESSION['current_user'];
    }

    public static function signOut()
    {
        unset($_SESSION["current_user"]);

        return array("message" => "user signed out successfully", "type" => "success");
    }


    public function loadSavedBasket()
    {
        $basket = Basket::findCurrentOwnerBasket($this->getId(), "current");
        // storing basket with all products in session
        $basket->storeInSession();
    }
}
