<?php

class SessionController extends ApplicationController
{

    public function new()
    {
        $this->render("new", "Bienvenue", "La Nuit des temps: librairie engagée de proximitée");
    }

    public function create()
    {
    }
}
