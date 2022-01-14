<?php

namespace App;

class Auth
{
    public static function login($login, $password)
    {
        $user = DatabaseValidator::checkIfUserExists($login);
        if($user) {
            if ($login == $user->getLogin() && password_verify($password, $user->getPassword()))
            {
                //názov sessionu = meno používateľa
                $_SESSION['name'] = $login;
                $_SESSION['id'] = $user->getId();
                return true;
            }
            else
            {
                return false;
            }
        }
        return false;
    }

    //funkcia na zistenie, či je človek prihlásený
    public static function isLogged()
    {
        return isset($_SESSION['name']);
    }

    //vráti login
    public static function getName()
    {
        return (Auth::isLogged() ? $_SESSION['name'] : "");
    }

    //vráti login (email)
    public static function getId()
    {
        return (Auth::isLogged() ? $_SESSION['id'] : "");
    }

    //odhlási používateľa
    public static function logout()
    {
        unset($_SESSION['name']);
        unset($_SESSION['id']);
        session_destroy();
    }
}