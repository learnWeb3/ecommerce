<?php

class AdminController extends ApplicationController
{
    public function index()
    {

        // ajax call to fetch datas for pie chart
        if (isset($_GET['remote'], $_GET['highchart']))
        {
            echo Book::getBookCountPerCategory();
            die();
        }

        $view_name = "index";
        $title = "Administration";
        $description = "Gérer, créer, mettre à jour vos données";

        $start = isset($_GET['start']) ? $_GET['start'] : 0;
        $limit = isset($_GET['limit']) ? $_GET['limit'] : 25;
        $next = $start+$limit;
        $previous = $start - $limit > 0 ? $start-$limit : 0;


        if (isset($_GET['search_input'], $_GET['search_filter'])) {
            $column_name = $_GET['search_filter'];
            $value = $_GET['search_input'];
            $order_column = isset($_GET['sort_by']) ? $_GET["sort_by"] : "book_updated_at";
            $order = isset($_GET["order"]) ? $_GET["order"] : "DESC";

            $search_matches = Book::searchLike($column_name, $value, $limit, $start, $order_column, $order);

            if (isset($_GET['remote'])) {

                echo Book::resultToJson($search_matches,$_GET);

                die();
            }else{
                $books = $search_matches;
            }
        }else{

            $books = Book::getAllWithCategories($limit, $start);
            
        }

        $total_stock = Book::getTotalStock();
        $categories = Category::findAll("created_at");
        $tva_types =  Book::getAllTvaTypes();
        $vars = array("books" => $books, "categories" => $categories, "tva_types" => $tva_types, "next"=>$next, "previous"=>$previous,"limit"=>$limit, "total_stock"=>$total_stock);
        $this->render($view_name, $title, $description, $vars, true);

    }


    public function update()
    {
        if (isset($_POST['book_id'])) {
            $book = Book::find(intval($_POST['book_id']));
            $app_stripe = new AppStripe(STRIPE_SECRET_KEY);

            if (!empty($book)) {
                $book = $book[0];
                if (isset($_POST['book_image_path']) || isset($_POST['book_title']) || isset($_POST['book_description'])) {
                    $stripe_product_id = $book->getStripeProductId();
                    $app_stripe->updateProduct($stripe_product_id, $_POST['book_title'], $_POST['book_description'], [$_POST['book_image_path']]);
                }
                if (isset($_POST['book_category_id'])) {
                    $book->registerUpdate("category_id", intval($_POST['book_category_id']));
                } elseif (isset($_POST['book_tva_id'])) {
                    $book->registerUpdate("tva_id", intval($_POST['book_tva_id']));
                } elseif (isset($_POST['book_image_path'])) {
                    $book->registerUpdate("image_path", $_POST['book_image_path']);
                } elseif (isset($_POST['book_title'])) {
                    $book->registerUpdate("title", $_POST['book_title']);
                } elseif (isset($_POST['book_author'])) {
                    $book->registerUpdate("author", $_POST['book_author']);
                } elseif (isset($_POST['book_collection'])) {
                    $book->registerUpdate("collection", $_POST['book_collection']);
                } elseif (isset($_POST['book_description'])) {
                    $book->registerUpdate("description", $_POST['book_description']);
                } elseif (isset($_POST['book_stock'])) {
                    $book->updateStock(intval($_POST['book_stock']));
                } elseif (isset($_POST['book_price'])) {
                    $price = doubleval($_POST['book_price']);
                    $book->registerUpdate("price", $price);
                    $stripe_product_id = $book->getStripeProductId();
                    $stripe_price_id = $book->getStripePriceId();
                    $app_stripe->updatePrice($stripe_price_id, $stripe_product_id, 'eur', $price);
                }

                if (isset($_POST['remote'])) {
                    $book = $book->getBookAndRelatedDatas();
                    echo Book::resultToJson($book);
                } else {
                    $path = REDIRECT_BASE_URL . "controller=admin&method=index";
                    header("Location:" . $path);
                }
            } else {
                renderErrror(404);
            }
        }
    }

    public function destroy()
    {
        if (isset($_POST['book_id'])) {
            Book::destroy(intval($_POST['book_id']));
            if (isset($_POST['remote'])) {
                echo json_encode(array("book_id" => $_POST['book_id']));
            } else {
                $path = REDIRECT_BASE_URL . "controller=admin&method=index";
                header("Location:" . $path);
            }
        }
    }




}
