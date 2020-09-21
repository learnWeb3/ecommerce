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

    public static function getCurrentUser()
    {
        return $_SESSION['current_user'];
    }


    public static function storeAddress($adress)
    {
      $_SESSION['address'] = $adress;
      return $_SESSION['address'];
    }




}