<?php 

class CategoryController
{
    public function index()
    {

        if (isset($_POST['remote']))
        {
            
        $categories = Category::findAll("created_at");
            echo json_encode(array_map(function($el){return $el->getObjectVars();}, $categories));
        }
    }
}