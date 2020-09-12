<?php


class Validator
{
    
    public static function validatePassword(string $password,$password_confirmation)
    {

        $errors = [];
        preg_match_all("/[A-Z]+/", $password, $validate_capital_letters_presence);
        preg_match_all("/[0-9]+/", $password, $validate_numbers_presence);
        preg_match_all("/[^A-Za-z0-9\s]+/", $password, $validate_special_chars_presence);
        preg_match_all("/[ ]+/", $password, $validate_space_chars_presence);

        if (empty($validate_numbers_presence[0])) {
            $errors[] = "password must have at least one digit";
        }
        if (empty($validate_capital_letters_presence[0])) {
            $errors[] = "password must have at least one capital letter";
        }
        if (empty($validate_special_chars_presence[0])) {
            $errors[] = "password must have at least one special character";
        }
        if (!empty($validate_space_chars_presence[0])) {
            $errors[] = "password must not have any space char";
        }

        if ($password != $password_confirmation)
        {
            $errors[] = "passwords are not the same";
        }

       return $errors;

    }


    public static function validateNames(string $name, string $name_label)
    {

        $errors = [];
        preg_match_all("/[A-Za-z\-'éèàçù ]+/", $name, $validate_name);

    
        if (!$name == $validate_name[0]) {
            $errors[] = "$name_label is not a valid $name_label";
        }

        return $errors;
    
    }


    public static function validateEmail(string $email)
    {

        $errors = [];
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "$email is not a valid email";
        }

        return $errors;

    }





}

