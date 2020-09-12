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


           $sign_in_attempt =  User::signIn($_POST['user_email'],$_POST['user_password']);

            if (isset($_POST['remote']))
            {
                
            }
        }
    }

    public function destroy()
    {
        if (isset($_SESSION['current_user'],$_POST['user_id']))
        {
            if (User::getCurrentUser()->getId() == intval($_POST['user_id']))
            {
                $user_session_destroy = User::signOut();

                if (isset($_POST['remote']))
                {
                   
                }
            }
        }
    }
}
