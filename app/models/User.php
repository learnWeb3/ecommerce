<?php 

class User extends DbRecords
{
    protected $email;
    protected $password;

    protected $first_name;
    protected $last_name;
    protected $date_of_birth;
    protected $age;

    public function __construct( $email=null, $password=null,$first_name=null,$last_name=null, $date_of_birth = null, $id = null, $created_at = null, $updated_at = null)
    {

        if ($email != null && $password != null)
        {
            $this->email= $email;
            $this->password=$password;
        }
        if ($first_name!=null) {
            $this->first_name = $first_name;
        }
        if ($last_name!=null) {
            $this->last_name = $last_name;
        }
        if ($date_of_birth!=null) {
            $this->date_of_birth = $date_of_birth;
        }

        parent::__construct($id, $created_at, $updated_at);
    }



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
            books.category_id as book_category_id
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
        while($row = $prepared_statement->fetch())
        {
            $results[]= array(
                "book"=>new Book($row['book_title'],$row['book_author'],$row['book_collection'],$row['book_price'],$row['book_publication_year'], $row['book_image_path'],$row['book_descripton'],$row['book_id'],$row['book_created_at'],$row['book_updated_at']),
                "category"=>new Category($row['category_name'], $row['category_id'],$row['category_created_at'],$row['category_updated_at'])
            );

        }

        return $results;
        
    }

}