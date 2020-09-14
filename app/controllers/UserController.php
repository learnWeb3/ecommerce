<?php


class UserController extends ApplicationController
{

    public function new()
    {
        $this->render("new", "Créer un compte", "La Nuit des temps: librairie engagée de proximitée vous propose des livres d'occasion en parfait état");
    }

    public function create()
    {
        if (isset($_POST['user_email'],$_POST['user_password'],$_POST["user_password_confirmation"]))
        {
            $user = new User($_POST['user_email'],$_POST['user_password']);
            $sign_up_attempt =  $user->signUp($_POST["user_password_confirmation"]);
            if (isset($_SESSION['current_user'])) {
                $flash = new Flash($sign_up_attempt, "success");
                $controller = "home";
                $method = "index";
                User::getCurrentUser()->loadSavedBasket();
            } else {
                $flash = new Flash($sign_up_attempt, "danger");
                $controller = "user";
                $method = "new";
            }

            if (isset($_POST['remote'])) {
                echo json_encode($sign_up_attempt);
                die();
            } else {
                $flash->storeInSession();
                header("Location:" . REDIRECT_BASE_URL . "controller=$controller&method=$method");
            }
        }elseif(isset($_POST["user_password_check"], $_POST["user_password_confirmation"], $_POST['remote']))
        {   
                echo json_encode(array("message" => Validator::validatePassword($_POST["user_password_check"], $_POST["user_password_confirmation"]), "type" => "danger"));
        }
    }

    public function destroy()
    {
        if (isset($_SESSION['current_user'],$_POST['user_id']))
        {
            if (User::getCurrentUser()->getId() == intval($_POST['user_id']))
            {
                $user_destroy = User::destroy($_POST['user_id']);

                if (isset($_POST['remote']))
                {
                  
                }
            }
        }
    }

    public function edit()
    {
        $this->render("edit", "Metttre à jour mon profil", "Compte utilisateur, mise à jour", array());
    }
}
