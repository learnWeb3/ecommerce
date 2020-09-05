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

                // echo json_encode(
                //     array(
                //         "book_image_path"=>,
                //         "book_id"=>,
                //         "book_catgeory_name"=>,
                //         "book_price"=>,
                //         "book_author"=>,
                //         "book_collection"=>,
                //         "book_pulication_year"=>,
                //         "book_category_id"=>,
                //     )
                // );
            }
        }
    }
}
