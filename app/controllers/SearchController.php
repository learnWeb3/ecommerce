<?php

class SearchController
{
    public function new()
    {

        if (isset($_POST['search_input'], $_POST['search_filter'])) {
            $column_name = $_POST['search_filter'];
            $value = $_POST['search_input'];
            $limit = 10;
            $offset = 0;
            $order_column = "book_created_at";
            $order = "DESC";
            $search_matches = Book::searchLike($column_name, $value, $limit, $offset, $order_column, $order);
            
            if (isset($_POST['remote'])) {

                echo Book::resultToJson($search_matches);

            }
        }
    }
}
