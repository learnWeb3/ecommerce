<?php

class User extends DbRecords
{
    // ATTRIBUTES
    protected $email;
    protected $password;
    protected $admin;

    protected $firstname;
    protected $lastname;
    protected $date_of_birth;
    protected $age;

    // CONSTRUCTOR
    public function __construct($email = null, $password = null, $admin = null, $firstname = null, $lastname = null, $date_of_birth = null, $id = null, $created_at = null, $updated_at = null)
    {

        if ($email != null) {
            $this->email = $email;
        }
        if ($password != null) {
            $this->password = $password;
        }
        if ($firstname != null) {
            $this->firstname = $firstname;
        }
        if ($lastname != null) {
            $this->lastname = $lastname;
        }
        if ($date_of_birth != null) {
            $this->date_of_birth = $date_of_birth;
        }
        if ($admin != null) {
            $this->admin = $admin;
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
            if (password_verify($password, $potential_user->getpassword())) {
                $_SESSION['current_user'] = $potential_user;
                return array("message" => array("user successfully connected"), "type" => "success");
            } else {
                return array("message" => array("user password is not correct"), "type" => "danger");
            }
        } else {
            return array("message" => array("user does not exists"), "type" => "danger");
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


    public function getAdmin()
    {
        return intval($this->admin);
    }

    public function getFirstname()
    {
        return htmlspecialchars($this->firstname);
    }

    public function getLastname()
    {
        return htmlspecialchars($this->lastname);
    }


    public function getDateOfBirth()
    {
        return htmlspecialchars($this->date_of_birth);
    }

    public function getAge()
    {
        return intval($this->age);
    }



    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
        return $this;
    }

    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
        return $this;
    }


    public function setDateOfBirth($date_of_birth)
    {
        $this->date_of_birth = $date_of_birth;
        return $this;
    }


    private function createUser()
    {
        $connection = Db::connect();

        $statement = "INSERT INTO users (email,password) VALUES (?,?)";

        $prepared_statement  = $connection->prepare($statement);

        $prepared_statement->execute(array($this->getEmail(), password_hash($this->getPassword(), PASSWORD_BCRYPT)));

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

        return array("message" => array("user signed out successfully"), "type" => "success");
    }


    public function loadSavedBasket()
    {
        $basket = Basket::findCurrentOwnerBasket($this->getId(), "current");
        // storing basket with all products in session
        $basket->storeInSession();
    }


    public function makeRecommendation(int $book_id, string $comment)
    {
        $connection = Db::connect();
        $statement = "INSERT INTO recommended_books (book_id,user_id,comment) VALUES (?,?,?)";
        $prepared_statement = $connection->prepare($statement);
        if ($prepared_statement->execute(array($book_id, $this->getId(), $comment))) {
            $select_statement = "SELECT * FROM recommended_books WHERE user_id=? AND book_id=? LIMIT 1 ORDER BY created_at DESC";
            $prepared_statement = $connection->prepare($select_statement);
            $prepared_statement->execute(array($this->getId(), $book_id));
            return $prepared_statement->fetchAll(PDO::FETCH_ASSOC);
        } else {
            return array();
        }
    }

    public function makeCoupDeCoeur(int $book_id, string $comment)
    {
        $connection = Db::connect();
        $statement = "INSERT INTO coup_de_coeur_books (book_id,user_id,comment) VALUES (?,?,?)";
        $prepared_statement = $connection->prepare($statement);
        if ($prepared_statement->execute(array($book_id, $this->getId(), $comment))) {
            $select_statement = "SELECT * FROM coup_de_coeur_books WHERE user_id=? AND book_id=? LIMIT 1 ORDER BY created_at DESC";
            $prepared_statement = $connection->prepare($select_statement);
            $prepared_statement->execute(array($this->getId(), $book_id));
            return $prepared_statement->fetchAll(PDO::FETCH_ASSOC);
        } else {
            return array();
        }
    }


    public function isUserAdmin()
    {
        return $this->getAdmin();
    }


    public static function checkIfAdresseExists($address, $user_id)
    {
        $connection = Db::connect();
     
        $select_statement = "SELECT * FROM adresses WHERE adress=? AND user_id=?";
        $prepared_statement = $connection->prepare($select_statement);
        $prepared_statement->execute(array($address, $user_id));
        $results = $prepared_statement->fetchAll(PDO::FETCH_ASSOC);
        return !empty($results);
    }

    public function registerAdress(string $city, string $address, string $postal_code)
    {
        $connection = Db::connect();
        $statement = "INSERT INTO adresses (city,adress,postal_code,user_id) VALUES (?,?,?,?)";
        $prepared_statement = $connection->prepare($statement);
        $prepared_statement->execute(array($city, $address, $postal_code, $this->getId()));
        $select_statement = "SELECT * FROM adresses WHERE user_id=? ORDER BY created_at DESC LIMIT 1";
        $prepared_statement = $connection->prepare($select_statement);
        $prepared_statement->execute(array($this->getId()));
        return $prepared_statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateDatas($firstname = null, $lastname = null, $date_of_birth = null)
    {
        if ($firstname != null) {
            $this->setFirstname($firstname);
        }
        if ($lastname != null) {
            $this->setLastname($lastname);
        }
        if ($date_of_birth != null) {
            $this->setDateOfBirth($date_of_birth);
        }
        if (func_get_args() != null) {
            $this->update();
        }
    }


    public function getAdresses()
    {
        $connection = Db::connect();
        $select_statement = "SELECT * FROM adresses WHERE user_id=? ORDER BY created_at DESC";
        $prepared_statement = $connection->prepare($select_statement);
        $prepared_statement->execute(array($this->getId()));
        return $prepared_statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function findAdress($adress_id)
    {
        $connection = Db::connect();
        $select_statement = "SELECT * FROM adresses WHERE id=?";
        $prepared_statement = $connection->prepare($select_statement);
        $prepared_statement->execute(array(intval($adress_id)));
        return $prepared_statement->fetchAll(PDO::FETCH_ASSOC);
    }
}
