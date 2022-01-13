<?php

namespace App;

//TODO ci sa zadal dostatocny pocet znakov v hesle (aj na klientovi, aj na serveri)?
class FormValidator
{
    //TODO pozriet ako sa robi variabilny pocet premennych, poslat to a v cykle skontrolovat - univerzalne pre vsetky formulare?
    public static function emptyInputSignUp($login, $email, $password, $repeatedPassword) {
        if(empty(trim($login)) || empty(trim($email)) || empty(trim($password)) || empty(trim($repeatedPassword))) {
            return true;
        } else {
            return false;
        }
    }

    public static function emptyInputLogin($login,$password) {
        if(empty(trim($login))|| empty(trim($password))) {
            return true;
        } else {
            return false;
        }
    }

    //TODO skontrolovat ako sa robia tie regex veci?
    public static function invalidLogin($login) {
        if(!preg_match("/^[a-zA-Z0-9]*$/", $login)) {
            return true;
        } else {
            return false;
        }
    }

    public static function invalidEmail($email) {
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        } else {
            return false;
        }
    }

    public static function notMatchingPasswords($password, $repeatedPassword) {
        if($password !== $repeatedPassword) {
            return true;
        } else {
            return false;
        }
    }
}