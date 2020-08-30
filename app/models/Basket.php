<?php

class Basket
{

    protected $user_id;
    protected $book_id;
    protected $state_id;

    use Db;


    public function getUserId()
    {
        return intval($this->user_id);
    }

    public function getBookId()
    {
        return intval($this->book_id);
    }

    public function getStateId()
    {
        return intval($this->state_id);
    }


    public function getContent()
    {
        $connection = Db::connect();
        $statement = 
        
        "SELECT 
            -- CATEGORIES
            categories.id as category_id,
            categories.name as category_name,
            categories.created_at as category_created_at,
            categories_updated_at as category_updated_at,
            -- BOOKS
            books.id as book_id,
            books.created_at as book_created_at,
            books.updated_at as book_updated_at
            books.title as book_title,
            books.author as book_author,
            books.collection as books_collection,
            books.description as book_description,
            books.price as book_price,
            books.publication_year as book_publication_year
            books.image_path as book_image_path,
            books.category_id as book_category_id,
        FROM baskets 
            JOIN users ON baskets.user_id=users.id 
            JOIN books ON books.id=baskets.book_id 
            JOIN states ON states.id=baskets.state_id 
        WHERE states.name = 'current'";

        $query = $connection->query($statement);

        $results = [];
        while($row = $query->fetch())
        {
            $results[]= array(
                "book"=>new Book($row['book_title'],$row['book_author'],$row['book_collection'],$row['book_price'],$row['book_publication_year'], $row['book_image_path'],$row['book_descripton'],$row['book_id'],$row['book_created_at'],$row['book_updated_at']),
                "category"=>new Category($row['category_name'])
            );

        }

        return $results;

        
    }
}
