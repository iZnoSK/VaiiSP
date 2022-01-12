<?php

namespace App;

class Auth
{
    const LOGIN = "admin@admin.sk";
    const PASSWORD = "admin";

    public static function login($login, $password)
    {
        if ($login == self::LOGIN && $password == self::PASSWORD)
        {
            //názov sessionu = meno používateľa
            $_SESSION['name'] = $login;
            return true;
        }
        else
        {
            return false;
        }
    }

    //funkcia na zistenie, či je človek prihlásený
    public static function isLogged()
    {
        return isset($_SESSION['name']);
    }

    //odhlási používateľa
    public static function logout()
    {
        unset($_SESSION['name']);
        session_destroy();
    }
}