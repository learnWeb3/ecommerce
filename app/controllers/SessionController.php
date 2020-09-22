<?php

class SessionController extends ApplicationController
{

    public function new()
    {
        $this->render("new", "Bienvenue", "La Nuit des temps: librairie engagée de proximitée");
    }

    public function create()
    {

        if (isset($_POST['user_email'], $_POST['user_password'])) {

            $sign_in_attempt =  User::signIn($_POST['user_email'], $_POST['user_password']);

            if (isset($_SESSION['current_user'])) {
                $flash = new Flash($sign_in_attempt, "success");
                $controller = "home";
                $method = "index";
                User::getCurrentUser()->loadSavedBasket();
            } else {
                $flash = new Flash($sign_in_attempt, "danger");
                $controller = "user";
                $method = "new";
            }
            if (isset($_POST['remote'])) {
                echo json_encode($sign_in_attempt);
                die();
            } else {
                $flash->storeInSession();
                header("Location:" . REDIRECT_BASE_URL . "controller=$controller&method=$method");
            }
        }
    }

    public function destroy()
    {
        if (isset($_SESSION['current_user'])) {

            $user = User::getCurrentUser();

            $basket = Basket::getBasket();

            $basket_items = $basket->getAllProducts();

            if ($user->createBasket())
            {
                $user->saveBasketItems($basket_items);
            }else{
                $user->updateBasketItems($basket_items);
            }
    
            $user_session_destroy = User::signOut();
            if (isset($_POST['remote'])) {
                echo json_encode($user_session_destroy);
            }else{
                header("Location:".REDIRECT_BASE_URL."controller=home&method=index");
            }
        }
    }
}
