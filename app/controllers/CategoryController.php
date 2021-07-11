<?php

class CategoryController
{
    public function index()
    {

        if (isset($_POST['remote'])) {

            $categories = Category::findAll("created_at");
            echo json_encode(array_map(function ($el) {
                return $el->getObjectVars();
            }, $categories));
        }
    }


    public function create()
    {
        if (isset($_POST['category_name'])) {
            $category = new Category($_POST['category_name']);

            $category->create();

            $controller = "admin";
            $method = "index";

            $message = ["Categorie crée avec succès"];
            $type = "success";

            $alert = new Flash($message,$type);
            $alert->storeInSession();

            header("Location:" . REDIRECT_BASE_URL . "controller=$controller&method=$method");
        } else {
            renderError(403);
        }
    }


    public function delete()
    {
        if (isset($_POST['product_category_id'])) {
            
            Category::destroy(intval($_POST['product_category_id']));
            
            $controller = "admin";
            $method = "index";

            $message = ["Categorie supprimée avec succès"];
            $type = "success";

            $alert = new Flash($message,$type);
            $alert->storeInSession();

            header("Location:" . REDIRECT_BASE_URL . "controller=$controller&method=$method");
        } else {
            renderError(403);
        }
    }
}
