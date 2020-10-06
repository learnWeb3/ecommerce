<?php

class User
{
    // ATTRIBUTES
    protected $email;
    protected $password;
    protected $admin;

    protected $firstname;
    protected $lastname;
    protected $date_of_birth;
    protected $age;


    // USING COMMON METHODS
    use Db;

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

        if ($id != null) {
            $this->id = $id;
        }

        if ($created_at != null) {
            $this->created_at = $created_at;
        }

        if ($updated_at != null) {
            $this->updated_at = $updated_at;
        }
    }


    // GETTERS ATTRIBUTES

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
        return intval(strftime("%Y", time())) - intval(strftime("%Y", $this->date_of_birth));
    }


    // SETTER ATTRIBUTES



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

    
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    public function setAdmin($admin)
    {
        $this->admin = intval($admin);
        return $this;
    }



    // SIGN IN UP OUT LOGIC


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



    public static function signOut()
    {
        unset($_SESSION["current_user"]);

        return array("message" => array("user signed out successfully"), "type" => "success");
    }


    // BASKET LOGIC


    // CREATING BASKET IN DB
    public function createBasket()
    {
        if ($this->hasNoCurrentBasket()) {
            $connection = Db::connect();
            $state_id = Basket::getStateId();
            $statement = "INSERT INTO baskets (user_id,state_id) VALUES (?,?)";
            $prepared_statement = $connection->prepare($statement);
            return $prepared_statement->execute(array($this->getId(), $state_id));
        } else {
            return false;
        }
    }

    // UPDATING DATABASE CURRENT BASKET CONTENT
    public function updateBasketItems($basket_items)
    {
        $basket_id = Basket::findBasketId($this->getId(), Basket::getStateId());
        Basket::destroyAllBasketItems($basket_id);
        $this->saveBasketItems($basket_items);
    }


    // CHECKING WETHER A CURRENT BASKET EXISTS IN DB
    public function hasNoCurrentBasket()
    {
        $connection = Db::connect();
        $state_id = Basket::getStateId();
        $statement = "SELECT id FROM baskets WHERE state_id=? AND user_id=?";
        $prepared_statement = $connection->prepare($statement);
        $prepared_statement->execute(array($state_id, $this->getId()));
        return empty($prepared_statement->fetchAll(PDO::FETCH_ASSOC));
    }


    public function loadSavedBasket()
    {
        $basket = Basket::findCurrentOwnerBasket($this->getId(), "current");
        // storing basket with all products in session
        $basket->storeInSession();
    }


    public function saveBasketItems($basket_items)
    {
        $connection = Db::connect();
        $basket_id = Basket::findBasketId($this->getId(), Basket::getStateId());
        $statement = "INSERT INTO basket_items (book_id, basket_id, quantity) VALUES (?,?,?)";
        $prepared_statement = $connection->prepare($statement);
        foreach ($basket_items as $basket_item) {
            $prepared_statement->execute(array($basket_item->getBookId(), $basket_id, $basket_item->getQuantity()));
        }
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


    // ADRESSES LOGIC
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





    // USER LOGIC CREATION / EXIST CHECK / UPDATE


    private function createUser()
    {
        $connection = Db::connect();

        $statement = "INSERT INTO users (email,password) VALUES (?,?)";

        $prepared_statement  = $connection->prepare($statement);

        $prepared_statement->execute(array($this->getEmail(), password_hash($this->getPassword(), PASSWORD_BCRYPT)));

        return $this->lastCreated();
    }


    public function updateDatas($firstname = null, $lastname = null, $date_of_birth = null, $email= null,$admin)
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
        if ($email != null) {
            $this->setEmail($email);
        }
        if ($admin != null) {
            $this->setAdmin($admin);
        }
        
        if (func_get_args() != null) {
            $this->update();
        }
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


    public function isUserAdmin()
    {
        return $this->getAdmin();
    }



    // BOOK LOGIC 

    // MAKING RECOMMENDATION
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

    // MAKING COUP DE COEUR
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


    // INVOICE LOGIC 

    public function getInvoices()
    {
        $connection = Db::connect();
        $statement = "SELECT 
        invoices.id as invoice_id, 
        invoices.basket_id as invoice_basket_id, 
        invoices.total_amount_ttc as invoice_total_amount_ttc,
        invoices.total_amount_ht as invoice_total_amount_ht,
        invoices.adress_id as invoice_adress_id,
        invoices.payment_intent_id as invoice_payment_id,
        invoices.id as invoice_id,
        invoices.created_at as invoice_created_at,
        invoices.updated_at as invoice_updated_at,
        adresses.id as adress_id,
        adresses.adress as adress_adress,
        adresses.city as adress_city,
        adresses.postal_code as adress_postal_code,
        COUNT(basket_items.id) as product_count
        FROM invoices 
        JOIN baskets ON baskets.id=invoices.basket_id
        JOIN basket_items ON baskets.id = basket_items.basket_id
        JOIN users ON users.id=baskets.user_id
        JOIN adresses ON adresses.id = invoices.adress_id
        WHERE baskets.user_id=?
        GROUP  BY invoices.basket_id";
        $prepared_statement = $connection->prepare($statement);
        $prepared_statement->execute(array($this->getId()));

        $results = [];

        while ($row = $prepared_statement->fetch()) {
            $results[] = array(
                "invoice" => new Invoice($row['invoice_basket_id'], $row['invoice_total_amount_ttc'], $row['invoice_total_amount_ht'], $row['adress_id'], $row['invoice_payment_id'], $row['invoice_id'], $row['invoice_created_at'], $row['invoice_updated_at']),
                "invoice_item_count" => $row['product_count']
            );
        }


        return $results;
    }


    public static function getAllAndAddreses()
    {
        $connection = Db::connect();
        $statement = "SELECT * FROM users";

        $query = $connection->query($statement);

        $query->execute();

        $results = [];
        while ($row = $query->fetch()) {
            $user = new User(
                $row["email"],
                $row["password"],
                $row["admin"],
                $row["firstname"],
                $row["lastname"],
                $row["date_of_birth"],
                $row["id"],
                $row["created_at"],
                $row["updated_at"]
            );


            $results[] = array(
                "user" => $user,
                "adresses" => $user->getAdresses()
            );
        }

        return $results;
    }


    public static function getAccountCreationNumber($periodicity)
    {
        $connection = Db::connect();
        $to =  strftime("%Y-%m-%d %H:%M:%S",time()); // current time in epoch
        $from = strftime("%Y-%m-%d %H:%M:%S",time() - $periodicity * (24 * 60 * 60)); // to seconds 
        $statement = "SELECT 
        COUNT(id) AS user_account_creation_number
        FROM users WHERE created_at >= ? AND created_at <= ?";
        $prepared_statement = $connection->prepare($statement);
        $prepared_statement->execute(array($from, $to));

        return $prepared_statement->fetchAll(PDO::FETCH_ASSOC)[0];
    }

    public static function getUserAcquisitionData($periodicity)
    {
        $connection = Db::connect();
        $to =  strftime("%Y-%m-%d %H:%M:%S",time()); // current time in epoch
        $from = strftime("%Y-%m-%d %H:%M:%S",time() - $periodicity * (24 * 60 * 60)); // to seconds 
        $statement = "SELECT
        CONCAT(YEAR(created_at),'-', MONTH(created_at),'-',DAY(created_at)) as full_creation_date,
        COUNT(id) AS user_account_creation_number
        FROM users
        GROUP BY DAY(created_at), MONTH(created_at), YEAR(created_at)";
        $prepared_statement = $connection->prepare($statement);
        $prepared_statement->execute(array($from, $to));

        return json_encode($prepared_statement->fetchAll(PDO::FETCH_ASSOC));
    }

    public static function resultToJson($user)
    {
        return json_encode($user->getObjectVars());
    }
}
