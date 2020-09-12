<?php 

class Session
{

    public static function init()
    {
        if (!isset($_SESSION))
        {
            session_start();
        }
    }

    public static function isUserSignedIn()
    {
        return isset($_SESSION['current_user']);
       
    }

    public static function getCurrenrUser()
    {
        return $_SESSION['current_user'];
    }




}