<?php


class UserController extends ApplicationController
{

    public function new()
    {
        $this->render("new", "Créer un compte", "La Nuit des temps: librairie engagée de proximitée vous propose des livres d'occasion en parfait état");
    }

    public function create()
    {
        if (isset($_POST['user_email'],,$_POST['user_password'],$_POST["user_password_confirmation"]))
        {
            $user = new User($_POST['user_email'],$_POST['user_password']);
            $user->signUp($_POST["user_password_confirmation"]);
        }
    }
}
