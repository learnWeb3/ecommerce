<?php

class SessionController extends ApplicationController
{

    public function new()
    {
        $this->render("new", "Bienvenue", "La Nuit des temps: librairie engagée de proximitée");
    }

    public function create()
    {

        if (isset($_POST['user_email'],$_POST['user_password']))
        {  
            User::signIn();
        }
    }
}
